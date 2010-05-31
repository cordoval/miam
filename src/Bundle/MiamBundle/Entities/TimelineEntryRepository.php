<?php

namespace Bundle\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;

class TimelineEntryRepository extends EntityRepository
{

    /**
     * Find the list of the latest timeline entries
     *
     * @param int Max number of timeline entries to fetch
     * @return Array
     */
    public function findLatest($limit = 50)
    {
      return $this->createQueryBuilder('e')
        ->leftJoin('e.story', 's')
        ->leftJoin('s.project', 'p')
        ->leftJoin('e.user', 'u')
        ->orderBy('e.id', 'desc')
        ->getQuery()
        ->setMaxResults($limit)
        ->execute();
    }
}
