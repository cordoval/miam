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
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    const DEFAULT_NAME = '(story sans nom)';
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
    
    public function setProject(Project $project)
    {
        $this->project = $project;
    }
    
    public function getProject()
    {
        return $this->project;
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
            'points' => $this->getPoints()
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