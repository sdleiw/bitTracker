<?php

namespace App\Transformer;

use App\Api\HitBtc\Client;
use App\Struct\HitBtc as Struct;

/**
 * Class HitBtc
 * @package App\Transformer
 */
class HitBtc extends Template
{
    /**
     * HitBtc constructor.
     * @param Struct $struct
     * @param Client $client
     */
    public function __construct(Struct $struct, Client $client)
    {
        parent::__construct($struct, $client);
    }

    /**
     * @return mixed
     */
    protected function getBalanceFromApi()
    {
        $accountBalances = $this->client->getBalances();
        $tradingBalances = $this->client->getTradingBalances();

        return array_merge($tradingBalances, $accountBalances);
    }

    protected function processBalance($balanceRaw, $prices): array
    {
        $filteredAccount = $this->filterAccount($balanceRaw);

        return array_map(function ($balance) use ($prices) {
            $symbol = $balance->currency;
            $balance->usd = $balance->available * $prices[$symbol];
            $balance->amount = $balance->available;
            $balance->asset = $balance->currency;

            return $balance;
        }, $filteredAccount);
    }

    /**
     * @param $binance
     * @return array
     */
    protected function filterAccount($binance): array
    {
        return array_filter($binance, function ($balance) {
            return $balance->available && $balance->available > 0;
        });
    }
}
