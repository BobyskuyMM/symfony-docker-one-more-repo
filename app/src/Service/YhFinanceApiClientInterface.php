<?php

namespace App\Service;

interface YhFinanceApiClientInterface
{
    public function fetchHistoricalData(string $symbol) :array;
}