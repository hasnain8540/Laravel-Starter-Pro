<?php

namespace APP\Console;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;

class Manage extends Command
{
    protected $signature = 'currency:manage
                                {action : Action to perform (add, update, or delete)}
                                {currency : Code or comma separated list of codes for currencies}';

    protected $description = 'Manage currency values';

    protected $currencies;

    public function __construct()
    {
        $this->currencies = include(__DIR__ . '/../../resources/currencies.php');
        parent::__construct();
    }

    public function fire()
    {
        $this->handle();
    }

    public function handle()
    {
        $action = $this->getActionArgument(['add', 'update', 'delete']);

        foreach ($this->getCurrencyArgument() as $currency) {
            $this->$action(strtoupper($currency));
        }
    }

    protected function add($currency)
    {
        if (($data = $this->getCurrency($currency)) === null) {
            $this->error("Currency \"{$currency}\" not found");
            return;
        }

        $this->output->write("Adding {$currency} currency...");

        $data['code'] = $currency;

        if (is_string($result = $this->storage->create($data))) {
            $this->output->writeln('<error>' . ($result ?: 'Failed') . '</error>');
        } else {
            $this->output->writeln("<info>success</info>");
        }
    }

    protected function update($currency)
    {
        if (($data = $this->getCurrency($currency)) === null) {
            $this->error("Currency \"{$currency}\" not found");
            return;
        }

        $this->output->write("Updating {$currency} currency...");

        if (is_string($result = $this->storage->update($currency, $data))) {
            $this->output->writeln('<error>' . ($result ?: 'Failed') . '</error>');
        } else {
            $this->output->writeln("<info>success</info>");
        }
    }

    protected function delete($currency)
    {
        $this->output->write("Deleting {$currency} currency...");

        if (is_string($result = $this->storage->delete($currency))) {
            $this->output->writeln('<error>' . ($result ?: 'Failed') . '</error>');
        } else {
            $this->output->writeln("<info>success</info>");
        }
    }


    protected function getCurrencyArgument()
    {
        // Get the user entered value
        $value = preg_replace('/\s+/', '', $this->argument('currency'));

        // Return all currencies if requested
        if ($value === 'all') {
            return array_keys($this->currencies);
        }

        return explode(',', $value);
    }

    protected function getActionArgument($validActions = [])
    {
        $action = strtolower($this->argument('action'));

        if (in_array($action, $validActions) === false) {
            throw new \RuntimeException("The \"{$action}\" option does not exist.");
        }

        return $action;
    }

    protected function getCurrency($currency)
    {
        return Arr::get($this->currencies, $currency);
    }
}
