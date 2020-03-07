<?php

namespace App\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use App\AppBundle\Entity\User;
use App\AppBundle\Entity\Device;

/**
 * Sync
 *
 * @ORM\Table(name="sync", uniqueConstraints={@ORM\UniqueConstraint(name="sync_unique", columns={"user_id", "device_id"})})
 * @ORM\Entity()
 *
 * @Serializer\ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class Sync
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\User", inversedBy="syncs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var Device
     *
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\Device", inversedBy="syncs")
     * @ORM\JoinColumn(name="device_id", referencedColumnName="id")
     */
    private $device;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return Sync
     */
    public function setCreated($created)
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
     * @return Sync
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param \DateTime $deleted
     * @return Sync
     */
    public function setDeleted(\DateTime $deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return \App\AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \AppBundle\Entity\User $user
     * @return Sync
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \App\AppBundle\Entity\Device
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param \App\AppBundle\Entity\Device $device
     * @return Sync
     */
    public function setDevice($device)
    {
        $this->device = $device;
        return $this;
    }

    public function __toString()
    {
	return "";
    }
}
