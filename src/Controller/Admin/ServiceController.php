<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/services')]
class ServiceController extends AbstractController
{
    #[Route('', name: 'admin_service_index', methods: ['GET'])]
    public function index(ServiceRepository $repository): Response
    {
        return $this->render('admin/service/index.html.twig', [
            'services' => $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($service);
            $em->flush();

            $this->addFlash('success', 'Service ajouté.');

            return $this->redirectToRoute('admin_service_index');
        }

        return $this->render('admin/service/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_service_edit', methods: ['GET', 'POST'])]
    public function edit(Service $service, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Service mis à jour.');

            return $this->redirectToRoute('admin_service_index');
        }

        return $this->render('admin/service/edit.html.twig', [
            'form' => $form->createView(),
            'service' => $service,
        ]);
    }

    #[Route('/{id}', name: 'admin_service_delete', methods: ['POST'])]
    public function delete(Service $service, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-service-' . $service->getId(), (string) $request->request->get('_token'))) {
            $em->remove($service);
            $em->flush();
            $this->addFlash('success', 'Service supprimé.');
        }

        return $this->redirectToRoute('admin_service_index');
    }
}
