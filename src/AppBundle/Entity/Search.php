<?php

namespace App\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use App\AppBundle\Entity\User;
use App\AppBundle\Entity\Device;

/**
 * Search
 * @ORM\Entity
 * @ORM\Table(name="search")
 *
 * @Serializer\ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class Search
{
    const FREQ_DAILY = 1;
    const FREQ_WEEKLY = 2;
    const FREQ_FORTNIGHTLY = 3;

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
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="term", type="string", nullable=true)
     */
    private $term;

    /**
     * @var float
     *
     * @ORM\Column(name="price_min", type="decimal", precision=11, scale=2, nullable=true)
     */
    private $priceMin;

    /**
     * @var float
     *
     * @ORM\Column(name="price_max", type="decimal", precision=11, scale=2, nullable=true)
     */
    private $priceMax;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="decimal", precision=18, scale=15, nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="decimal", precision=18, scale=15, nullable=true)
     */
    private $longitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="area", type="integer", nullable=true)
     */
    private $area;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wanted", type="boolean", nullable=true)
     */
    private $wanted;

    /**
     * @var boolean
     *
     * @ORM\Column(name="trades", type="boolean", nullable=true)
     */
    private $trades;

    /**
     * @var boolean
     *
     * @ORM\Column(name="negotiable", type="boolean", nullable=true)
     */
    private $negotiable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="local_pickup", type="boolean", nullable=true)
     */
    private $localPickup;

    /**
     * @var boolean
     *
     * @ORM\Column(name="push_notification", type="boolean", nullable=true)
     */
    private $pushNotification;

    /**
     * @var boolean
     *
     * @ORM\Column(name="email_notification", type="boolean", nullable=true)
     */
    private $emailNotification;

    /**
     * @var integer
     *
     * @ORM\Column(name="notification_frequency", type="smallint", nullable=true)
     */
    private $notificationFrequency = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="shipping_supported", type="boolean", nullable=true)
     */
    private $shippingSupported;

    /**
     * @var array
     *
     * @ORM\Column(name="order_by", type="array", nullable=true)
     */
    private $orderBy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="metric_range", type="boolean", nullable=true)
     */
    private $metric = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="per_page", type="integer", nullable=true)
     */
    private $perPage = 50;

    /**
     * @var integer
     *
     * @ORM\Column(name="page_number", type="integer", nullable=true)
     */
    private $pageNumber = 1;

    /**
     * @var array
     *
     * @ORM\Column(name="results", type="array", nullable=true)
     */
    private $results = [];

    /**
     * @var ItemCondition
     *
     * @ORM\OneToOne(targetEntity="App\AppBundle\Entity\ItemCondition")
     * @ORM\JoinColumn(name="condition_id", referencedColumnName="id")
     */
    private $condition;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\AppBundle\Entity\Category")
     * @ORM\JoinTable(name="search_categories",
     *      joinColumns={@ORM\JoinColumn(name="search_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\User", inversedBy="searches")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Search constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param string $term
     * @return Search
     */
    public function setTerm($term)
    {
        $this->term = $term;
        return $this;
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
     * @return Search
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceMin()
    {
        return $this->priceMin;
    }

    /**
     * @param float $priceMin
     * @return Search
     */
    public function setPriceMin($priceMin)
    {
        $this->priceMin = $priceMin;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceMax()
    {
        return $this->priceMax;
    }

    /**
     * @param float $priceMax
     * @return Search
     */
    public function setPriceMax($priceMax)
    {
        $this->priceMax = $priceMax;
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return Search
     */
    public function setLatitude($latitude)
    {
        $this->latitude = (float) $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return Search
     */
    public function setLongitude($longitude)
    {
        $this->longitude = (float) $longitude;
        return $this;
    }

    /**
     * @return int
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param int $area
     * @return Search
     */
    public function setArea($area)
    {
        $this->area = $area;
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
     * @return Search
     */
    public function setWanted($wanted)
    {
        $this->wanted = $wanted;
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
     * @return Search
     */
    public function setTrades($trades)
    {
        $this->trades = $trades;
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
     * @return Search
     */
    public function setNegotiable($negotiable)
    {
        $this->negotiable = $negotiable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLocalPickup()
    {
        return $this->localPickup;
    }

    /**
     * @param bool $localPickup
     * @return Search
     */
    public function setLocalPickup($localPickup)
    {
        $this->localPickup = $localPickup;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPushNotification()
    {
        return $this->pushNotification;
    }

    /**
     * @param bool $pushNotification
     * @return Search
     */
    public function setPushNotification($pushNotification)
    {
        $this->pushNotification = $pushNotification;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEmailNotification()
    {
        return $this->emailNotification;
    }

    /**
     * @param bool $emailNotification
     * @return Search
     */
    public function setEmailNotification($emailNotification)
    {
        $this->emailNotification = $emailNotification;
        return $this;
    }

    /**
     * @return integer
     */
    public function getNotificationFrequency()
    {
        return $this->notificationFrequency;
    }

    /**
     * @param integer $notificationFrequency
     * @return Search
     */
    public function setNotificationFrequency($notificationFrequency)
    {
        $this->notificationFrequency = $notificationFrequency;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShippingSupported()
    {
        return $this->shippingSupported;
    }

    /**
     * @param bool $shippingSupported
     * @return Search
     */
    public function setShippingSupported($shippingSupported)
    {
        $this->shippingSupported = $shippingSupported;
        return $this;
    }

    /**
     * @return array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param array $orderBy
     * @return Search
     */
    public function setOrderBy(array $orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMetric()
    {
        return $this->metric;
    }

    /**
     * @param bool $metric
     * @return $this
     */
    public function setMetric($metric)
    {
        $this->metric = $metric;
        return $this;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     * @return Search
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @return int
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * @param int $pageNumber
     * @return Search
     */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
        return $this;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param array $results
     * @return Search
     */
    public function setResults(array $results)
    {
        $this->results = $results;
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
     * @return Search
     */
    public function setCondition(ItemCondition $condition)
    {
        $this->condition = $condition;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection $categories
     * @return Search
     */
    public function setCategories(ArrayCollection $categories)
    {
        $this->categories = $categories;
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
     * @return Search
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * @return Search
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
     * @return Search
     */
    public function setUpdated(\DateTime $updated)
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
     * @return Search
     */
    public function setDeleted(\DateTime $deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @param User $user
     */
    public function isOwnedBy(User $user)
    {
        $this->getUser()->isEqualTo($user);
    }
}

