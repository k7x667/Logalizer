<?php

namespace App\Controller;

use App\Entity\Log;
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
        NormalizerService $normalizerService,
    ): Response
    {
        $logs = $this->doctrine->getRepository(Log::class)->findAll();
        
        foreach ($logs as $log) {
            $logContent[] = $log->getContent();
        }
        
        
        $logsFormatted[] = $normalizerService->formatLogEntries($logContent);

        

        foreach ($logsFormatted as $logFormatted) {
            $logsParsed[] = $normalizerService->parseLog($logFormatted);
        }

        foreach ($logsParsed[0] as $logParsed) {
            $msgFormatted[] = $normalizerService->parseLogMessage($logParsed['message']);
        }

        $fullLogs = array_slice($logsParsed[0], 0, 100);
        $fullMsg = array_slice($msgFormatted, 0, 100);
        

        return $this->render('dashboard/index.html.twig', [
            'logs' => $fullLogs,
            'msg'   => $fullMsg,
        ]);
    }
}
