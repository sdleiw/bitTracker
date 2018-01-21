<?php

namespace App\Api\Bitfinex;

use App\Api\ApiClientInterface;
use GuzzleHttp\RequestOptions;

/**
 * Class Client
 * @package App\Api\Bitfinex
 */
class Client implements ApiClientInterface
{
    /** @var string $baseUrl */
    protected $baseUrl = 'https://api.bitfinex.com/v2/';

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
        $this->apiKey = config('api.bitfinex.api-key');
        $this->apiSecret = config('api.bitfinex.api-secret');

        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getBalances()
    {
        $mt = explode(' ', microtime());
        $req['nonce'] = $mt[1].substr($mt[0], 2, 6);
        $req['request'] = '/v1/balances';
        $postData = base64_encode(json_encode($req));
        $signature = hash_hmac('sha384', $postData, $this->apiSecret);

        $response = $this->client->request('POST', 'https://api.bitfinex.com/v1/balances', [
            RequestOptions::HEADERS => [
                'X-BFX-APIKEY' => $this->apiKey,
			    'X-BFX-PAYLOAD' => $postData,
			    'X-BFX-SIGNATURE' => $signature,
            ],
            RequestOptions::BODY => json_encode($req)
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        if ($statusCode < 200 || $statusCode > 299) {
            throw new \Exception($content);
        }

        return json_decode($content);
    }
}
