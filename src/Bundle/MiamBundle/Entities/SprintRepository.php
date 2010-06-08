<?php

namespace Bundle\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;
use Bundle\MiamBundle\Entities\Sprint;
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
            ->leftJoin('story.project', 'project')
            ->orderBy('project.name', 'asc')
            ->addOrderBy('story.name', 'asc')
            ->getQuery()
            ->getSingleResult()
            ;
    }

    /**
     * Get the current sprint hash value
     *
     * @return string the current sprint hash
     **/
    public function getCurrentHash()
    {
        $stories = $this->createQueryBuilder('sprint')
            ->select('story.updatedAt')
            ->where('sprint.isCurrent = 1')
            ->leftJoin('sprint.stories', 'story', \Doctrine\ORM\Query\Expr\Join::WITH, 'story.status > 0')
            ->leftJoin('story.project', 'project')
            ->orderBy('project.name', 'asc')
            ->addOrderBy('story.name', 'asc')
            ->getQuery()
            ->getScalarResult();
        $hash = '';
        foreach($stories as $story) {
            $hash .= $story['updatedAt'];
        }
        $hash = md5($hash);
        return $hash;
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
