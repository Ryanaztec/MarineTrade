<?php

namespace App\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity()
 *
 * @Serializer\ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class Item
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
     * @ORM\Column(name="title", type="string", length=128, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=11, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="views", type="integer", nullable=true)
     */
    private $views = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=18, scale=15, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=18, scale=15, nullable=true)
     */
    private $longitude;

    /**
     * @var boolean
     *
     * @ORM\Column(name="use_user_location", type="boolean", nullable=true)
     */
    private $useUserLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="location_city", type="string", length=255, nullable=true)
     */
    private $locationCity;

    /**
     * @var string
     *
     * @ORM\Column(name="location_country", type="string", length=255, nullable=true)
     */
    private $locationCountry;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_zip", type="integer", nullable=true)
     */
    private $locationZip;

    /**
     * @var boolean
     *
     * @ORM\Column(name="negotiable", type="boolean", nullable=true)
     */
    private $negotiable = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="trades", type="boolean", nullable=true)
     */
    private $trades = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    private $archived = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_suspended", type="boolean", nullable=true)
     */
    private $isSuspended = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="favorite_count", type="integer", nullable=true)
     */
    private $favoriteCount = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="trending_score", type="integer", nullable=true)
     */
    private $trendingScore = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="delivery_method_id", type="integer", nullable=true)
     */
    private $deliveryMethod;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wanted", type="boolean", nullable=true)
     */
    private $wanted = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sold", type="boolean", nullable=true)
     */
    private $sold = false;

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
     * @var ItemCondition
     *
     * @ORM\OneToOne(targetEntity="App\AppBundle\Entity\ItemCondition")
     * @ORM\JoinColumn(name="condition_id", referencedColumnName="id")
     */
    private $condition;

    /**
     * @ORM\OneToOne(targetEntity="App\AppBundle\Entity\Bid")
     * @ORM\JoinColumn(name="bid_id", referencedColumnName="id")
     */
    private $acceptedBid;

    /**
     * @ORM\OneToMany(targetEntity="App\AppBundle\Entity\Bid", mappedBy="item")
     */
    private $bids;

    /**
     * @ORM\ManyToMany(targetEntity="App\AppBundle\Entity\Media")
     * @ORM\JoinTable(name="item_media",
     *      joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $media;

    /**
     * @ORM\ManyToMany(targetEntity="App\AppBundle\Entity\Category")
     * @ORM\JoinTable(name="item_category",
     *      joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\AppBundle\Entity\Tag")
     * @ORM\JoinTable(name="item_tag",
     *      joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\User", inversedBy="items")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\AppBundle\Entity\Message")
     * @ORM\JoinTable(name="item_messages",
     *      joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $messages;

    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->trendingScore = 0;
        $this->media = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->bids = new ArrayCollection();
        $this->messages = new ArrayCollection();
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Item
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
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
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param int $views
     * @return Item
     */
    public function setViews($views)
    {
        $this->views = $views;
        return $this;
    }

    /**
     * @return $this
     */
    public function incrementViews()
    {
        $this->views += 1;
        return $this;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     * @return Item
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocationLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     * @return Item
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseUserLocation()
    {
        return $this->useUserLocation;
    }

    /**
     * @param bool $useUserLocation
     * @return Item
     */
    public function setUseUserLocation($useUserLocation)
    {
        $this->useUserLocation = $useUserLocation;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocationCity()
    {
        return $this->locationCity;
    }

    /**
     * @param string $locationCity
     * @return Item
     */
    public function setLocationCity($locationCity)
    {
        $this->locationCity = $locationCity;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocationCountry()
    {
        return $this->locationCountry;
    }

    /**
     * @param string $locationCountry
     * @return Item
     */
    public function setLocationCountry($locationCountry)
    {
        $this->locationCountry = $locationCountry;
        return $this;
    }

    /**
     * @return int
     */
    public function getLocationZip()
    {
        return $this->locationZip;
    }

    /**
     * @param int $locationZip
     * @return Item
     */
    public function setLocationZip($locationZip)
    {
        $this->locationZip = $locationZip;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNegotiable()
    {
        return $this->negotiable;
    }

    /**
     * @param bool $negotiable
     * @return Item
     */
    public function setNegotiable($negotiable)
    {
        $this->negotiable = (bool) $negotiable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTrades()
    {
        return $this->trades;
    }

    /**
     * @param bool $trades
     * @return Item
     */
    public function setTrades($trades)
    {
        $this->trades = $trades;
        return $this;
    }

    /**
     * @return ItemCondition
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param ItemCondition $condition
     * @return Item
     */
    public function setCondition(ItemCondition $condition)
    {
        $this->condition = $condition;
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
     * @return Item
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsSuspended()
    {
        return $this->isSuspended;
    }

    /**
     * @param bool $isSuspended
     * @return Item
     */
    public function setIsSuspended($isSuspended)
    {
        $this->isSuspended = $isSuspended;
        return $this;
    }

    /**
     * @return int
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * @param int $favoriteCount
     * @return Item
     */
    public function setFavoriteCount($favoriteCount)
    {
        $this->favoriteCount = $favoriteCount;
        return $this;
    }

    /**
     * @return $this
     */
    public function incrementFavoriteCount()
    {
        $this->favoriteCount += 1;
        return $this;
    }

    /**
     * @return $this
     */
    public function decrementFavoriteCount()
    {
        $this->favoriteCount = max(0, $this->favoriteCount - 1);
        return $this;
    }

    /**
     * @return int
     */
    public function getTrendingScore()
    {
        return $this->trendingScore;
    }

    /**
     * @param int $trendingScore
     * @return Item
     */
    public function setTrendingScore($trendingScore)
    {
        $this->trendingScore = max(0, $trendingScore);
        return $this;
    }

    /**
     * @return int
     */
    public function getDeliveryMethod()
    {
        return $this->deliveryMethod;
    }

    /**
     * @param int $deliveryMethod
     * @return Item
     */
    public function setDeliveryMethod($deliveryMethod)
    {
        $this->deliveryMethod = $deliveryMethod;
        return $this;
    }

    /**
     * @return bool
     */
    public function isWanted()
    {
        return $this->wanted;
    }

    /**
     * @param bool $wanted
     * @return Item
     */
    public function setWanted($wanted)
    {
        $this->wanted = (bool) $wanted;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSold()
    {
        return $this->sold;
    }

    /**
     * @param bool $sold
     * @return Item
     */
    public function setSold($sold)
    {
        $this->sold = $sold;
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
     * @return Item
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
     * @return Item
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
     * @return Item
     */
    public function setDeleted(\DateTime $deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAcceptedBid()
    {
        return $this->acceptedBid;
    }

    /**
     * @param mixed $acceptedBid
     * @return Item
     */
    public function setAcceptedBid($acceptedBid)
    {
        $this->acceptedBid = $acceptedBid;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBids()
    {
        return $this->bids;
    }

    /**
     * @param ArrayCollection $bids
     * @return Item
     */
    public function setBids(ArrayCollection $bids)
    {
        $this->bids = $bids;
        return $this;
    }

    /**
     * @param Bid $bid
     * @return $this
     */
    public function addBid(Bid $bid)
    {
        if (!$this->bids->contains($bid)) {
            $this->bids->add($bid);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param mixed $media
     * @return Item
     */
    public function setMedia($media)
    {
        $this->media = $media;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Collection $categories
     * @return Item
     */
    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function addCategory(Category $category)
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Collection $tags
     * @return Item
     */
    public function setTags(Collection $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param Tag $tag
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Item
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
     * @return Item
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

    public function __toString()
    {
	return (string) $this->getTitle();
    }
}
