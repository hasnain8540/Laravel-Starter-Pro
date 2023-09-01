<?php

namespace App\Console\Commands;

use App\Models\MetalRate;
use Illuminate\Console\Command;

class CnyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cnyrate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Cny Rates from an api and store it in db';

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
    public function fire()
    {
        $this->handle();
    }
    public function handle()
    {
        $this->info('Fetching CNY Api Records ...');
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from=USD&to=CNY&amount=1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: currency-converter5.p.rapidapi.com",
                "x-rapidapi-key: 2bbbe5a927msh0e86669b1dd6788p10afb1jsnf20b46d86b1a"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $res = json_decode($response, true);
            if (!empty($res['rates'])) {
                MetalRate::create([
                    "name" => 'renminbi',
                    "code" => 'CNY',
                    "rate" => $res['rates']['CNY']['rate'],
                ]);
            } else {
            }
        }
    }
}
