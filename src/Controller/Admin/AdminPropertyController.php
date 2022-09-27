<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PropertyType;

class AdminPropertyController extends AbstractController {

    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $repository;

    /**
     * @var \Doctrine\Persistence\ObjectManager
     */
    private $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->repository = $doctrine->getRepository(Property::class);
        $this->entityManager = $doctrine->getManager();
    }

    /**
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/admin', name: 'admin.property.index')]
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('admin/property/new', name: 'admin.property.new')]
    public function new(Request $request): Response
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($property);
            $this->entityManager->flush();
            $this->addFlash('Bien créé avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Property $property
     * @param Request $resquest
     * @return Response
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    #[Route('/admin/property/{id}', name: 'admin.property.edit', methods: ['GET', 'POST'])]
    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            $this->addFlash('Bien modifé avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Property $property
     * @param Request $resquest
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    #[Route('/admin/delete/{id}', name: 'admin.property.delete', methods: ['GET', 'POST'])]
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->request->get('_token'))){
            $this->entityManager->remove($property);
            $this->entityManager->flush();
            $this->addFlash('Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.property.index');
    }

}