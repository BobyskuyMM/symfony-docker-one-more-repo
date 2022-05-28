<?php

namespace App\Tests\Service;

use Mockery;
use App\Service\YhFinanceApiClient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class YhFinanceApiClientTest extends WebTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFetchHistoricalData($symbol, $responseContent, $expected)
    {
        $response = Mockery::mock(ResponseInterface::class);

        $response->expects('getContent')->with()
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
        $parameterBag->expects('get')->with('yh_finance_api_key')->andReturn('yh_finance_api_key')->times(1);
        $parameterBag->expects('get')->with('yh_finance_api_url')->andReturn('yh_finance_api_url')->times(1);

        $service = new YhFinanceApiClient($httpClient, $parameterBag);

        $actual = $service->fetchHistoricalData($symbol);

        self::assertEquals($actual, $expected);
    }


    public function testFetchHistoricalDataCheckThrow()
    {
        $response = Mockery::mock(ResponseInterface::class);

        $response->expects('getContent')->with()
            ->andReturn('')
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
        $parameterBag->expects('get')->with('yh_finance_api_key')->andReturn('yh_finance_api_key')->times(1);
        $parameterBag->expects('get')->with('yh_finance_api_url')->andReturn('yh_finance_api_url')->times(1);


        $this->expectException(\Exception::class);
        $service = new YhFinanceApiClient($httpClient, $parameterBag);
        $service->fetchHistoricalData('GOOG');
    }

    public function dataProvider() :array
    {
        return [
            ['GOOG', [], []],
            ['GOOG', ['some_data'], ['some_data']]
        ];
    }
}
