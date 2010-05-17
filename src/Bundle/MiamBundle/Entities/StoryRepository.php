<?php

namespace Bundle\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;

class StoryRepository extends EntityRepository
{

    public function findAllOrderByPriority()
    {
        return $this->createQueryBuilder('e')
        ->orderBy('e.priority', 'asc')
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