<?php

namespace App\Controller;

use App\Entity\Log;
use App\Service\LogDeserializerService;
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
        
        return $this->render('homepage/index.html.twig', [
            'data' => 'Hello world',
        ]);
    }
}
