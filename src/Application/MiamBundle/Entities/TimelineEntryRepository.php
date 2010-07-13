<?php

namespace Application\MiamBundle\Entities;

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
      return $this->_em->createQueryBuilder()
          ->select('e, s, p')
          ->from($this->_entityName, 'e')
          ->leftJoin('e.story', 's')
          ->leftJoin('s.project', 'p')
          ->leftJoin('e.user', 'u')
          ->orderBy('e.id', 'desc')
          ->getQuery()
          ->setMaxResults($limit)
          ->execute();
    }

    /**
     * Find the list of the latest timeline entries for a story
     *
     * @param int Max number of timeline entries to fetch
     * @return Array
     */
    public function findByStory($story, $limit = 50)
    {
      return $this->_em->createQueryBuilder()
          ->select('e, s, p')
          ->from($this->_entityName, 'e')
          ->leftJoin('e.story', 's')
          ->leftJoin('s.project', 'p')
          ->leftJoin('e.user', 'u')
          ->where('e.story = :story')
          ->orderBy('e.id', 'desc')
          ->getQuery()
          ->setMaxResults($limit)
          ->setParameter('story', $story)
          ->execute();
    }
}
