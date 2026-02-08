<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Tariff;
use App\Form\TariffType;
use App\Repository\TariffRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/tarifs')]
class TariffController extends AbstractController
{
    #[Route('', name: 'admin_tariff_index', methods: ['GET'])]
    public function index(TariffRepository $repository): Response
    {
        return $this->render('admin/tariff/index.html.twig', [
            'tariffs' => $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_tariff_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $tariff = new Tariff();
        $form = $this->createForm(TariffType::class, $tariff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tariff);
            $em->flush();

            $this->addFlash('success', 'Tarif ajouté.');

            return $this->redirectToRoute('admin_tariff_index');
        }

        return $this->render('admin/tariff/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_tariff_edit', methods: ['GET', 'POST'])]
    public function edit(Tariff $tariff, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TariffType::class, $tariff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Tarif mis à jour.');

            return $this->redirectToRoute('admin_tariff_index');
        }

        return $this->render('admin/tariff/edit.html.twig', [
            'form' => $form->createView(),
            'tariff' => $tariff,
        ]);
    }

    #[Route('/{id}', name: 'admin_tariff_delete', methods: ['POST'])]
    public function delete(Tariff $tariff, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-tariff-' . $tariff->getId(), (string) $request->request->get('_token'))) {
            $em->remove($tariff);
            $em->flush();
            $this->addFlash('success', 'Tarif supprimé.');
        }

        return $this->redirectToRoute('admin_tariff_index');
    }
}
