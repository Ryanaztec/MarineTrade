<?php

namespace App\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use ApiBundle\Security\Authorization\UserOwnableInterface;

/**
 * Bid
 *
 * @ORM\Table(name="bid")
 * @ORM\Entity()
 *
 * @Serializer\ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class Bid //implements UserOwnableInterface
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
     * @ORM\Column(name="price", type="decimal", precision=11, scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accepted", type="boolean")
     */
    private $accepted = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rejected", type="boolean")
     */
    private $rejected = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="seen", type="boolean")
     */
    private $seen = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived = false;

    /**
     * @var array
     *
     * @ORM\Column(name="trade_items", type="simple_array", nullable=true)
     */
    private $tradeItems = [];

    /**
     * @var boolean
     *
     * @ORM\Column(name="seller_rated", type="boolean", nullable=true)
     */
    private $sellerRated = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="buyer_rated", type="boolean", nullable=true)
     */
    private $buyerRated = false;

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
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\Item", inversedBy="bids")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\User", inversedBy="bids")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\AppBundle\Entity\Message")
     * @ORM\JoinTable(name="bid_messages",
     *      joinColumns={@ORM\JoinColumn(name="bid_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $messages;

    /**
     * Bid constructor.
     */
    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->tradeItems = [];
    }

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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return Bid
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Bid
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAccepted()
    {
        return $this->accepted;
    }

    /**
     * @param bool $accepted
     * @return Bid
     */
    public function setAccepted($accepted)
    {
        $this->accepted = (bool) $accepted;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRejected()
    {
        return $this->rejected;
    }

    /**
     * @param bool $rejected
     * @return Bid
     */
    public function setRejected($rejected)
    {
        $this->rejected = (bool) $rejected;
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
     * @return Bid
     */
    public function setSeen($seen)
    {
        $this->seen = (bool) $seen;
        return $this;
    }

    /**
     * @return bool
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @param bool $archived
     * @return Bid
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
        return $this;
    }

    /**
     * @return array
     */
    public function getTradeItems()
    {
        return $this->tradeItems;
    }

    /**
     * @param array $tradeItems
     * @return Bid
     */
    public function setTradeItems(array $tradeItems)
    {
        $this->tradeItems = $tradeItems;
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function addTradeItem($id)
    {
        if ($id instanceof Item) {
            $id = $id->getId();
        }
        $this->tradeItems = array_unique(array_merge($this->tradeItems, [$id]));
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function removeTradeItem($id)
    {
        if ($id instanceof Item) {
            $id = $id->getId();
        }
        $key = array_search($id, $this->tradeItems);
        if ($key !== false) {
            unset($this->tradeItems[$key]);
        }
        return $this;
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasTradedItem($id)
    {
        return false !== array_search($id, $this->tradeItems);
    }

    /**
     * @return bool
     */
    public function isSellerRated()
    {
        return $this->sellerRated;
    }

    /**
     * @param bool $sellerRated
     * @return Bid
     */
    public function setSellerRated($sellerRated)
    {
        $this->sellerRated = $sellerRated;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBuyerRated()
    {
        return $this->buyerRated;
    }

    /**
     * @param bool $buyerRated
     * @return Bid
     */
    public function setBuyerRated($buyerRated)
    {
        $this->buyerRated = $buyerRated;
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
     * @return Bid
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
     * @return Bid
     */
    public function setUpdated($updated)
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
     * @return Bid
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
     * @param mixed $item
     * @return Bid
     */
    public function setItem($item)
    {
        $this->item = $item;
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
     * @return Bid
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param ArrayCollection $messages
     * @return Bid
     */
    public function setMessages(ArrayCollection $messages)
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * @param Message $message
     * @return $this
     */
    public function addMessage(Message $message)
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
        }
        return $this;
    }

    public function isOwnedBy(User $user)
    {
        $this->getUser()->isEqualTo($user);
    }

    public function __toString()
    {
	return $this->getPrice();
    }
}

