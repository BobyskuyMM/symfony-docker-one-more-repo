<?php

namespace App\Service;

class CompanyService implements HistoricalDataInterface
{
    private $yhFinanceApiClient;
    public const DATE_FORMAT = 'Y-m-d';

    public function __construct(YhFinanceApiClientInterface $yhFinanceApiClient)
    {
        $this->yhFinanceApiClient = $yhFinanceApiClient;
    }

    public function getHistoricalData(string $symbol, $startDate, $endDate): array
    {
        $rawData = $this->yhFinanceApiClient->fetchHistoricalData($symbol);

        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);

        $searchedItems = [];
        foreach ($rawData['prices'] as $item) {
            $priceTimestamp = (int)$item['date'] - $rawData['timeZone']['gmtOffset'];
            if ($priceTimestamp >= $startTimestamp && $priceTimestamp <= $endTimestamp) {
                $searchedItems[] = [
                    'date' => date(self::DATE_FORMAT, $item['date'] - $rawData['timeZone']['gmtOffset']),
                    'open' => $item['open'] ?? 0,
                    'high' => $item['high'] ?? 0,
                    'low' => $item['low'] ?? 0,
                    'close' =>$item['close'] ?? 0,
                ];
            }
        }

        return $searchedItems;
    }
}
