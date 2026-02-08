<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/actualites')]
class NewsController extends AbstractController
{
    #[Route('', name: 'admin_news_index', methods: ['GET'])]
    public function index(NewsRepository $repository): Response
    {
        return $this->render('admin/news/index.html.twig', [
            'news' => $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_news_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($news);
            $em->flush();

            $this->addFlash('success', 'Actualité ajoutée.');

            return $this->redirectToRoute('admin_news_index');
        }

        return $this->render('admin/news/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_news_edit', methods: ['GET', 'POST'])]
    public function edit(News $news, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Actualité mise à jour.');

            return $this->redirectToRoute('admin_news_index');
        }

        return $this->render('admin/news/edit.html.twig', [
            'form' => $form->createView(),
            'newsItem' => $news,
        ]);
    }

    #[Route('/{id}', name: 'admin_news_delete', methods: ['POST'])]
    public function delete(News $news, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-news-' . $news->getId(), (string) $request->request->get('_token'))) {
            $em->remove($news);
            $em->flush();
            $this->addFlash('success', 'Actualité supprimée.');
        }

        return $this->redirectToRoute('admin_news_index');
    }
}
