<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Shop;
use App\Form\ShopType;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/boutiques')]
class ShopController extends AbstractController
{
    #[Route('', name: 'admin_shop_index', methods: ['GET'])]
    public function index(ShopRepository $repository): Response
    {
        return $this->render('admin/shop/index.html.twig', [
            'shops' => $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_shop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $shop = new Shop();
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($shop);
            $em->flush();

            $this->addFlash('success', 'Boutique ajoutée.');

            return $this->redirectToRoute('admin_shop_index');
        }

        return $this->render('admin/shop/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_shop_edit', methods: ['GET', 'POST'])]
    public function edit(Shop $shop, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Boutique mise à jour.');

            return $this->redirectToRoute('admin_shop_index');
        }

        return $this->render('admin/shop/edit.html.twig', [
            'form' => $form->createView(),
            'shop' => $shop,
        ]);
    }

    #[Route('/{id}', name: 'admin_shop_delete', methods: ['POST'])]
    public function delete(Shop $shop, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-shop-' . $shop->getId(), (string) $request->request->get('_token'))) {
            $em->remove($shop);
            $em->flush();
            $this->addFlash('success', 'Boutique supprimée.');
        }

        return $this->redirectToRoute('admin_shop_index');
    }
}
