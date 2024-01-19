<?php

namespace App\Controller;

use App\Entity\Log;
use App\Service\LogDeserializerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        $log = $this->doctrine->getRepository(Log::class)->findAll();
        
        foreach ($log as $log)
        {
            $log = $log->content;
        }

        $logDeserializerService = new LogDeserializerService();
        
        $logFormatted = $logDeserializerService->formatLogEntries($log);
        $logDeserialized = $logDeserializerService->deserializeLogs($logFormatted);

        

        return $this->render('dashboard/index.html.twig', [
            'logDeserialized' => $logDeserialized,
        ]);
    }
}
