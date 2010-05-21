<?php

namespace Bundle\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;

class SprintRepository extends EntityRepository
{
    /**
     * Find the current sprint
     *
     * @return Sprint
     */
    public function findCurrent()
    {
        return $this->createQueryBuilder('s')
        ->where('s.current = 1')
        ->getQuery()
        ->getSingleResult()
        ;
    }
}