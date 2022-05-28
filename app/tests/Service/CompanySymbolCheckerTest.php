<?php

namespace App\Tests\Service;

use Mockery;
use App\Service\CompanySymbolChecker;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CompanySymbolCheckerTest extends WebTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCheckSymbolWithEmptyResponse($symbol, $responseContent, $expected)
    {
        $response = Mockery::mock(ResponseInterface::class);
        $response
            ->expects('getContent')->with()
            ->andReturn(json_encode($responseContent))
            ->times(1)
        ;

        $httpClient = Mockery::mock(HttpClientInterface::class);
        $httpClient
            ->expects('request')
            ->withAnyArgs()
            ->andReturn($response)
            ->times(1)
        ;

        $parameterBag = Mockery::mock(ParameterBagInterface::class);
        $parameterBag
            ->expects('get')
            ->with('company_source_url')
            ->andReturn('company_source_url')
            ->times(1)
        ;

        $service = new CompanySymbolChecker($httpClient, $parameterBag);
        $actual = $service->checkSymbol($symbol);

        self::assertEquals($actual, $expected);
    }
    
    public function dataProvider() :array
    {
        return [
            ['GOOG', [['Symbol' => 'GOOG']] , true],
            ['GOOG', [['Symbol' => 'GOOGE']] , false],
            ['GOOG', [['Symbol' => '']] , false],
        ];
    }
}
