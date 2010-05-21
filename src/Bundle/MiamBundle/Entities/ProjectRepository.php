<?php

namespace Bundle\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
  /**
   * Return all projects which have at least one story assigned to the given sprint
   *
   * @return array
   */
  public function findForSprint(Sprint $sprint)
  {
        return $this->createQueryBuilder('p')
        ->innerJoin('p.stories', 's')
        ->where('s.sprint = :id')
        ->orderBy('s.priority', 'asc')
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
      $projects = $this->getOrderByInterestQuery()
      ->execute();
      
      // TODO: find how to INDEX BY id
      $projectsIndexed = array();
      foreach($projects as $project) {
          $projectsIndexed[$project->getId()] = $project;
      }
      return $projectsIndexed;
  }
  
    /**
     * Return all projects sorted by interest.
     * For now, most recent projects should be at the top.
     *
     * @return Array of Project
     */
    public function findAllOrderByInterest()
    {
        return $this->getOrderByInterestQuery()
        ->execute();
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
    
    protected function getOrderByInterestQuery()
    {
        return $this->createQueryBuilder('p')
        ->orderBy('p.createdAt', 'desc')
        ->getQuery()
        ;
    }
}
