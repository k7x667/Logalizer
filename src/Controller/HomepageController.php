<?php

namespace App\Controller;

use App\Entity\Blog;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ManagerRegistry $managerRegistry): Response
    {   
        return $this->render('homepage/index.html.twig', [
            'blogs' => $managerRegistry->getRepository(Blog::class)->findAll(),
        ]);
    }
}
