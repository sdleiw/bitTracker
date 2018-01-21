<?php

namespace App\Api\CoinMarketCap;

use GuzzleHttp\RequestOptions;

/**
 * Class Tickers
 * @package App\Api\CoinMarketCap
 */
class Tickers extends AbstractApiClient
{
    /**
     * @deprecated
     *
     * @use $this->fetch()
     * @return array
     */
    public function fetchAll(): array
    {
        $response = $this->client->request('GET', 'ticker/?limit=0');

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function fetch($limit = 200): array
    {
        $query['limit'] = $limit;
        $response = $this->client->request('GET', 'ticker', [
            RequestOptions::QUERY => $query
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
