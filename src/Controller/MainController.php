<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    

    #[Route('/', name: 'app_home')]
    public function index(MenuRepository $menuRepository): Response
    {
        $active = "btn-nav";
        return $this->render('home/index.html.twig', [
            'menus' => $menuRepository->findAll()
        ]);
    }

    #[Route('/reservation', name: 'app_reservation')]
    public function resIndex(): Response
    {
        return $this->render('reservation/index.html.twig');
    }

}
