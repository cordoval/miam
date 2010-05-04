<?php

namespace Bundle\MiamBundle\Entities;

/**
 * @Entity
 * @Table(name="miam_story")
 */
class Story
{
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
   * @Column(name="id", type="integer")
   * @Id
   * @GeneratedValue(strategy="AUTO")
   */
  protected $id;

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
}