<?php

namespace App\Api\Binance;

use App\Api\ApiClientInterface;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;

/**
 * Class Account
 * @package App\Api\Bitfinex
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
        $this->apiKey = config('api.binance.api-key');
        $this->apiSecret = config('api.binance.api-secret');
        $this->client = new GuzzleClient([
            'headers' => ['X-MBX-APIKEY' => $this->apiKey],
            'http_errors' => false,
        ]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getBalances()
    {
        $query['recvWindow'] = 10000000;
        $query['timestamp'] = Carbon::now()->timestamp * 1000;
        $query['signature'] = hash_hmac('sha256', http_build_query($query), $this->apiSecret);
        $response = $this->client->request('GET', 'https://api.binance.com/api/v3/account', [
            RequestOptions::QUERY => $query
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        if ($statusCode < 200 || $statusCode > 299) {
            throw new \Exception($content);
        }

        return json_decode($content);
    }
}
