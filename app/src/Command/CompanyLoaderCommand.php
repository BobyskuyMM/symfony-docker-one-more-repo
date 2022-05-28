<?php

namespace App\Command;

use App\Repository\CompanyRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CompanyLoaderCommand extends Command
{
    protected static $defaultName = 'app:company-load';
    protected static $defaultDescription = 'Add a short description for your command';

    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    public function __construct(
        EntityManagerInterface     $entityManager,
        CompanyRepositoryInterface $companyRepository,
        ParameterBagInterface      $params
    ) {
        $this->entityManager = $entityManager;
        $this->companyRepository = $companyRepository;
        $this->params = $params;

        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $companyList = json_decode(file_get_contents($this->getCompanySourceUrl()), true);

        foreach ($companyList as $item) {
            $this->entityManager->persist(
                $this->companyRepository->createFromRawData($item)
            );
        }

        $this->entityManager->flush();

        $io->success('Companies successfully parsed!');

        return Command::SUCCESS;
    }

    private function getCompanySourceUrl(): string
    {
        return $this->params->get('company_source_url');
    }
}
