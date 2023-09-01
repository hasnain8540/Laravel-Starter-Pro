<?php

namespace App\Console\Commands;

use App\Models\MetalRate;
use Illuminate\Console\Command;

class CurrenciesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencyrate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch currencies rates from an api and store it in db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function fire()
    {
        $this->handle();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */


    // fetch rate
    public function fetchRate($url)
    {
        $this->info('Fetching Api Records ...');
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
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

                // check in response if it contain the respected key
                $eur  = strpos($response, "EUR");
                $cny  = strpos($response, "CNY");
                $inr  = strpos($response, "INR");
                $brl  = strpos($response, "BRL");
                $thb  = strpos($response, "THB");
                $response = json_decode($response, true);
                print_r($response);
                $name = '';
                $code = '';
                $rate = '';
                if ($eur) {
                    $name = 'euro';
                    $code = 'EUR';
                    $rate = $response['rates']['EUR']['rate'];
                } else if ($cny) {
                    // renminbi
                    $name = 'ren';
                    $code = 'CNY';
                    $rate = $response['rates']['CNY']['rate'];
                } else if ($inr) {
                    // indian rupee
                    $name = 'ind';
                    $code = 'INR';
                    $rate = $response['rates']['INR']['rate'];
                } else if ($brl) {
                    // brazilian real
                    $name = 'braz';
                    $code = 'BRL';
                    $rate = $response['rates']['BRL']['rate'];
                } else if ($thb) {
                    // thai baht
                    $name = 'tha';
                    $code = 'THB';
                    $rate = $response['rates']['THB']['rate'];
                }
                MetalRate::create([
                    "name" => $name,
                    "code" => $code,
                    "rate" => $rate,
                ]);
            } else {
                // \log($err);
            }
        }
    }

    public function fetchEuroRate()
    {
        $url = "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from=USD&to=EUR&amount=1";
        $this->fetchRate($url);
    }

    public function fetchCnyRates()
    {
        $url = "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from=USD&to=CNY&amount=1";
        $this->fetchRate($url);
    }

    public function fetchInyRate()
    {
        $url = "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from=USD&to=INR&amount=1";
        $this->fetchRate($url);
    }
    public function fetchBrlRate()
    {
        $url = "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from=USD&to=BRL&amount=1";
        $this->fetchRate($url);
    }

    public function fetchThbRate()
    {
        $url = "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from=USD&to=THB&amount=1";
        $this->fetchRate($url);
    }
    public function handle()
    {
        $this->fetchEuroRate();
        $this->fetchCnyRates();
        $this->fetchInyRate();
        $this->fetchBrlRate();
        $this->fetchThbRate();
    }
}
