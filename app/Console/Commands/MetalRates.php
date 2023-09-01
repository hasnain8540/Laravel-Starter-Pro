<?php

namespace App\Console\Commands;

use App\Models\MetalRate;
use Illuminate\Console\Command;

class MetalRates extends Command
{
    protected $signature = 'metalrate:update';

    protected $description = 'Update Silver metal rates from an online source';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $this->handle();
    }

    public function handle()
    {
        $this->info('Updating Metal Silver Rate ...');
        $responce = $this->request("https://current-precious-metal-price.p.rapidapi.com/metals/v1/1", [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: current-precious-metal-price.p.rapidapi.com",
                "x-rapidapi-key: f948c0249bmsh0955e6566c5e2f7p1694c4jsn4a9e70cf9845"
            ],
        ]);
        if ($responce != null) {
            MetalRate::create([
                "name" => "silver",
                "code" => "s925",
                "rate" => $responce,
            ]);
            return true;
        } else {
            $this->error('No responce While update rate for Silver');
            return 0;
        }
    }

    /**
     * Make the request to the sever.
     *
     * @param $url
     *
     * @return string
     */
    private function request($url, $headers = [])
    {

        $ch = curl_init($url);
        foreach ($headers as $name => $h) {
            curl_setopt($ch, $name, $h);
        }

        $response = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            $this->error('Can\'t update rate for Silver' . $err);
            return NULL;
        }

        curl_close($ch);

        return $response;
    }
}
