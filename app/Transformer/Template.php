<?php

namespace App\Transformer;

use App\Api\ApiClientInterface;
use App\Struct\BalanceInterface;

/**
 * Class Template
 * @package App\Transformer
 */
abstract class Template implements TransformerInterface
{
    /** @var BalanceInterface $struct */
    protected $struct;

    /** @var ApiClientInterface $client */
    protected $client;

    /**
     * Template constructor.
     * @param BalanceInterface   $struct
     * @param ApiClientInterface $client
     */
    public function __construct(BalanceInterface $struct, ApiClientInterface $client)
    {
        $this->struct = $struct;
        $this->client = $client;
    }

    /**
     * @param array $prices
     * @return BalanceInterface
     */
    public function transform(array $prices): BalanceInterface
    {
        $balancesRaw = $this->getBalanceFromApi();
        $balances = $this->processBalance($balancesRaw, $prices);
        $this->struct->setBalance($balances);
        $this->struct->setSum($this->calculateSum($balances));

        return $this->struct;
    }

    abstract protected function processBalance($balanceRaw, $prices): array;

    /**
     * @return mixed
     */
    protected function getBalanceFromApi()
    {
        return $this->client->getBalances();
    }

    /**
     * @param array $balances
     * @return float
     */
    protected function calculateSum(array $balances): float
    {
        $sum = 0;
        foreach ($balances as $balance) {
            $sum += $balance->usd;
        }

        return $sum;
    }
}
