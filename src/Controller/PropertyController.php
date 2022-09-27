<?php

namespace App\Controller;

use App\Entity\Property;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class PropertyController extends AbstractController {

    private $repository;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->repository = $doctrine->getRepository(Property::class);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/biens', name: 'property.index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $properties = $this->repository->findLatest();

        /**
         * Récupère les propriétés et change sold à true en base de données
         */
        /*
        $entityManager = $doctrine->getManager();
        $property = $doctrine->getRepository(Property::class)->findAllVisible();
        $property[0]->setSold(true);
        $entityManager->flush();
        dump($property);
        */
        /**
         * Retourne un repo
         */
        /*
        $property = $doctrine->getRepository(Property::class);
        dump($property);
        if (!$property) {
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }*/

        /**
         * Enrichir la db property
         */
        /*
        $entityManager = $doctrine->getManager();
        $property = new Property();
        $property
            ->setTitle('Mon premier bien')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(3)
            ->setDescription('Mon petit super appartement')
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity('Lausanne')
            ->setAddress('Route de Cossonay 108')
            ->setPostalCode(1009);
        $entityManager->persist($property);
        $entityManager->flush();
        */

        return $this->render('property/index.html.twig', [
            'current_menu' => 'active_page',
            'properties' => $properties
        ]);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param Property $property
     * @return Response
     */
    #[Route('/biens/{slug}-{id}', name: 'property.show', requirements: ["slug" => "[a-z0-9\-]*"])]
    public function show(Property $property, string $slug): Response
    {
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'active_page'
        ]);
    }


}