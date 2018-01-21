<?php

namespace App\Http\ViewObjects;

use App\Api\CoinMarketCap\Tickers;

/**
 * Class MarketPrice
 * @package App\Http\ViewObjects
 */
class MarketPrice
{
    /** @var array */
    protected $marketPrices;

    /** @var Tickers $tickerApi */
    protected $tickerApi;

    /**
     * Price constructor.
     * @param Tickers $tickerApi
     */
    public function __construct(Tickers $tickerApi)
    {
        $this->tickerApi = $tickerApi;
    }

    /**
     * @return array
     */
    public function fetchPrices():array
    {
        $tickerPrices = $this->tickerApi->fetch();
        foreach ($tickerPrices as $ticker) {
            $this->marketPrices[$ticker->symbol] = $ticker->price_usd;
        }

        return $this->marketPrices;
    }
}
