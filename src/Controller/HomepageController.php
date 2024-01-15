<?php

namespace App\Controller;

use App\Entity\Log;
use App\Service\DeserializerService;
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
        $log = $this->doctrine->getRepository(Log::class)->findAll();

        foreach ($log as $log) 
        {
            $log = $log->content;
        }


        $deserializerService = new DeserializerService();

        $formattedLog = $deserializerService->formatter($log);
        $deserializedLog = $deserializerService->deserializer($formattedLog);

        return $this->render('homepage/index.html.twig', [
            'data' => $deserializedLog,
        ]);
    }
}
