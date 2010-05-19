<?php

namespace Bundle\MiamBundle\Entities;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{

  /**
   * Return all projects sorted by interest, indexed by id
   *
   * @return Associvative array of Project
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