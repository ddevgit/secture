<?php


namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConversionCurrencyService
{
    protected $apiKey = "e532f4b799fec52e1107d185599c3e59";
    protected $base_url = "https://api.exchangeratesapi.io/v1/";
    protected $url_api = "https://api.exchangeratesapi.io/v1/latest
    ? access_key = ". "e532f4b799fec52e1107d185599c3e59";

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function get_authorisation_code()
    {
        $response = $this->client->request(
            'GET',
            $this->authorisation_url,
            [
                'query' => [
                    'response_type' => 'code',
                    'redirect_uri' => $this->redirect_uri,
                    'client_id' => $this->client_id,
                ]
            ]
        );

        return $response->getContent();


    }

}