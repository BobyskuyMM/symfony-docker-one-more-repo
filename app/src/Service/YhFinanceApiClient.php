<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class YhFinanceApiClient implements YhFinanceApiClientInterface
{
    public const HISTORICAL_DATA_API_ENDPOINT = "/stock/v3/get-historical-data";
    private $httpClient;
    private $parameterBag;

    public function __construct(
        HttpClientInterface $httpClient,
        ParameterBagInterface $parameterBag
    ) {
        $this->httpClient = $httpClient;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param string $symbol
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchHistoricalData(string $symbol): array
    {
        $response = $this->httpClient->request(
            'GET',
            $this->getApiEndpointUrl(),
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-RapidAPI-Key' => $this->getApiKey(),
                ],
                'query' => [
                    'symbol' => $symbol,
                    'region' => 'US',
                ]
            ]
        );

        $responseBody = (string)$response->getContent();
        $result = json_decode($responseBody ?? '', true);
        if ($result === null) {
            throw new \Exception('Failed to parse http response into json');
        }

        return $result;
    }

    private function getApiKey() :string
    {
        return $this->parameterBag->get('yh_finance_api_key');
    }
    
    private function getApiEndpointUrl() :string
    {
        return sprintf(
            '%s%s',
            $this->parameterBag->get('yh_finance_api_url'),
            self::HISTORICAL_DATA_API_ENDPOINT
        );
    }
}
