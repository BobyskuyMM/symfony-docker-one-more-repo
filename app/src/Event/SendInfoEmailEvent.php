<?php

namespace App\Event;

use App\Entity\Company;
use App\Entity\CompanyEntityInterface;
use Symfony\Contracts\EventDispatcher\Event;

class SendInfoEmailEvent extends Event
{
    public const NAME = 'info.email';

    private $data;
    private $company;

    public function __construct(CompanyEntityInterface $company, array $data)
    {
        $this->company = $company;
        $this->data = $data;
    }

    public function getData() :array
    {
        return $this->data;
    }

    public function getCompany() :Company
    {
        return $this->company;
    }
}