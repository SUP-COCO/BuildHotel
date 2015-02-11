<?php

namespace Build\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServerStatus
 *
 * @ORM\Table(name="server_status")
 * @ORM\Entity
 */
class ServerStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     * @ORM\Id
     */
    protected $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="users_online", type="integer", nullable=false)
     */
    protected $usersOnline;

    /**
     * @var integer
     *
     * @ORM\Column(name="rooms_loaded", type="integer", nullable=false)
     */
    protected $roomLoaded;

    /**
     * @var string
     *
     * @ORM\Column(name="server_ver", type="string", nullable=false)
     */
    protected $serverVer;

    /**
     * @var string
     *
     * @ORM\Column(name="stamp", type="string", nullable=false)
     */
    protected $stamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="userpeak", type="integer", nullable=false)
     */
    protected $userpeak;

    /**
     * Get authTicket
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get authTicket
     *
     * @return integer
     */
    public function getUsersOnline()
    {
        return $this->usersOnline;
    }

    /**
     * Get authTicket
     *
     * @return integer
     */
    public function getRoomLoaded()
    {
        return $this->roomLoaded;
    }

    /**
     * Get authTicket
     *
     * @return string
     */
    public function getServerVer()
    {
        return $this->serverVer;
    }

    /**
     * Get authTicket
     *
     * @return string
     */
    public function getStamp()
    {
        return $this->stamp;
    }

    /**
     * Get authTicket
     *
     * @return string
     */
    public function getUserpeak()
    {
        return $this->userpeak;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return ServerStatus
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set usersOnline
     *
     * @param integer $usersOnline
     * @return ServerStatus
     */
    public function setUsersOnline($usersOnline)
    {
        $this->usersOnline = $usersOnline;

        return $this;
    }

    /**
     * Set roomLoaded
     *
     * @param integer $roomLoaded
     * @return ServerStatus
     */
    public function setRoomLoaded($roomLoaded)
    {
        $this->roomLoaded = $roomLoaded;

        return $this;
    }

    /**
     * Set serverVer
     *
     * @param string $serverVer
     * @return ServerStatus
     */
    public function setServerVer($serverVer)
    {
        $this->serverVer = $serverVer;

        return $this;
    }

    /**
     * Set stamp
     *
     * @param string $stamp
     * @return ServerStatus
     */
    public function setStamp($stamp)
    {
        $this->stamp = $stamp;

        return $this;
    }

    /**
     * Set userpeak
     *
     * @param integer $userpeak
     * @return ServerStatus
     */
    public function setUserpeak($userpeak)
    {
        $this->userpeak = $userpeak;

        return $this;
    }
}
