<?php

namespace App\Service;

interface CompanySymbolCheckerInterface
{
    public function checkSymbol(string $symbol) :bool;
}