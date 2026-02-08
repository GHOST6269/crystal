<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\SiteContent;
use App\Form\SiteContentType;
use App\Repository\SiteContentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/site-content')]
class SiteContentController extends AbstractController
{
    #[Route('', name: 'admin_site_content_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, SiteContentRepository $repository): Response
    {
        $content = $repository->findOneBy([]) ?? new SiteContent();

        $form = $this->createForm(SiteContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($content);
            $em->flush();

            $this->addFlash('success', 'Contenu principal mis à jour.');

            return $this->redirectToRoute('admin_site_content_edit');
        }

        return $this->render('admin/site_content/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
