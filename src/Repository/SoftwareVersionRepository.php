<?php

namespace App\Repository;

use App\Entity\SoftwareVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SoftwareVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SoftwareVersion::class);
    }

    /**
     * @return SoftwareVersion[]
     */
    public function findBySystemVersionAltCaseInsensitive(string $version): array
    {
        $all = $this->findAll();

        return array_values(array_filter(
            $all,
            static fn (SoftwareVersion $item): bool => strcasecmp($item->getSystemVersionAlt(), $version) === 0
        ));
    }
}
