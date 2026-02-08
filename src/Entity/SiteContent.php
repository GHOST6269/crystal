<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SiteContentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteContentRepository::class)]
class SiteContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $heroTitle = 'Crystal Liste';

    #[ORM\Column(length: 255)]
    private string $heroSubtitle = 'Films, dramas, animes, jeux & multi-services';

    #[ORM\Column(type: 'text')]
    private string $heroDescription = 'Transfert rapide sur USB, disque dur ou téléphone. Impression, reliure et dépannage logiciel pour ordinateur et mobile.';

    #[ORM\Column(length: 50)]
    private string $phone = '+229 00 00 00 00';

    #[ORM\Column(length: 50)]
    private string $whatsapp = '+229 00 00 00 00';

    #[ORM\Column(length: 255)]
    private string $email = 'contact@crystal-liste.com';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeroTitle(): string
    {
        return $this->heroTitle;
    }

    public function setHeroTitle(string $heroTitle): self
    {
        $this->heroTitle = $heroTitle;

        return $this;
    }

    public function getHeroSubtitle(): string
    {
        return $this->heroSubtitle;
    }

    public function setHeroSubtitle(string $heroSubtitle): self
    {
        $this->heroSubtitle = $heroSubtitle;

        return $this;
    }

    public function getHeroDescription(): string
    {
        return $this->heroDescription;
    }

    public function setHeroDescription(string $heroDescription): self
    {
        $this->heroDescription = $heroDescription;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWhatsapp(): string
    {
        return $this->whatsapp;
    }

    public function setWhatsapp(string $whatsapp): self
    {
        $this->whatsapp = $whatsapp;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
