<?php

namespace App\Http\ViewObjects;

use App\Struct\BalanceInterface;
use App\Transformer\TransformerInterface;

/**
 * Class Dashboard
 * @package App\Http\ViewObjects
 */
class Dashboard
{
    /** @var MarketPrice  */
    protected $marketPrice;

    /** @var Transformer $transformer */
    protected $transformer;

    /** @var Portfolio $portfolio */
    public $portfolio;

    /** @var Platform $platform */
    public $platform;

    /**
     * Account constructor.
     * @param MarketPrice $marketPrice
     * @param Portfolio $portfolio
     * @param Platform $platform
     * @param Transformer $transformer
     */
    public function __construct(
        MarketPrice $marketPrice,
        Portfolio $portfolio,
        Platform $platform,
        Transformer $transformer
    ) {
        $this->marketPrice = $marketPrice;
        $this->portfolio = $portfolio;
        $this->platform = $platform;
        $this->transformer = $transformer;
    }

    /**
     * @return Dashboard
     * @throws \Exception
     */
    public function getDashboard(): Dashboard
    {
        if (empty($this->transformer->transformers)) {
            throw new \Exception('no active transformers');
        }

        $prices = $this->marketPrice->fetchPrices();
        /** @var TransformerInterface $transformer */
        foreach ($this->transformer->transformers as $transformer) {
            /** @var BalanceInterface $balance */
            $balance = $transformer->transform($prices);
            $this->platform->addAccounts($balance);
            $this->portfolio->process($balance);
        }

        return $this;
    }
}
