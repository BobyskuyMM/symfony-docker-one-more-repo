<?php

namespace App\Service;

interface HistoricalDataInterface
{
    public function getHistoricalData(string $symbol, $startDate, $endDate) :array;
}
