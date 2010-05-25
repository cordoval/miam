<?php

namespace Bundle\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;

class StoryRepository extends EntityRepository
{

    public function findBacklog()
    {
        return $this->createQueryBuilder('s')
        ->orderBy('s.priority', 'asc')
        ->where('s.sprint is null')
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