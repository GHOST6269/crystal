<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DownloadItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DownloadItem>
 */
class DownloadItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DownloadItem::class);
    }
}
