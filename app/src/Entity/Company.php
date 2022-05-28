<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company implements CompanyEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $financialStatus;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $marketCategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $securityName;

    /**
     * @ORM\Column(type="integer")
     */
    private $roundLotSize;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $symbol;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $testIssue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFinancialStatus(): ?string
    {
        return $this->financialStatus;
    }

    public function setFinancialStatus(string $financialStatus): self
    {
        $this->financialStatus = $financialStatus;

        return $this;
    }

    public function getMarketCategory(): ?string
    {
        return $this->marketCategory;
    }

    public function setMarketCategory(string $marketCategory): self
    {
        $this->marketCategory = $marketCategory;

        return $this;
    }

    public function getSecurityName(): ?string
    {
        return $this->securityName;
    }

    public function setSecurityName(string $securityName): self
    {
        $this->securityName = $securityName;

        return $this;
    }

    public function getRoundLotSize(): ?int
    {
        return  $this->roundLotSize;
    }

    public function setRoundLotSize(int $roundLotSize): self
    {
        $this->roundLotSize = $roundLotSize;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getTestIssue(): ?string
    {
        return $this->testIssue;
    }

    public function setTestIssue(string $testIssue): self
    {
        $this->testIssue = $testIssue;

        return $this;
    }
}
