<?php

namespace Build\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Build\UserBundle\Entity\UserRepository")
 * @UniqueEntity(fields="username", message="Ce nom d'utilisateur est déjà utilisée.")
 * @UniqueEntity(fields="mail", message="Cette adresse mail est déjà enregistrer.")
 */
class Users implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=false)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50, nullable=false)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=50, nullable=false)
     */
    protected $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="auth_ticket", type="text", length=65535, nullable=false)
     */
    protected $authTicket;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=false)
     */
    protected $rank = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="credits", type="integer", nullable=false)
     */
    protected $credits = '50000';

    /**
     * @var integer
     *
     * @ORM\Column(name="vip_points", type="integer", nullable=false)
     */
    protected $vipPoints = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="activity_points", type="integer", nullable=false)
     */
    protected $activityPoints = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="activity_points_lastupdate", type="float", precision=10, scale=0, nullable=false)
     */
    protected $activityPointsLastupdate = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="look", type="string", length=255, nullable=false)
     */
    protected $look = 'hr-115-42.hd-190-1.ch-215-62.lg-285-91.sh-290-62';

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", nullable=false)
     */
    protected $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="motto", type="string", length=50, nullable=false)
     */
    protected $motto = 'Bienvenue sur Build ;)';

    /**
     * @var string
     *
     * @ORM\Column(name="account_created", type="string", length=50, nullable=false)
     */
    protected $accountCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="last_online", type="string", length=50, nullable=false)
     */
    protected $lastOnline;

    /**
     * @var string
     *
     * @ORM\Column(name="online", type="string", nullable=false)
     */
    protected $online = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ip_last", type="string", length=120, nullable=false)
     */
    protected $ipLast;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_reg", type="string", length=120, nullable=false)
     */
    protected $ipReg;

    /**
     * @var integer
     *
     * @ORM\Column(name="home_room", type="integer", nullable=false)
     */
    protected $homeRoom = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="newbie_status", type="integer", nullable=false)
     */
    protected $newbieStatus = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="is_muted", type="string", nullable=false)
     */
    protected $isMuted = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="block_newfriends", type="string", nullable=false)
     */
    protected $blockNewfriends = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="hide_online", type="string", nullable=false)
     */
    protected $hideOnline = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="hide_inroom", type="string", nullable=false)
     */
    protected $hideInroom = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="mail_verified", type="string", length=6, nullable=false)
     */
    protected $mailVerified = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="vip", type="string", nullable=false)
     */
    protected $vip = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="volume", type="integer", nullable=false)
     */
    protected $volume = '100';

    /**
     * @var string
     *
     * @ORM\Column(name="accept_trading", type="string", nullable=false)
     */
    protected $acceptTrading = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="jetons", type="integer", nullable=false)
     */
    protected $jetons = '0';

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    // // *
    // //  * @ORM\Column(name="is_active", type="boolean")
     
    // private $isActive;

    public function __construct()
    {
        // $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
    }

     /**
     * @inheritDoc
     */
    public function getRoles() {
        if($this->rank == 1){
            return array('ROLE_USER');
        }elseif($this->rank === 6){
            return array('ROLE_ADMIN');
        }
        elseif($this->rank === 7){
            return array('ROLE_SUPER_ADMIN');
        }
    }
  
     /**
     * @inheritDoc
     */
    public function getSalt() {
            return '';
    }

     /**
     * @inheritDoc
     */
    public function eraseCredentials() {
            // $this->mot_de_passe = '';
    }


     /**
     * @inheritDoc
     */
    public function equals(UserInterface $user) {
            return ($user->getUsername() == $this->getUsername());
    }


    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }


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
     * Set username
     *
     * @param string $username
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Users
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set authTicket
     *
     * @param string $authTicket
     * @return Users
     */
    public function setAuthTicket($authTicket)
    {
        $this->authTicket = $authTicket;

        return $this;
    }

    /**
     * Get authTicket
     *
     * @return string 
     */
    public function getAuthTicket()
    {
        return $this->authTicket;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Get credits
     *
     * @return integer 
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;
        return $this;
    }

    /**
     * Get credits
     *
     * @return integer 
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set vipPoints
     *
     * @return integer 
     */
    public function setVipPoints($vipPoints)
    {
        $this->vipPoints = $vipPoints;
        return $this;
    }

    /**
     * Get vipPoints
     *
     * @return integer 
     */
    public function getVipPoints()
    {
        return $this->vipPoints;
    }

    /**
     * Set activityPoints
     *
     * @return integer 
     */
    public function setActivityPoints($activityPoints)
    {
        $this->activityPoints = $activityPoints;
        return $this;
    }

    /**
     * Get activityPoints
     *
     * @return integer 
     */
    public function getActivityPoints()
    {
        return $this->activityPoints;
    }

    /**
     * Get activityPointsLastupdate
     *
     * @return float 
     */
    public function getActivityPointsLastupdate()
    {
        return $this->activityPointsLastupdate;
    }

    /**
     * Get look
     *
     * @return string 
     */
    public function getLook()
    {
        return $this->look;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Users
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set motto
     *
     * @return string 
     */
    public function setMotto($motto)
    {
        $this->motto = $motto;
        return $this;
    }

    /**
     * Get motto
     *
     * @return string 
     */
    public function getMotto()
    {
        return $this->motto;
    }

    /**
     * Set accountCreated
     *
     * @param string $accountCreated
     * @return Users
     */
    public function setAccountCreated($accountCreated)
    {
        $this->accountCreated = $accountCreated;

        return $this;
    }

    /**
     * Get accountCreated
     *
     * @return string 
     */
    public function getAccountCreated()
    {
        return $this->accountCreated;
    }

    /**
     * Set lastOnline
     *
     * @param string $lastOnline
     * @return Users
     */
    public function setLastOnline($lastOnline)
    {
        $this->lastOnline = $lastOnline;

        return $this;
    }

    /**
     * Get lastOnline
     *
     * @return string 
     */
    public function getLastOnline()
    {
        return $this->lastOnline;
    }

    /**
     * Get online
     *
     * @return string 
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set ipLast
     *
     * @param string $ipLast
     * @return Users
     */
    public function setIpLast($ipLast)
    {
        $this->ipLast = $ipLast;

        return $this;
    }

    /**
     * Get ipLast
     *
     * @return string 
     */
    public function getIpLast()
    {
        return $this->ipLast;
    }

    /**
     * Set ipReg
     *
     * @param string $ipReg
     * @return Users
     */
    public function setIpReg($ipReg)
    {
        $this->ipReg = $ipReg;

        return $this;
    }

    /**
     * Get ipReg
     *
     * @return string 
     */
    public function getIpReg()
    {
        return $this->ipReg;
    }

    /**
     * Get homeRoom
     *
     * @return integer 
     */
    public function getHomeRoom()
    {
        return $this->homeRoom;
    }

    /**
     * Get newbieStatus
     *
     * @return integer 
     */
    public function getNewbieStatus()
    {
        return $this->newbieStatus;
    }

    /**
     * Get isMuted
     *
     * @return string 
     */
    public function getIsMuted()
    {
        return $this->isMuted;
    }

    /**
     * Get blockNewfriends
     *
     * @return string 
     */
    public function getBlockNewfriends()
    {
        return $this->blockNewfriends;
    }

    /**
     * Get hideOnline
     *
     * @return string 
     */
    public function getHideOnline()
    {
        return $this->hideOnline;
    }

    /**
     * Get hideInroom
     *
     * @return string 
     */
    public function getHideInroom()
    {
        return $this->hideInroom;
    }

    /**
     * Get mailVerified
     *
     * @return string 
     */
    public function getMailVerified()
    {
        return $this->mailVerified;
    }

    /**
     * Set vip
     *
     * @return string 
     */
    public function setVip($vip)
    {
        $this->vip = $vip;
        return $this;
    }

    /**
     * Get vip
     *
     * @return string 
     */
    public function getVip()
    {
        return $this->vip;
    }

    /**
     * Set volume
     *
     * @return integer 
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
        return $this;
    }

    /**
     * Get volume
     *
     * @return integer 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * set acceptTrading
     *
     * @return string 
     */
    public function setAcceptTrading($acceptTrading)
    {
        $this->acceptTrading = $acceptTrading;
        return $this;
    }

    /**
     * Get acceptTrading
     *
     * @return string 
     */
    public function getAcceptTrading()
    {
        return $this->acceptTrading;
    }

    /**
     * set jetons
     *
     * @return integer 
     */
    public function setJetons($jetons)
    {
        $this->jetons = $jetons;
        return $this;
    }

    /**
     * Get jetons
     *
     * @return integer 
     */
    public function getJetons()
    {
        return $this->jetons;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return Users
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Set activityPointsLastupdate
     *
     * @param float $activityPointsLastupdate
     * @return Users
     */
    public function setActivityPointsLastupdate($activityPointsLastupdate)
    {
        $this->activityPointsLastupdate = $activityPointsLastupdate;

        return $this;
    }

    /**
     * Set look
     *
     * @param string $look
     * @return Users
     */
    public function setLook($look)
    {
        $this->look = $look;

        return $this;
    }

    /**
     * Set online
     *
     * @param string $online
     * @return Users
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Set homeRoom
     *
     * @param integer $homeRoom
     * @return Users
     */
    public function setHomeRoom($homeRoom)
    {
        $this->homeRoom = $homeRoom;

        return $this;
    }

    /**
     * Set newbieStatus
     *
     * @param integer $newbieStatus
     * @return Users
     */
    public function setNewbieStatus($newbieStatus)
    {
        $this->newbieStatus = $newbieStatus;

        return $this;
    }

    /**
     * Set isMuted
     *
     * @param string $isMuted
     * @return Users
     */
    public function setIsMuted($isMuted)
    {
        $this->isMuted = $isMuted;

        return $this;
    }

    /**
     * Set blockNewfriends
     *
     * @param string $blockNewfriends
     * @return Users
     */
    public function setBlockNewfriends($blockNewfriends)
    {
        $this->blockNewfriends = $blockNewfriends;

        return $this;
    }

    /**
     * Set hideOnline
     *
     * @param string $hideOnline
     * @return Users
     */
    public function setHideOnline($hideOnline)
    {
        $this->hideOnline = $hideOnline;

        return $this;
    }

    /**
     * Set hideInroom
     *
     * @param string $hideInroom
     * @return Users
     */
    public function setHideInroom($hideInroom)
    {
        $this->hideInroom = $hideInroom;

        return $this;
    }

    /**
     * Set mailVerified
     *
     * @param string $mailVerified
     * @return Users
     */
    public function setMailVerified($mailVerified)
    {
        $this->mailVerified = $mailVerified;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Users
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }
}
