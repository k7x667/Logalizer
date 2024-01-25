<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Log;
use App\Service\TestLogalizer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}
    #[Route('/', name: 'app_homepage')]
    public function index(ManagerRegistry $managerRegistry): Response
    {   
        $logs = $this->doctrine->getRepository(Log::class)->findAll();

        foreach ($logs as $log) {
            $logContent[] = $log->getContent();
        }

        $testLogalizer = new TestLogalizer();
        $testLogalizer->parseLogs($logContent);

        return $this->render('homepage/index.html.twig', [
            'blogs' => $managerRegistry->getRepository(Blog::class)->findAll(),
        ]);
    }
}
