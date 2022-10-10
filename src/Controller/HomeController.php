<?php

namespace App\Controller;

use App\Entity\Property;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController extends AbstractController{

    /**
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $properties = $doctrine->getRepository(Property::class)->findLatest();
        return $this->render('pages/home.html.twig', [
            'properties' => $properties
        ]);
    }
}