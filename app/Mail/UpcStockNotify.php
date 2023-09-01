<?php

namespace App\Mail;

use App\Models\Upc;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpcStockNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->upc=new Upc();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $upc_count=$this->upc->availables()->count();
        return $this->to('hassan.ikonic@gmail.com', "Hassan")->view('email.upcStockNotify')->with([
            'upc_count' => $upc_count,
            'heading' => "UPC Codes's Stock Alert",
            'text' => "UPC (Universal Product Codes)".(!$upc_count)?" are geting out of stock the remaining UPCs available to be assigned to Parts are ":"have got compleatly out of Stock.",
            'upc_create_url'=>route('upc.create'),
            'date'=>Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
