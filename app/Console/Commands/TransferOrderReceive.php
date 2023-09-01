<?php

namespace App\Console\Commands;

use App\Models\TransferOrder;
use App\Models\TransferOrderChild;
use DB;
use Illuminate\Console\Command;
use Exception;
use Log;


class TransferOrderReceive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transferOrder:receive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receive Transfer order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $transferOrders = TransferOrder::withCount('childs')->with([
                'childs' => function ($query) {
                    $query->where('type', 'Fullfield');
                },
                'groupTo.receivingLocation.inventories' => function ($query) {
                    $query->where('in', '>', 0);
                }
            ])->where('status', 3)->orWhere('status', 4)->get();
            foreach ($transferOrders as $transferOrder) {

                $partsIdsOnReceivingLac = $transferOrder->groupTo->receivingLocation->inventories->pluck('part_id')->toArray();
                foreach ($transferOrder->childs as $childs) {
                    if (!in_array($childs->part_id, $partsIdsOnReceivingLac)) {
                        $childs->update([
                            'type' => 'Receiving'
                        ]);
                    }
                }
//        refresing
                $receiveChildCount = TransferOrderChild::whereTransferOrderId($transferOrder->id)->whereType('Receiving')->count();
                if ($receiveChildCount == $transferOrder->childs_count) {
                    $transferOrder->update([
                        'status' => 6

                    ]);

                }
            }
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            Log::info($e->getMessage());
        }
    }
}
