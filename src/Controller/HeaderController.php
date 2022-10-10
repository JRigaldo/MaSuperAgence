<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Symfony\Component\HttpFoundation\Response;

class HeaderController extends AbstractController{

    /**
     * @return Response
     */
    public function form(): Response
    {
        return $this->render('formSearch.html.twig', [
            'test' => 'test'
        ]);
    }
}