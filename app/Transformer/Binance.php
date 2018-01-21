<?php

namespace App\Transformer;

use App\Api\Binance\Client;
use App\Struct\Binance as Struct;

/**
 * Class Binance
 * @package App\Transformer
 */
class Binance extends Template
{
    /**
     * Binance constructor.
     * @param Struct $struct
     * @param Client $client
     */
    public function __construct(Struct $struct, Client $client)
    {
        parent::__construct($struct, $client);
    }

    protected function processBalance($balance, $prices): array
    {
        $filteredAccount = $this->filterAccount($balance);

        return array_map(function ($balance) use ($prices) {
            $symbol = $balance->asset;
            $balance->usd = $balance->free * $prices[$symbol];
            $balance->amount = $balance->free;

            return $balance;
        }, $filteredAccount);
    }

    /**
     * @param $binance
     * @return array
     */
    protected function filterAccount($binance): array
    {
        return array_filter($binance->balances, function ($balance) {
            return $balance->free && $balance->free > 0;
        });
    }
}
