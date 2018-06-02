<?php

namespace App\Transformer;

use App\Api\Binance\Client;
use App\Struct\Binance as Struct;
use App\PriceMappers\Binance as PriceMapper;

/**
 * Class Binance
 * @package App\Transformer
 */
class Binance extends Template
{
    /**
     * @var PriceMapper $priceMapper
     */
    protected $priceMapper;

    /**
     * Binance constructor.
     * @param Struct $struct
     * @param Client $client
     * @param PriceMapper $priceMapper
     */
    public function __construct(Struct $struct, Client $client, PriceMapper $priceMapper)
    {
        parent::__construct($struct, $client);

        $this->priceMapper = $priceMapper;
    }

    protected function processBalance($balance, $prices): array
    {
        $filteredAccount = $this->filterAccount($balance);
        $mapper = $this->priceMapper->getMapper();

        return array_map(function ($balance) use ($prices, $mapper) {
            $symbol = $balance->asset;
            if (array_key_exists($symbol, $mapper)) {
                $symbol = strtoupper($mapper[$symbol]);
            }
            $price = $prices[$symbol] ?? 0;
            $balance->usd = ($balance->free + $balance->locked) * $price;
            $balance->amount = $balance->free + $balance->locked;

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
            return ($balance->free && $balance->free > 0) || ($balance->locked && $balance->locked > 0);
        });
    }
}
