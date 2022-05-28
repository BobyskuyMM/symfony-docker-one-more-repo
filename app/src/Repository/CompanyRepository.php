<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyEntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository implements CompanyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function add(Company $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Company $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function createFromRawData(array $rawData): CompanyEntityInterface
    {
        return (new Company())
            ->setName($rawData['Company Name'])
            ->setFinancialStatus($rawData['Financial Status'])
            ->setMarketCategory($rawData['Market Category'])
            ->setRoundLotSize($rawData['Round Lot Size'])
            ->setSecurityName($rawData['Security Name'])
            ->setSymbol($rawData['Symbol'])
            ->setTestIssue($rawData['Test Issue'])
        ;
    }

    public function findCompanyBySymbol(string $symbol): ?CompanyEntityInterface
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.symbol = :val')
            ->setParameter('val', $symbol)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
