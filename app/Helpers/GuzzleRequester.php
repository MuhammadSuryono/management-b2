<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class GuzzleRequester
{
    protected $baseUrl = "";

    protected $client = null;

    protected $statusCode = null;

    protected $body = null;

    protected function _init()
    {
        if (empty($this->baseUrl)) {
            $this->baseUrl = env('BUDGET_SERVICE_URL');
        }

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 5.0,
            'Connection' => 'close',
            CURLOPT_FORBID_REUSE => true,
            CURLOPT_FRESH_CONNECT => true,
        ]);
    }

    public function setBaseUrl($baseUrl): GuzzleRequester
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function request($method, $uri, $options = []): GuzzleRequester
    {
        self::_init();

        try {
            $response = $this->client->request($method, $uri, $options);
            $this->statusCode = $response->getStatusCode();
            $this->body = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            if (env('APP_ENV') === 'local') {
                dd($e->getMessage());
            }
            abort(500, $e->getMessage());

        }

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): object
    {
        return $this->body;
    }

}
