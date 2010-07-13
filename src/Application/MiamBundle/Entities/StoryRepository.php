<?php

namespace Application\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;

class StoryRepository extends EntityRepository
{

    public function findOneByIdWithProject($id)
    {
      return $this->createQueryBuilder('s')
        ->select('s, p')
        ->where('s.id = :id')
        ->innerJoin('s.project', 'p')
        ->setParameter('id', $id)
        ->getQuery()
        ->getSingleResult();
    }

    public function findBacklog()
    {
        return $this->createQueryBuilder('s')
        ->orderBy('s.priority', 'asc')
        ->where('s.sprint is null')
        ->andWhere('s.status > 0')
        ->getQuery()
        ->execute();
    }

    public function sort(array $ids)
    {
        foreach($ids as $priority => $id) {
            $this->find($id)->setPriority($priority);
        }
    }

}
