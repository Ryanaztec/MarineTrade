<?php

namespace App\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * BidInvite
 *
 * @ORM\Table(name="bid_invite")
 * @ORM\Entity()
 *
 * @Serializer\ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class BidInvite
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
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="seen", type="boolean")
     */
    private $seen = false;

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
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\Item", inversedBy="bidInvites")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\Item")
     * @ORM\JoinColumn(name="traded_item_id", referencedColumnName="id")
     */
    private $tradedItem;

    /**
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\User", inversedBy="sentBidInvites")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $bidOwner;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return BidInvite
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSeen()
    {
        return $this->seen;
    }

    /**
     * @param bool $seen
     * @return BidInvite
     */
    public function setSeen($seen)
    {
        $this->seen = (bool) $seen;
        return $this;
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
     * @return BidInvite
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
     * @return BidInvite
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
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
     * @return BidInvite
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     * @return BidInvite
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return Item
     */
    public function getTradedItem()
    {
        return $this->tradedItem;
    }

    /**
     * @param Item $tradedItem
     * @return BidInvite
     */
    public function setTradedItem(Item $tradedItem)
    {
        $this->tradedItem = $tradedItem;
        return $this;
    }

    /**
     * @return User
     */
    public function getBidOwner()
    {
        return $this->bidOwner;
    }

    /**
     * @param User $bidOwner
     * @return BidInvite
     */
    public function setBidOwner($bidOwner)
    {
        $this->bidOwner = $bidOwner;
        return $this;
    }
}
