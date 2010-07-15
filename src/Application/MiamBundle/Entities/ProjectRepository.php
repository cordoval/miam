<?php

namespace Application\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function resort()
    {
        foreach($this->findAllOrderByPriority() as $priority => $project) {
            $project->setPriority($priority);
        }
    }

    /**
     * Return all projects which have at least one story assigned to the given sprint
     *
     * @return array
     */
    public function findForSprint(Sprint $sprint)
    {
        return $this->createQueryBuilder('p')
            ->select('p', 's')
            ->innerJoin('p.stories', 's', 'WITH', 's.status > 0')
            ->where('s.sprint = :id')
            ->orderBy('p.priority', 'asc')
            ->addOrderBy('s.priority', 'asc')
            ->setParameter('id', $sprint->getId())
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Return all projects sorted by interest, indexed by id
     *
     * @return Associative array of Project
     */
    public function findAllIndexedById()
    {
        $projects = $this->getOrderByPriorityQuery()->execute();

        // TODO: find how to INDEX BY id
        $projectsIndexed = array();
        foreach($projects as $project) {
            $projectsIndexed[$project->getId()] = $project;
        }
        return $projectsIndexed;
    }

    /**
     * Return all projects sorted by priority.
     * Lower value is more important
     *
     * @return Array of Project
     */
    public function findAllOrderByPriority()
    {
        return $this->getOrderByPriorityQuery()->execute();
    }

    /**
     * Return the project having the id $id with its stories (ordered by priority).
     *
     * @param int Project id
     * @return Project
     */
    public function findWithBacklog($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->leftJoin('p.stories', 's')
            ->orderBy('s.priority', 'asc')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult()
            ;
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

    protected function getOrderByPriorityQuery()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.priority', 'ASC')
            ->getQuery()
            ;
    }

    public function sort(array $ids)
    {
        foreach($ids as $priority => $id) {
            $this->find($id)->setPriority($priority);
        }
    }
}
