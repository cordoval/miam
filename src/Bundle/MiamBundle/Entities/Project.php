<?php

namespace Bundle\MiamBundle\Entities;

/**
 * @Entity(repositoryClass="Bundle\MiamBundle\Entities\ProjectRepository")
 * @Table(name="miam_project")
 * @HasLifecycleCallbacks
 */
class Project
{
    /**
    * @OneToMany(targetEntity="Story", mappedBy="project")
    */
    protected $stories;
    
    /**
     * @Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @Column(name="name", type="string", length=255)
     * @Validation({
     *   @MinLength(3),
     *   @NotNull
     * })
     */
    protected $name;

    /**
     * @Column(name="is_active", type="boolean", nullable=false)
     */
    protected $isActive;

    /**
     * @Column(name="color", type="string", length=7)
     * @Validation({
     *   @Regex("/^#?[0-9A-F]{6}$/i"),
     *   @NotNull
     * })
     */
    protected $color;
    
    /**
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        $this->isActive = true;
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

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    public function isActive()
    {
        return $this->isActive;
    }
    
    public function setColor($color)
    {
        $this->color = $color;
    }
    
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Return an array version of a Story's properties
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'color' => $this->getColor(),
            'created_at' => $this->getCreatedAt(),
        );
    }

    /** @PreUpdate */
    public function doStuffOnPreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /** @PrePersist */
    public function doStuffOnPrePersist()
    {
        $this->createdAt = $this->updatedAt = new \DateTime();
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


    public function getStories()
    {
        return $this->stories;
    }
    
    public function __toString()
    {
        return $this->getName();
    }
    
}
