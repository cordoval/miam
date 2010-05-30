<?php

namespace Bundle\MiamBundle\Entities;

/**
 * @Entity(repositoryClass="Bundle\MiamBundle\Entities\SprintRepository")
 * @Table(name="miam_sprint")
 */
class Sprint
{
    /**
    * @OneToMany(targetEntity="Story", mappedBy="sprint")
    */
    protected $stories;
    
    /**
     * @Column(name="starts_at", type="date")
     */
    protected $startsAt;

    /**
     * @Column(name="endsAt", type="date")
     */
    protected $endsAt;

    /**
     * @Column(name="is_current", type="boolean", nullable=false)
     */
    protected $isCurrent;

    /**
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        $this->isCurrent = true;
        $this->stories   = array();
    }

    public function getIsCurrent()
    {
        return $this->isCurrent;
    }

    public function setIsCurrent($isCurrent)
    {
        $this->isCurrent = $isCurrent;
    }
    
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }
    
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }
    
    public function getStories()
    {
        return $this->stories;
    }

    public function addStory($story)
    {
        $this->stories[] = $story;
        $story->setSprint($this);
    }  

    public function removeStory(Story $story)
    {
        $this->getStories()->removeElement($story);
        $story->setSprint(null);
    }  

    /**
     * Return an array version of a Story's properties
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'starts_at' => $this->getStartsAt(),
            'ends_at' => $this->getEndsAt(),
            'is_current' => $this->getIsCurrent()
        );
    }

    /**
     * Get id
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return 'Sprint du ' . $this->getStartsAt()->format('d/m/Y') . ' au ' . $this->getEndsAt()->format('d/m/Y');
    }
    
    public function getRemainingPoints()
    {
        $sum = 0;
        foreach($this->stories as $story) {
            $status = $story->getStatus();
            if(in_array($status, array(
                Story::STATUS_PENDING,
                Story::STATUS_TODO,
                Story::STATUS_WIP,
            ))) {
                $sum += $story->getPoints();
            }
        }
        return $sum;
    }
    
}
