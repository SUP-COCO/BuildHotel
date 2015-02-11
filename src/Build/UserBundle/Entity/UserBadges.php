<?php

namespace Build\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="user_badges")
 * @ORM\Entity
 */
class UserBadges
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    protected $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="badge_id", type="string", nullable=false)
     */
    protected $badgeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="badge_slot", type="integer", nullable=false)
     */
    protected $badgeSlot;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get img
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get img
     *
     * @return string 
     */
    public function getBadgeId()
    {
        return $this->badgeId;
    }

    /**
     * Get img
     *
     * @return integer
     */
    public function getBadgeSlot()
    {
        return $this->badgeSlot;
    }
}
