<?php

namespace Bundle\MiamBundle\Entities;

use Symfony\Components\Validator\Mapping\ClassMetadata;
use Symfony\Components\Validator\Constraints\Min;
use Symfony\Components\Validator\Constraints\Max;
use Symfony\Components\Validator\Constraints\MinLength;
use Symfony\Components\Validator\Constraints\MaxLength;
use Symfony\Components\Validator\Constraints\AssertType;
use Symfony\Components\Validator\Constraints\Email;
use Symfony\Components\Validator\Constraints\Choice;
use Symfony\Components\Validator\Constraints\Valid;
use Symfony\Components\Validator\Constraints\Regex;

/**
 * @Entity(repositoryClass="Bundle\MiamBundle\Entities\ProjectRepository")
 * @Table(name="miam_project")
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
     */
    protected $name;

    /**
     * @Column(name="is_active", type="boolean", nullable=false)
     */
    protected $isActive;

    /**
     * @Column(name="color", type="string", length=7)
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
        $this->createdAt = new \DateTime();
        $this->isActive = true;
    }
     
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
      $metadata->addPropertyConstraint('name', new MinLength(3));
      $metadata->addPropertyConstraint('color', new Regex('/^#?[0-9A-F]{6}$/i'));
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
