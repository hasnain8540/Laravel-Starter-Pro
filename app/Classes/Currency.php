<?php

namespace Classes\Currency;

use App\Models\Currency as ModelsCurrency;
use Cache;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Cache\Factory as FactoryContract;

class Currency
{
    protected $config = [];
    protected $user_currency;
    protected $currencies_cache;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Format given number.
     *
     * @param float  $amount
     * @param string $from
     * @param string $to
     * @param bool   $format
     *
     * @return string|null
     */
    public function convert($amount, $from = null, $to = null, $format = true)
    {
        // Get currencies involved
        $from = $from ?: $this->config('default');

        // Get exchange rates
        $from_rate = $this->getCurrencyProp($from, 'exchange_rate');
        $to_rate = $this->getCurrencyProp($to, 'exchange_rate');

        // Skip invalid to currency rates
        if ($to_rate === null) {
            return null;
        }

        try {
            // Convert amount
            if ($from === $to) {
                $value = $amount;
            } else {
                $value = ($amount * $to_rate) / $from_rate;
            }
        } catch (\Exception $e) {
            // Prevent invalid conversion or division by zero errors
            return null;
        }

        // Should the result be formatted?
        if ($format === true) {
            return $this->format($value, $to);
        }

        // Return value
        return $value;
    }

    /**
     * Format the value into the desired currency.
     *
     * @param float  $value
     * @param string $code
     * @param bool   $include_symbol
     *
     * @return string
     */
    public function format($value, $code = null, $include_symbol = true)
    {
        // Get default currency if one is not set
        $code = $code ?: $this->config('default');

        // Remove unnecessary characters
        $value = preg_replace('/[\s\',!]/', '', $value);

        // Get the measurement format
        $format = $this->getCurrencyProp($code, 'format');

        // Value Regex
        $valRegex = '/([0-9].*|)[0-9]/';

        // Match decimal and thousand separators
        preg_match_all('/[\s\',.!]/', $format, $separators);

        if ($thousand = Arr::get($separators, '0.0', null)) {
            if ($thousand == '!') {
                $thousand = '';
            }
        }

        $decimal = Arr::get($separators, '0.1', null);

        // Match format for decimals count
        preg_match($valRegex, $format, $valFormat);

        $valFormat = Arr::get($valFormat, 0, 0);

        // Count decimals length
        $decimals = $decimal ? strlen(substr(strrchr($valFormat, $decimal), 1)) : 0;

        // Do we have a negative value?
        if ($negative = $value < 0 ? '-' : '') {
            $value = $value * -1;
        }

        // Format the value
        $value = number_format($value, $decimals, $decimal, $thousand);

        // Apply the formatted measurement
        if ($include_symbol) {
            $value = preg_replace($valRegex, $value, $format);
        }

        // Return value
        return $negative . $value;
    }


    /**
     * Determine if the provided currency is valid.
     *
     * @param string $code
     *
     * @return array|null
     */
    public function hasCurrency($code)
    {
        return array_key_exists(strtoupper($code), $this->getCurrencies());
    }

    /**
     * Return the current currency if the
     * one supplied is not valid.
     *
     * @param string $code
     *
     * @return array|null
     */
    public function getCurrency($code = 'USD')
    {
        $code = $code ?: $this->config('default');

        return Arr::get($this->getCurrencies(), strtoupper($code));
    }

    /**
     * Return all currencies.
     *
     * @return array
     */
    public function getCurrencies()
    {
        $arr=[
            'USD',
            'EUR',
            'CNY',
            'INR',
            'BRL',
            'THB',
        ];

        if ($this->currencies_cache === null) {
            if (config('app.debug', false) === true) {
                //@TODO
                // get all currencyies lataest here
                $c=ModelsCurrency::latest();





                $this->currencies_cache = ModelsCurrency::all();
            } else {
                $this->currencies_cache = Cache::rememberForever('system.currency', function () {
                   //get all lateest currencies
                    return ModelsCurrency::all();
                });
            }
        }

        return $this->currencies_cache;
    }

      /**
     * Clear cached currencies.
     */
    public function clearCache()
    {
        $this->cache->forget('system.currency');
        $this->currencies_cache = null;
    }

    /**
     * Get configuration value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function config($key = null, $default = null)
    {
        if ($key === null) {
            return $this->config;
        }

        return Arr::get($this->config, $key, $default);
    }

    /**
     * Get the given property value from provided currency.
     *
     * @param string $code
     * @param string $key
     * @param mixed  $default
     *
     * @return array
     */
    protected function getCurrencyProp($code, $key, $default = null)
    {
        return Arr::get($this->getCurrency($code), $key, $default);
    }

    /**
     * Get a given value from the current currency.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return Arr::get($this->getCurrency(), $key);
    }


}
