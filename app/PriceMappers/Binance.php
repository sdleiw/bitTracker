<?php

namespace App\PriceMappers;

/**
 * Class Bitfinex
 * @package App\PriceMappers
 */
class Binance implements MapperInterface
{
    /**
     * @return array
     */
    public function getMapper(): array
    {
        return [
            'IOTA' => 'miota',
        ];
    }
}
