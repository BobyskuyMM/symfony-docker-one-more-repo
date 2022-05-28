<?php

namespace App\Tests\Service;

use App\Service\CompanyService;
use App\Service\YhFinanceApiClientInterface;
use Mockery;
use App\Service\YhFinanceApiClient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CompanyServiceTest extends WebTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGetHistoricalData($symbol, $responseContent, $startDate, $endDate, $expected)
    {
        $yhFinanceApiClient = Mockery::mock(YhFinanceApiClientInterface::class);
        $yhFinanceApiClient->expects('fetchHistoricalData')
            ->with($symbol)
            ->andReturn($responseContent)
            ->times(1);

        $service = new CompanyService($yhFinanceApiClient);

        $actual = $service->getHistoricalData($symbol, $startDate, $endDate);

        self::assertEquals($actual, $expected);
    }



    public function dataProvider() :array
    {
        return [
            [
                'GOOG',
                [
                    'prices' => [
                        [
                            'date' => strtotime('2021-01-01'),
                            'open' => 1,
                            'high' => 1,
                            'low'  => 1,
                            'close' => 1
                        ],
                        [
                            'date' => strtotime('2022-01-01'),
                            'open' => 1,
                            'high' => 1,
                            'low'  => 1,
                            'close' => 1
                        ],
                        [
                            'date' => strtotime('2022-02-01'),
                            'open' => 1,
                            'high' => 1,
                            'low'  => 1,
                            'close' => 1
                        ]
                    ],
                    'timeZone' => [
                        'gmtOffset' => 0
                    ]
                ],
                '2022-01-01',
                '2022-05-01',
                [
                    [
                        'date' => '2022-01-01',
                        'open' => 1,
                        'high' => 1,
                        'low'  => 1,
                        'close' => 1
                    ],
                    [
                        'date' => '2022-02-01',
                        'open' => 1,
                        'high' => 1,
                        'low'  => 1,
                        'close' => 1
                    ]
                ]
            ],            [
                'GOOG',
                [
                    'prices' => [
                        [
                            'date' => strtotime('2021-01-01'),
                            'open' => 1,
                            'high' => 1,
                            'low'  => 1,
                            'close' => 1
                        ],
                        [
                            'date' => strtotime('2022-01-01'),
                            'open' => 1,
                            'high' => 1,
                            'low'  => 1,
                            'close' => 1
                        ],
                        [
                            'date' => strtotime('2022-02-01'),
                            'open' => 1,
                            'high' => 1,
                            'low'  => 1,
                            'close' => 1
                        ]
                    ],
                    'timeZone' => [
                        'gmtOffset' => 0
                    ]
                ],
                '2020-01-01',
                '2020-05-01',
                []
            ],
        ];
    }
}
