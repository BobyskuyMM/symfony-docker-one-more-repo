<?php

namespace App\Entity;

interface CompanyEntityInterface
{
    public function getSymbol() :?string;
    public function getName() :?string;
    public function setSymbol(string $symbol);
}
