<?php

namespace App\Struct;

/**
 * Class Bitfinex
 * @package App\Struct
 */
class Bitfinex extends BalanceStruct
{
    /**
     * @return string
     */
    public function getName():string
    {
        return 'bitfinex';
    }
}
