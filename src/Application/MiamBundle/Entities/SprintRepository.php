<?php

namespace Application\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;
use Application\MiamBundle\Entities\Sprint;
use Doctrine\ORM\Query;

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
            ->where('s.isCurrent = 1')
            ->getQuery()
            ->getSingleResult()
            ;
    }

    /**
     * Find the current sprint, with its stories
     *
     * @return Sprint
     */
    public function findCurrentWithStories()
    {
        return $this->createQueryBuilder('sprint')
            ->select('sprint, story')
            ->where('sprint.isCurrent = 1')
            ->leftJoin('sprint.stories', 'story', \Doctrine\ORM\Query\Expr\Join::WITH, 'story.status > 0')
            ->addOrderBy('story.priority', 'asc')
            ->getQuery()
            ->getSingleResult()
            ;
    }

    /**
     * Mark all sprint except $sprint as not current
     *
     * @param Sprint The future current sprint
     * @return void
     */
    public function setCurrentSprint(Sprint $sprint)
    {
        $this->createQueryBuilder('s')
            ->update()
            ->set('s.isCurrent', '0')
            ->where('s.id != :id')
            ->setParameter('id', $sprint->getId())
            ->getQuery()
            ->execute()
            ;
    }
}
