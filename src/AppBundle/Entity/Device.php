<?php

namespace App\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Yacht\ApiBundle\Security\Authorization\UserOwnableInterface;

/**
 * Device
 *
 * @ORM\Table(name="device")
 * @ORM\Entity()
 *
 * @Serializer\ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class Device //implements UserOwnableInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="notification_token", type="string", length=1024, nullable=true)
     */
    private $notificationToken;

    /**
     * @var string
     *
     * @ORM\Column(name="device_id", type="string", length=255)
     */
    private $deviceId;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="smallint", nullable=true)
     */
    private $type;

    /**
     * @var \DateTime $contentChanged
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"token"})
     */
    private $lastLogin;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var \DateTime $deleted
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\User", inversedBy="devices")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Device constructor.
     */
    public function __construct()
    {
        $this->lastLogin = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNotificationToken()
    {
        return $this->notificationToken;
    }

    /**
     * @param string $notificationToken
     * @return Device
     */
    public function setNotificationToken($notificationToken)
    {
        $this->notificationToken = $notificationToken;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * @param string $deviceId
     * @return Device
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Device
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Device
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Device
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     * @return Device
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return Device
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return Device
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    public function isOwnedBy(User $user)
    {
        $this->getUser()->isEqualTo($user);
    }

    public function __toString()
    {
	return $this->getDeviceId();
    }
    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     * @return Device
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

}

