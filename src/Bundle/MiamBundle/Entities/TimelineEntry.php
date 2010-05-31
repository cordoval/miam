<?php

namespace Bundle\MiamBundle\Entities;

/**
 * @Entity(repositoryClass="Bundle\MiamBundle\Entities\TimelineEntryRepository")
 * @Table(name="miam_timeline")
 * @HasLifecycleCallbacks
 */
class TimelineEntry
{
    /**
    * @ManyToOne(targetEntity="User", inversedBy="timelineEntries")
    * @JoinColumn(name="user_id", nullable=false)
    */
    protected $user;

    /**
    * @ManyToOne(targetEntity="Story", inversedBy="timelineEntries")
    * @JoinColumn(name="story_id", nullable=false)
    */
    protected $story;

    /**
     * @Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @Column(name="action", type="integer") 
     */
    protected $action;

    const ACTION_CREATE = 10;
    const ACTION_ESTIMATE = 20;
    const ACTION_REESTIMATE = 30;
    const ACTION_COMMENT = 40;
    const ACTION_EDIT = 50;
    const ACTION_SCHEDULE = 60;
    const ACTION_STATE_PENDING = 1000;
    const ACTION_STATE_TODO = 1010;
    const ACTION_STATE_WIP = 1020;
    const ACTION_STATE_FINISHED = 1030;

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
    
    /** @PrePersist */
    public function doStuffOnPrePersist()
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
     * Set action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }


    public static function getActions()
    {
      return array(
          self::ACTION_CREATE => 'create',
          self::ACTION_ESTIMATE => 'estimate',
          self::ACTION_REESTIMATE => 'reestimate',
          self::ACTION_COMMENT => 'comment',
          self::ACTION_EDIT => 'edit',
          self::ACTION_SCHEDULE => 'schedule',
          self::ACTION_STATE_PENDING => 'state_pending',
          self::ACTION_STATE_TODO => 'state_todo',
          self::ACTION_STATE_WIP => 'state_wip',
          self::ACTION_STATE_FINISHED => 'state_finished',
      );
    }
    /**
     * Get action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Return an array version of a TimelineEntry's properties
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'text' => $this->getText(),
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

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setStory($story)
    {
        $this->story = $story;
    }

    public function getStory()
    {
        return $this->story;
    }
    
    public function __toString()
    {
        return sprintf('%s %s', $this->user->getUsername(), $this->getText());
    }
    
}
