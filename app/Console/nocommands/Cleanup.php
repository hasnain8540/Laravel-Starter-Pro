<?php

namespace APP\Console;

use Illuminate\Console\Command;

class Cleanup extends Command
{
    protected $signature = 'currency:cleanup';

    protected $description = 'Cleanup currency cache';

    protected $currency;

    public function __construct()
    {
        $this->currency = app('currency');
        parent::__construct();
    }

    public function fire()
    {
        $this->handle();
    }

    public function handle()
    {
        // Clear cache
        $this->currency->clearCache();
        $this->comment('Currency cache cleaned.');

        // Force the system to rebuild cache
        $this->currency->getCurrencies();
        $this->comment('Currency cache rebuilt.');
    }
}
