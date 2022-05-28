<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CompanySymbolChecker implements CompanySymbolCheckerInterface
{
    private $httpClient;
    private $parameterBag;
    
    public function __construct(
        HttpClientInterface $httpClient,
        ParameterBagInterface $parameterBag
    ) {
        $this->httpClient = $httpClient;
        $this->parameterBag = $parameterBag;
    }

    public function checkSymbol(string $symbol) :bool
    {
        $response = $this->httpClient->request('GET', $this->getRequestUrl());

        $responseBody = $response->getContent();
        $companies = json_decode($responseBody ?? '', true);

        $result = false;
        foreach ($companies as $company) {
            if (strtoupper($symbol) === $company['Symbol']) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    private function getRequestUrl() :string
    {
        return $this->parameterBag->get('company_source_url');
    }
}