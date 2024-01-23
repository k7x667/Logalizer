<?php

namespace App\Controller;

use App\Entity\Log;
use App\Service\MessageParserService;
use App\Service\LogDeserializerService;
use App\Service\NormalizerService;
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
        NormalizerService $normalizerService,
    ): Response
    {
        $logs = $this->doctrine->getRepository(Log::class)->findAll();
        
        foreach ($logs as $log) {
            $logContent[] = $log->getContent();
        }
        
        //$logFormatted = $logDeserializerService->formatLogEntries($log);
        //$logParsed = $logDeserializerService->deserializeLogs($logFormatted);
        $logFormatted = $normalizerService->parseLog($logContent);
        // dd($logFormatted);
        $messageFormatted = [];

        foreach ($logFormatted as $logForMessage) {
            $messageFormatted[] = $normalizerService->parseLogMessage($logForMessage['message']);
            
        }

        $logsNormalized = array_combine($logFormatted, $messageFormatted);
        
        dd($logsNormalized);

        return $this->render('dashboard/index.html.twig', [
            'logFormatted' => $logFormatted,
            'messageFormatted' => $finalLogMessage
        ]);
    }
}
