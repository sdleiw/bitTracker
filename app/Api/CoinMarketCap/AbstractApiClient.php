<?php

namespace App\Api\CoinMarketCap;

use GuzzleHttp\Client;

/**
 * Class AbstractApiClient
 * @package App\Api\CoinMarketCap
 */
abstract class AbstractApiClient
{
    /** @var string $baseUrl */
    protected $baseUrl = 'https://api.coinmarketcap.com/v1/';

    /** @var Client $client */
    protected $client;

    /**
     * Coins constructor.
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->baseUrl]);
    }
}
