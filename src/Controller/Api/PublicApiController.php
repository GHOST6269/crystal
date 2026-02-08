<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\DownloadItemRepository;
use App\Repository\GalleryItemRepository;
use App\Repository\NewsRepository;
use App\Repository\ServiceRepository;
use App\Repository\ShopRepository;
use App\Repository\SiteContentRepository;
use App\Repository\TariffRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class PublicApiController extends AbstractController
{
    #[Route('/site', name: 'api_site', methods: ['GET'])]
    public function site(SiteContentRepository $repository): JsonResponse
    {
        $content = $repository->findOneBy([]);

        $payload = [
            'heroTitle' => $content?->getHeroTitle() ?? 'Crystal Liste',
            'heroSubtitle' => $content?->getHeroSubtitle() ?? 'Films, dramas, animes, jeux & multi-services',
            'heroDescription' => $content?->getHeroDescription() ?? 'Transfert rapide sur USB, disque dur ou téléphone. Impression, reliure et dépannage logiciel pour ordinateur et mobile.',
            'phone' => $content?->getPhone() ?? '+229 00 00 00 00',
            'whatsapp' => $content?->getWhatsapp() ?? '+229 00 00 00 00',
            'email' => $content?->getEmail() ?? 'contact@crystal-liste.com',
        ];

        return $this->jsonResponse($payload);
    }

    #[Route('/services', name: 'api_services', methods: ['GET'])]
    public function services(ServiceRepository $repository): JsonResponse
    {
        $items = array_map(static fn($service) => [
            'id' => $service->getId(),
            'title' => $service->getTitle(),
            'description' => $service->getDescription(),
            'position' => $service->getPosition(),
        ], $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']));

        return $this->jsonResponse($items);
    }

    #[Route('/boutiques', name: 'api_boutiques', methods: ['GET'])]
    public function boutiques(ShopRepository $repository): JsonResponse
    {
        $items = array_map(static fn($shop) => [
            'id' => $shop->getId(),
            'name' => $shop->getName(),
            'address' => $shop->getAddress(),
            'hours' => $shop->getHours(),
            'focus' => $shop->getFocus(),
            'position' => $shop->getPosition(),
        ], $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']));

        return $this->jsonResponse($items);
    }

    #[Route('/tarifs', name: 'api_tarifs', methods: ['GET'])]
    public function tarifs(TariffRepository $repository): JsonResponse
    {
        $items = array_map(static fn($tariff) => [
            'id' => $tariff->getId(),
            'label' => $tariff->getLabel(),
            'price' => $tariff->getPrice(),
            'position' => $tariff->getPosition(),
        ], $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']));

        return $this->jsonResponse($items);
    }

    #[Route('/galerie', name: 'api_galerie', methods: ['GET'])]
    public function galerie(GalleryItemRepository $repository): JsonResponse
    {
        $items = array_map(static fn($item) => [
            'id' => $item->getId(),
            'title' => $item->getTitle(),
            'imagePath' => $item->getImagePath(),
            'position' => $item->getPosition(),
        ], $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']));

        return $this->jsonResponse($items);
    }

    #[Route('/actualites', name: 'api_actualites', methods: ['GET'])]
    public function actualites(NewsRepository $repository): JsonResponse
    {
        $items = array_map(static fn($item) => [
            'id' => $item->getId(),
            'title' => $item->getTitle(),
            'dateLabel' => $item->getDateLabel(),
            'detail' => $item->getDetail(),
            'position' => $item->getPosition(),
        ], $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']));

        return $this->jsonResponse($items);
    }

    #[Route('/downloads', name: 'api_downloads', methods: ['GET'])]
    public function downloads(DownloadItemRepository $repository): JsonResponse
    {
        $items = array_map(static fn($item) => [
            'id' => $item->getId(),
            'title' => $item->getTitle(),
            'filePath' => $item->getFilePath(),
            'position' => $item->getPosition(),
        ], $repository->findBy([], ['position' => 'ASC', 'id' => 'ASC']));

        return $this->jsonResponse($items);
    }

    private function jsonResponse(array $payload): JsonResponse
    {
        $response = $this->json($payload);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
