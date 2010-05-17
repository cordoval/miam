<?php

namespace Bundle\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{

    /**
     * Return all projects sorted by interest.
     * For now, most recent projects should be at the top.
     *
     * @return Array of Project
     */
    public function findAllOrderByInterest()
    {
        return $this->createQueryBuilder('p')
        ->orderBy('p.createdAt', 'desc')
        ->getQuery()
        ->execute();
    }

    /**
     * Return a project. Any project.
     *
     * @return Project
     */
    public function findDummyProject()
    {
        return $this->createQueryBuilder('p')
        ->getQuery()
        ->setMaxResults(1)
        ->getSingleResult();
    }
}