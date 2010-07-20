<?php

namespace Application\MiamBundle\Entities;
use Symfony\Components\Validator\Mapping\ClassMetadata;
use Symfony\Components\Validator\Constraints;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Application\MiamBundle\Entities\SprintRepository")
 * @Table(name="miam_sprint")
 */
class Sprint
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
    }

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
        $this->stories   = new ArrayCollection();
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
    
    /**
     * getStories 
     * 
     * @return ArrayCollection
     */
    public function getStories()
    {
        return $this->stories;
    }

    public function addStory($story)
    {
        $this->getStories()->add($story);
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
        foreach($this->getStories() as $story) {
            if(!$story->isFinished()) {
                $sum += $story->getPoints();
            }
        }
        return $sum;
    }

    public function getFinishedPoints()
    {
        return $this->getPointsByStatus(Story::STATUS_FINISHED);
    }

    public function getTotalPoints()
    {
        $sum = 0;
        foreach($this->getStories() as $story) {
            $sum += $story->getPoints();
        }
        return $sum;
    }

    public function getPointsByStatus($status)
    {
        $sum = 0;
        foreach($this->getStories() as $story) {
            if($story->isStatus($status)) {
                $sum += $story->getPoints();
            }
        }
        return $sum;
    }

    public function getPointsByDomain($domain)
    {
        $sum = 0;
        foreach($this->getStories() as $story) {
            if($story->isDomain($domain)) {
                $sum += $story->getPoints();
            }
        }
        return $sum;
    }

    public function getFinishedPointsByDomain($domain)
    {
        $sum = 0;
        foreach($this->getStories() as $story) {
            if($story->isFinished() && $story->isDomain($domain)) {
                $sum += $story->getPoints();
            }
        }
        return $sum;
    }
    
}
