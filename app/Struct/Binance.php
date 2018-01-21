<?php

namespace App\Struct;

/**
 * Class Binance
 * @package App\Struct
 */
class Binance extends BalanceStruct
{
    /**
     * @return string
     */
    public function getName():string
    {
        return 'binance';
    }
}
