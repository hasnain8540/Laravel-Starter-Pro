<?php

namespace APP\Console\nocommands;

use DateTime;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update
                                {--e|exchangeratesapi : Get rates from ExchangeRatesApi.io}
                                {--o|openexchangerates : Get rates from OpenExchangeRates.org}
                                {--g|google : Get rates from Google Finance}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exchange rates from an online source';

    /**
     * Currency instance
     *
     * @var \Torann\Currency\Currency
     */
    protected $currency;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->currency = app('currency');

        parent::__construct();
    }

    /**
     * Execute the console command for Laravel 5.4 and below
     *
     * @return void
     * @throws \Exception
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        // Get Settings
        $defaultCurrency = $this->currency->config('default');



        if ($this->input->getOption('openexchangerates')) {
            if (! $api = $this->currency->config('api_key')) {
                $this->error('An API key is needed from OpenExchangeRates.org to continue.');

                return;
            }

            // Get rates from OpenExchangeRates
            return $this->updateFromOpenExchangeRates($defaultCurrency, $api);
        }
    }


    /**
     * Fetch rates from currency-converter5
     *
     * @param $defaultCurrency
     */
    private function updateFromCC5($defaultCurrency)
    {
        $this->info('Updating currency exchange rates from CC5...');

        foreach ($this->currency->getDriver()->all() as $code => $value) {
            // Don't update the default currency, the value is always 1
            if ($code === $defaultCurrency) {
                continue;
            }

            $response = $this->request('https://currency-converter5.p.rapidapi.com/currency/convert',[
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: currency-converter5.p.rapidapi.com",
                    "x-rapidapi-key: f948c0249bmsh0955e6566c5e2f7p1694c4jsn4a9e70cf9845"
                ],
            ]);

            if (Str::contains($response, 'bld>')) {
                $data = explode('bld>', $response);
                $rate = explode($code, $data[1])[0];

                $this->currency->getDriver()->update($code, [
                    'exchange_rate' => $rate,
                ]);
            } else {
                $this->warn('Can\'t update rate for ' . $code);
                continue;
            }
        }
    }

    /**
     * Make the request to the sever.
     *
     * @param $url
     *
     * @return string
     */
    private function request($url,$headers=[])
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($ch, CURLOPT_MAXCONNECTS, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        foreach($headers as $name => $h){
            curl_setopt($ch, $name, $h);
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
