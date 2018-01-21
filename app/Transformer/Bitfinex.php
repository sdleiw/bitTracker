<?php

namespace App\Transformer;

use App\Api\Bitfinex\Client;
use App\PriceMappers\Bitfinex as PriceMapper;
use App\Struct\Bitfinex as Struct;

/**
 * Class Bitfinex
 * @package App\Transformer
 */
class Bitfinex extends Template
{
    /** @var PriceMapper $priceMapper */
    protected $priceMapper;

    /**
     * Bitfinex constructor.
     * @param Struct $struct
     * @param Client $client
     * @param PriceMapper $priceMapper
     */
    public function __construct(Struct $struct, Client $client, PriceMapper $priceMapper)
    {
        parent::__construct($struct, $client);

        $this->priceMapper = $priceMapper;
    }

    /**
     * @param $balance
     * @param $prices
     * @return array
     */
    protected function processBalance($balance, $prices): array
    {
        $filteredBalance = $this->filterAccount($balance);
        $mapper = $this->priceMapper->getMapper();

        return array_map(function ($balance) use ($prices, $mapper) {
            $symbol = $balance->currency;
            if (array_key_exists($symbol, $mapper)) {
                $symbol = $mapper[$symbol];
            }
            $balance->usd = $balance->amount * $prices[strtoupper($symbol)];
            $balance->asset = strtoupper($balance->currency);

            return $balance;
        }, $filteredBalance);
    }

    /**
     * @param $balances
     * @return array
     */
    protected function filterAccount($balances): array
    {
        return array_filter($balances, function ($balance) {
            return $balance->amount && $balance->amount > 0;
        });
    }
}
