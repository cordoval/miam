<?php

namespace Bundle\MiamBundle\Entities;

/**
 * @Entity(repositoryClass="Bundle\MiamBundle\Entities\StoryRepository")
 * @Table(name="miam_story")
 */
class Story
{
    /**
    * @ManyToOne(targetEntity="Project", inversedBy="stories")
    * @JoinColumn(name="project_id", nullable=false)
    */
    protected $project;
 
    /**
    * @ManyToOne(targetEntity="Sprint", inversedBy="stories")
    * @JoinColumn(name="sprint_id", nullable=true)
    */
    protected $sprint;   
 
    /**
     * @Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @Column(name="priority", type="integer")
     */
    protected $priority;

    /**
     * @Column(name="body", type="text")
     */
    protected $body;

    /**
     * @Column(name="points", type="text", nullable=true)
     */
    protected $points;

    /**
     * @Column(name="status", type="integer") 
     */
    protected $status;

    const STATUS_CREATED = 10;
    const STATUS_ACCEPTED = 20;
    const STATUS_ESTIMATED = 30;
    const STATUS_SCHEDULED = 40;
    const STATUS_WAITING = 50;
    const STATUS_WIP = 60;
    const STATUS_FINISHED = 70;

    /**
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    const DEFAULT_NAME = '(story sans nom)';
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->status    = self::STATUS_CREATED;
    }

    /**
     * Set createdAt
     */
    public function setCreatedAt($value)
    {
        $this->createdAt = $value;
    }

    /**
     * Get createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set name
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * Get name
     */
    public function getName()
    {
        return $this->name;
    }

    public function setPriority($value)
    {
        $this->priority = $value;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set body
     */
    public function setBody($value)
    {
        $this->body = $value;
    }

    /**
     * Get body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get id
     */
    public function getId()
    {
        return $this->id;
    }

    public function setPoints($points)
    {
        $this->points = $points;
    }

    public function getPoints()
    {
        return $this->points;
    }
  
    public function setSprint(Sprint $sprint = null)
    {
        $this->sprint = $sprint;
    }
    
    public function getSprint()
    {  
      return $this->sprint;
    }

    public function setProject(Project $project)
    {
        $this->project = $project;
    }
    
    public function getProject()
    {
        return $this->project;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(!in_array($status, array_keys($this->getStatuses())))
        {
          throw new \InvalidArgumentException(sprintf('%s is not a valid story status like %s', $status, implode(', ', array_keys($this->getStatuses()))));
        }
        $this->status = $status;
    }

    public static function getStatuses()
    {
      return array(
        self::STATUS_CREATED => 'created',
        self::STATUS_ACCEPTED => 'accepted',
        self::STATUS_ESTIMATED => 'estimated',
        self::STATUS_SCHEDULED => 'scheduled',
        self::STATUS_WAITING => 'waiting',
        self::STATUS_WIP => 'work in progress',
        self::STATUS_FINISHED => 'finished'
      );
    }

    public function getStatusName()
    {
        $statuses = $this->getStatuses();

        return $statuses[$this->status];
    } 
        
    /**
     * Return an array version of a Story's properties
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'body' => $this->getBody(),
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAt(),
            'priority' => $this->getPriority(),
            'points' => $this->getPoints(),
            'project' => $this->getProject() ? $this->getProject()->getId() : null
        );
    }

    public function __toString()
    {
        $name = $this->getName();
        return (isset($name) && null !== $name) ? $name : self::DEFAULT_NAME;
    }
    
    public function moveToTheEnd()
    {
        $this->setPriority(1000);
    }
    
}
