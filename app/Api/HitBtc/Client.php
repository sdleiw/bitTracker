<?php

namespace App\Api\HitBtc;

use App\Api\ApiClientInterface;
use GuzzleHttp\RequestOptions;

/**
 * Class Client
 * @package App\Api\HitBtc
 */
class Client implements ApiClientInterface
{
    /** @var Client $client */
    protected $client;

    /** @var string $apiKey */
    protected $apiKey;

    /** @var string $apiSecret */
    protected $apiSecret;

    /**
     * Candlestick constructor.
     */
    public function __construct()
    {
        $this->apiKey = config('api.hitbtc.api-key');
        $this->apiSecret = config('api.hitbtc.api-secret');

        $this->client = new \GuzzleHttp\Client();
    }

    public function getBalances()
    {
        return $this->request('GET', '/account/balance');
    }

    public function getTradingBalances()
    {
        return $this->request('GET', '/trading/balance');
    }

    protected function request($method, $url)
    {
        $response = $this->client->request($method, 'https://api.hitbtc.com/api/2' . $url, [
            RequestOptions::AUTH => [
                $this->apiKey,
                $this->apiSecret,
            ]
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        if ($statusCode < 200 || $statusCode > 299) {
            throw new \Exception($content);
        }

        return json_decode($content);
    }
}
