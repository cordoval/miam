<?php

namespace Application\MiamBundle\Entity;
use Bundle\DoctrineUserBundle\Entity\User;
use Application\MiamBundle\Entity\Story;

/**
 * @Entity(repositoryClass="Application\MiamBundle\Entity\TimelineEntryRepository")
 * @Table(name="miam_timeline")
 * @HasLifecycleCallbacks
 */
class TimelineEntry
{
    /**
     * @ManyToOne(targetEntity="Bundle\DoctrineUserBundle\Entity\User", inversedBy="timelineEntries")
     * @JoinColumn(name="user_id", nullable=false)
     */
    protected $user;

    /**
     * @ManyToOne(targetEntity="Story", inversedBy="timelineEntries")
     * @JoinColumn(name="story_id", nullable=false)
     */
    protected $story;

    /**
     * The story points when this entry was created
     * @Column(name="points", type="integer", nullable=true)
     * @var int
     */
    protected $points = null;

    /**
     * @Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @Column(name="action", type="integer") 
     */
    protected $action;
    
    /**
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    const ACTION_CREATE = 10;
    const ACTION_DELETE = 15;
    const ACTION_ESTIMATE = 20;
    const ACTION_REESTIMATE = 30;
    const ACTION_COMMENT = 40;
    const ACTION_EDIT = 50;
    const ACTION_SCHEDULE = 60;
    const ACTION_UNSCHEDULE = 70;
    const ACTION_STATE_PENDING = 1000;
    const ACTION_STATE_TODO = 1010;
    const ACTION_STATE_WIP = 1020;
    const ACTION_STATE_FINISHED = 1030;

    protected $textualActions = array(
        self::ACTION_CREATE => 'a créé {story}',
        self::ACTION_DELETE => 'a supprimé {story}',
        self::ACTION_ESTIMATE => 'a estimé {story} à {points} points',
        self::ACTION_REESTIMATE => 'a réestimé {story} à {points} points',
        self::ACTION_COMMENT => 'a commenté {story}',
        self::ACTION_EDIT => 'a mis à jour {story}',
        self::ACTION_SCHEDULE => 'a ajouté {story} au sprint',
        self::ACTION_UNSCHEDULE => 'a retiré {story} du sprint',
        self::ACTION_STATE_PENDING => "a passé {story} dans l'état EN ATTENTE",
        self::ACTION_STATE_TODO => "a passé {story} dans l'état À FAIRE",
        self::ACTION_STATE_WIP => "a commencé à travailler sur {story}",
        self::ACTION_STATE_FINISHED => "a fini {story}"
    );

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    /** @PrePersist */
    public function doStuffOnPrePersist()
    {
        if(null === $this->createdAt) {
            $this->createdAt = new \DateTime();
        }
    }
    
    /**
     * Get points
     * @return int
     */
    public function getPoints()
    {
      return $this->points;
    }
    
    /**
     * Set points
     * @param  int
     * @return null
     */
    public function setPoints($points)
    {
      $this->points = $points;
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
      static $actions = array(
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

      return $actions;
    }

    public static function getActionForStoryStatus($status)
    {
      static $matches = array(
        Story::STATUS_PENDING => self::ACTION_STATE_PENDING,
        Story::STATUS_TODO => self::ACTION_STATE_TODO,
        Story::STATUS_WIP => self::ACTION_STATE_WIP,
        Story::STATUS_FINISHED => self::ACTION_STATE_FINISHED
      );

      return isset($matches[$status]) ? $matches[$status] : null;
    }
    
    public function renderAction()
    {
      return $this->textualActions[$this->action];
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
