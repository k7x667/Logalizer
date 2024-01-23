<?php

namespace App\Controller;

use App\Entity\Log;
use App\Service\RegisterDetailService;
use App\Service\LogDeserializerService;
use App\Service\LogParserService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request, LogDeserializerService $logDeserializerService): Response
    {
        $logs = $this->doctrine->getRepository(Log::class)->findAll();
        
        foreach ($logs as $log) {
            $log = $log->getContent();
        }
        
        $logFormatted = $logDeserializerService->formatLogEntries($log);
        
        $logParsed = $logDeserializerService->deserializeLogs($logFormatted);
        
        dd($logParsed);

        



        return $this->render('dashboard/index.html.twig', [
            'logDeserialized' => $logNormalized,
        ]);
    }
}
