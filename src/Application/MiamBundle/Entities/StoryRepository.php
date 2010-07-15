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

    public function findBacklogIndexByProject()
    {
        $stories = $this->createQueryBuilder('s')
            ->select('s, p')
            ->where('s.sprint is null')
            ->leftJoin('s.project', 'p')
            ->addOrderBy('p.priority', 'ASC')
            ->addOrderBy('s.priority', 'ASC')
            ->getQuery()
            ->execute();

        return $this->storiesToSections($stories);
    }

    public function findSprintStoriesIndexByProject(Sprint $sprint)
    {
        $stories =  $this->createQueryBuilder('s')
            ->select('s, p')
            ->where('s.sprint = :sprint')
            ->leftJoin('s.project', 'p')
            ->addOrderBy('p.priority', 'ASC')
            ->addOrderBy('s.priority', 'ASC')
            ->setParameter('sprint', $sprint)
            ->getQuery()
            ->execute();

        return $this->storiesToSections($stories);
    }

    protected function storiesToSections(array $stories)
    {
        $sections = array();
        foreach($stories as $story) {
            $name = $story->getProject()->getName();
            if(!isset($sections[$name])) {
                $sections[$name] = array(
                    'project' => $story->getProject(),
                    'stories' => array()
                );
            }
            $sections[$name]['stories'][] = $story;
        }

        return $sections;
    }

    public function sort(array $ids)
    {
        foreach($ids as $priority => $id) {
            $this->find($id)->setPriority($priority);
        }
    }

}
