<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\GalleryItem;
use App\Form\GalleryItemType;
use App\Repository\GalleryItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/galerie')]
class GalleryController extends AbstractController
{
    #[Route('', name: 'admin_gallery_index', methods: ['GET'])]
    public function index(GalleryItemRepository $repository): Response
    {
        return $this->render('admin/gallery/index.html.twig', [
            'items' => $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_gallery_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $item = new GalleryItem();
        $form = $this->createForm(GalleryItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUpload($form->get('imageFile')->getData(), $item, $slugger);

            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Image ajoutée.');

            return $this->redirectToRoute('admin_gallery_index');
        }

        return $this->render('admin/gallery/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_gallery_edit', methods: ['GET', 'POST'])]
    public function edit(GalleryItem $item, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(GalleryItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUpload($form->get('imageFile')->getData(), $item, $slugger);

            $em->flush();

            $this->addFlash('success', 'Image mise à jour.');

            return $this->redirectToRoute('admin_gallery_index');
        }

        return $this->render('admin/gallery/edit.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
        ]);
    }

    #[Route('/{id}', name: 'admin_gallery_delete', methods: ['POST'])]
    public function delete(GalleryItem $item, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-gallery-' . $item->getId(), (string) $request->request->get('_token'))) {
            $em->remove($item);
            $em->flush();
            $this->addFlash('success', 'Image supprimée.');
        }

        return $this->redirectToRoute('admin_gallery_index');
    }

    private function handleUpload(?UploadedFile $file, GalleryItem $item, SluggerInterface $slugger): void
    {
        if (!$file instanceof UploadedFile) {
            return;
        }

        $safeName = $slugger->slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $newFilename = $safeName . '-' . uniqid('', true) . '.' . $file->guessExtension();
        $targetDir = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
        $file->move($targetDir, $newFilename);

        $item->setImagePath('uploads/images/' . $newFilename);
    }
}
