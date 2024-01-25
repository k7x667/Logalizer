<?php

namespace App\Controller;

use App\Service\NormalizerService;
use App\Service\TestLogalizer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Log;
use App\Factory\JsonResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private JsonResponseFactory $jsonResponseFactory
    ) {}

    #[Route('/get-log', name: 'api_get_log', methods: ['GET'])]
    public function getLog(NormalizerService $normalizerService): Response
    {
        $logs = $this->doctrine->getRepository(Log::class)->findAll();
        
            foreach ($logs as $log) {
                $logContent[] = $log->getContent();
            }
        
        $logsFormatted[] = $normalizerService->formatLogEntries($logContent);

            foreach ($logsFormatted as $logFormatted) {
                $logsParsed[] = $normalizerService->parseLog($logFormatted);
            }

        return $this->jsonResponseFactory->create($logsParsed);
    }

    #[Route('/get-message', name:'api_get_message',)]
    public function getMessage(NormalizerService $normalizerService): Response
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

        return $this->jsonResponseFactory->create($msgFormatted);
    }

    #[Route('/test', name:'api_get_test', methods: ['GET'])]
    public function test() {
        $logs = $this->doctrine->getRepository(Log::class)->findAll();

        foreach ($logs as $log) {
            $logContent[] = $log->getContent();
        }

        $testLogalizer = new TestLogalizer();
        $testLogalizer->parseLogs($logContent);

        //die();

        // return $this->jsonResponseFactory->create(json_encode($logs, JSON_PRETTY_PRINT));
    }
}
