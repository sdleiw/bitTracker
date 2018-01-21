<?php

namespace App\PriceMappers;

/**
 * Class Bitfinex
 * @package App\PriceMappers
 */
class Bitfinex implements MapperInterface
{
    /**
     * @return array
     */
    public function getMapper(): array
    {
        return [
            'iot' => 'miota',
            'usd' => 'usdt'
        ];
    }
}
