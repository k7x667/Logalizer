<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Log;
use App\Service\LogDeserializerService;
use App\Service\RegisterDetailService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {
    }


    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        $blogRepository = $this->doctrine->getRepository(Blog::class)->findAll();
        $log = $this->doctrine->getRepository(Log::class)->findAll();
        
        foreach ($log as $log)
        {
            $log = $log->content;
        }

        $logDeserializerService = new LogDeserializerService();
        
        $logFormatted = $logDeserializerService->formatLogEntries($log);
        $logDeserialized = $logDeserializerService->deserializeLogs($logFormatted);

        return $this->render('homepage/index.html.twig', [
            'blogs'     => $blogRepository,
            'logDeserialized'      => $logDeserialized,
        ]);
    }
}
