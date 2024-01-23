<?php

namespace App\Controller;

use App\Entity\Log;
use App\Service\MessageParserService;
use App\Service\LogDeserializerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(
        LogDeserializerService $logDeserializerService,
        MessageParserService $messageParserService
    ): Response
    {
        $logs = $this->doctrine->getRepository(Log::class)->findAll();
        
        foreach ($logs as $log) {
            $log = $log->getContent();
        }
        
        $logFormatted = $logDeserializerService->formatLogEntries($log);
        $logParsed = $logDeserializerService->deserializeLogs($logFormatted);

        foreach ($logParsed as $logs) {
            $logsMessage[] = $logs['message'];
        }

        foreach ($logsMessage as $logMessage) {
            $finalLogMessage[] = $messageParserService->parseLogLine($logMessage);
        }

        return $this->render('dashboard/index.html.twig', [
            'logFormatted' => $logFormatted,
            'messageFormatted' => $finalLogMessage
        ]);
    }
}
