<?php

namespace App\Controller;

use App\Event\SendInfoEmailEvent;
use App\Form\CompanyHistoricalDataSearchType;
use App\Repository\CompanyRepositoryInterface;
use App\Service\HistoricalDataInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(
        Request $request,
        CompanyRepositoryInterface $companyRepository,
        EventDispatcherInterface $eventDispatcher,
        HistoricalDataInterface $historicalDataService
    ): Response {
        $form = $this->createForm(CompanyHistoricalDataSearchType::class);
        $form->handleRequest($request);
        $chartData = [];
        $data = [];
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $chartData = $historicalDataService->getHistoricalData(
                $data['symbol'],
                $data['startDate'],
                $data['endDate']
            );
            $this->sendEmail($eventDispatcher, $companyRepository, $data);
        }

        return $this->renderForm('index/index.html.twig', [
            'form' => $form,
            'data' => $data,
            'chartData' => $chartData
        ]);
    }
    
    private function sendEmail($eventDispatcher, $companyRepository, $data) :void
    {
        $company = $companyRepository->findCompanyBySymbol($data['symbol']);
        $event = new SendInfoEmailEvent($company, $data);
        $eventDispatcher->dispatch($event, SendInfoEmailEvent::NAME);
    }
}
