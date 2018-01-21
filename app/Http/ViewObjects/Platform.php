<?php

namespace App\Http\ViewObjects;

use App\Struct\BalanceInterface;

/**
 * Class Platform
 * @package App\Http\ViewObjects
 */
class Platform
{
    /** @var array $platforms */
    public $platforms;

    /**
     * @param BalanceInterface $balance
     */
    public function addAccounts(BalanceInterface $balance): void
    {
        $this->platforms[$balance->getName()] = $balance;
    }
}
