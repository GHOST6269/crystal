<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SiteContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SiteContent>
 */
class SiteContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteContent::class);
    }
}
