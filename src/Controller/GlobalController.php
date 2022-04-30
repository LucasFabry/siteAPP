<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlobalController extends AbstractController
{
    #[Route('/', name: 'app_global')]
    public function index(): Response
    {
        return $this->render('global/index.html.twig', [
            'css' => 'css/accueil.css',
        ]);
    }

    #[Route('/connexion', name: 'global.connexion')]
    public function getConnexion(): Response
    {
        return $this->render('global/connexion.html.twig', [
            'css' => 'login.css',
        ]);
    }
}
