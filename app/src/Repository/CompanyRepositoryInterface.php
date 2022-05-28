<?php

namespace App\Repository;

use App\Entity\CompanyEntityInterface;

interface CompanyRepositoryInterface
{
    public function createFromRawData(array $rawData) :CompanyEntityInterface;
    public function findCompanyBySymbol(string  $symbol) :?CompanyEntityInterface;
}