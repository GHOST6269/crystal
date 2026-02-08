<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\DownloadItem;
use App\Form\DownloadItemType;
use App\Repository\DownloadItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/telechargements')]
class DownloadController extends AbstractController
{
    #[Route('', name: 'admin_download_index', methods: ['GET'])]
    public function index(DownloadItemRepository $repository): Response
    {
        return $this->render('admin/download/index.html.twig', [
            'items' => $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_download_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $item = new DownloadItem();
        $form = $this->createForm(DownloadItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUpload($form->get('pdfFile')->getData(), $item, $slugger);

            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Fichier ajouté.');

            return $this->redirectToRoute('admin_download_index');
        }

        return $this->render('admin/download/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_download_edit', methods: ['GET', 'POST'])]
    public function edit(DownloadItem $item, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(DownloadItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUpload($form->get('pdfFile')->getData(), $item, $slugger);

            $em->flush();

            $this->addFlash('success', 'Fichier mis à jour.');

            return $this->redirectToRoute('admin_download_index');
        }

        return $this->render('admin/download/edit.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
        ]);
    }

    #[Route('/{id}', name: 'admin_download_delete', methods: ['POST'])]
    public function delete(DownloadItem $item, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-download-' . $item->getId(), (string) $request->request->get('_token'))) {
            $em->remove($item);
            $em->flush();
            $this->addFlash('success', 'Fichier supprimé.');
        }

        return $this->redirectToRoute('admin_download_index');
    }

    private function handleUpload(?UploadedFile $file, DownloadItem $item, SluggerInterface $slugger): void
    {
        if (!$file instanceof UploadedFile) {
            return;
        }

        $safeName = $slugger->slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $newFilename = $safeName . '-' . uniqid('', true) . '.' . $file->guessExtension();
        $targetDir = $this->getParameter('kernel.project_dir') . '/public/uploads/docs';
        $file->move($targetDir, $newFilename);

        $item->setFilePath('uploads/docs/' . $newFilename);
    }
}
