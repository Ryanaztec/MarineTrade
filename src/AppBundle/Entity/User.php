<?php

namespace App\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Yacht\ApiBundle\Security\Authorization\UserOwnableInterface;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="username_UNIQUE", columns={"email"})})
 * @ORM\Entity()
 *
 * @Serializer\ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class User implements AdvancedUserInterface, EquatableInterface //, UserOwnableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=254)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Serializer\Exclude
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     * @Serializer\Exclude
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="simple_array")
     * @Serializer\Exclude
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="is_deactivated", type="boolean")
     */
    private $deactivated = false;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=128)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=128, nullable=true)
     */
    private $lastName;

    /**
     * @var integer
     *
     * @ORM\Column(name="facebook_id", type="bigint", nullable=true)
     */
    private $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15, nullable=true)
     */
    private $phone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="newsletter_subscribed", type="boolean", nullable=true)
     */
    private $newsletterSubscribed;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var integer
     *
     * @ORM\Column(name="trending_score", type="integer", nullable=true)
     */
    private $trendingScore = 0;

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
     * @ORM\OneToMany(targetEntity="App\AppBundle\Entity\Device", mappedBy="user")
     */
    private $devices;

    /**
     * @ORM\OneToOne(targetEntity="App\AppBundle\Entity\Device")
     * @ORM\JoinColumn(name="last_device_id", referencedColumnName="id")
     */
    private $lastDevice;

    /**
     * @ORM\OneToMany(targetEntity="App\AppBundle\Entity\Address", mappedBy="user")
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="App\AppBundle\Entity\Item", mappedBy="user", fetch="EAGER")
     */
    private $items;

    /**
     * @ORM\ManyToMany(targetEntity="App\AppBundle\Entity\Item")
     * @ORM\JoinTable(name="favorite_items",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")}
     * )
     */
    private $favoriteItems;

    /**
     * @ORM\OneToMany(targetEntity="App\AppBundle\Entity\Bid", mappedBy="user")
     */
    private $bids;

    /**
     * @ORM\OneToMany(targetEntity="App\AppBundle\Entity\Sync", mappedBy="user")
     */
    private $syncs;

    /**
     * @ORM\ManyToMany(targetEntity="App\AppBundle\Entity\User", mappedBy="following")
     */
    private $followers;

    /**
     * @ORM\ManyToMany(targetEntity="App\AppBundle\Entity\User", inversedBy="followers")
     * @ORM\JoinTable(name="followers",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="follower_user_id", referencedColumnName="id")}
     * )
     */
    private $following;

    /**
     * @ORM\OneToMany(targetEntity="App\AppBundle\Entity\Message", mappedBy="author")
     */
    private $messages_sent;

    /**
     * @ORM\OneToMany(targetEntity="App\AppBundle\Entity\Message", mappedBy="receiver")
     */
    private $messages_received;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->salt = md5(random_bytes(10));
        $this->trendingScore = 0;
        $this->isActive = true;
        $this->roles = ['ROLE_USER'];
        $this->devices = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->items = new ArrayCollection();
//        $this->favoriteItems = new ArrayCollection();
        $this->bids = new ArrayCollection();
        $this->syncs = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->messages_sent = new ArrayCollection();
        $this->messages_received = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return true;
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function addRole($role)
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return in_array('ROLE_ADMIN', $this->getRoles());
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function setUsername($email)
    {
        $this->email = $email;
        return $this;
    }

    public function eraseCredentials()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return (bool) $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive($isActive)
    {
        $this->isActive = (bool) $isActive;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isDeactivated()
    {
        return (bool) $this->deactivated;
    }

    /**
     * @param mixed $deactivated
     * @return User
     */
    public function setDeactivated($deactivated)
    {
        $this->deactivated = (bool) $deactivated;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return int
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param $facebookId
     * @return $this
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNewsletterSubscribed()
    {
        return $this->newsletterSubscribed;
    }

    /**
     * @param $newsletterSubscribed
     * @return $this
     */
    public function setNewsletterSubscribed($newsletterSubscribed)
    {
        $this->newsletterSubscribed = $newsletterSubscribed;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param $photo
     * @return $this
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
     * @return User
     */
    public function setTrendingScore($trendingScore)
    {
        $this->trendingScore = max(0, $trendingScore);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param Collection $devices
     * @return $this
     */
    public function setDevices(Collection $devices)
    {
        $this->devices = $devices;
        return $this;
    }

    /**
     * @param Device $device
     * @return $this
     */
    public function addDevice(Device $device)
    {
        if (!$this->devices->contains($device)) {
            $this->devices->add($device);
        }
        return $this;
    }

    /**
     * @return Device
     */
    public function getLastDevice()
    {
        return $this->lastDevice;
    }

    /**
     * @param Device $lastDevice
     * @return User
     */
    public function setLastDevice(Device $lastDevice)
    {
        $this->lastDevice = $lastDevice;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param Collection $addresses
     * @return $this
     */
    public function setAddresses(Collection $addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @param Address $address
     * @return $this
     */
    public function addAddress(Address $address)
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Collection $items
     * @return $this
     */
    public function setItems(Collection $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item)
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getFavoriteItems()
    {
        return $this->favoriteItems;
    }

    /**
     * @param Collection $favoriteItems
     * @return $this
     */
    public function setFavoriteItems(Collection $favoriteItems)
    {
        $this->favoriteItems = $favoriteItems;
        return $this;
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function addFavoriteItem(Item $item)
    {
        if (!$this->favoriteItems->contains($item)) {
            $this->favoriteItems->add($item);
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getBids()
    {
        return $this->bids;
    }

    /**
     * @param Collection $bids
     * @return $this
     */
    public function setBids(Collection $bids)
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
     * @return Collection
     */
    public function getSyncs()
    {
        return $this->syncs;
    }

    /**
     * @param Collection $syncs
     * @return $this
     */
    public function setSyncs(Collection $syncs)
    {
        $this->syncs = $syncs;
        return $this;
    }

    /**
     * @param Sync $sync
     * @return $this
     */
    public function addSync(Sync $sync)
    {
        if (!$this->syncs->contains($sync)) {
            $this->syncs->add($sync);
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @param Collection $followers
     * @return $this
     */
    public function setFollowers(Collection $followers)
    {
        $this->followers = $followers;
        return $this;
    }

    /**
     * @param User $follower
     * @return $this
     */
    public function addFollower(User $follower)
    {
        if (!$this->followers->contains($follower)) {
            $this->followers->add($follower);
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * @param Collection $following
     * @return $this
     */
    public function setFollowing(Collection $following)
    {
        $this->following = $following;
        return $this;
    }

    /**
     * @param User $follow
     * @return $this
     */
    public function addFollow(User $follow)
    {
        if (!$this->following->contains($follow)) {
            $this->following->add($follow);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessagesSent()
    {
        return $this->messages_sent;
    }

    /**
     * @param ArrayCollection $messagesSent
     * @return User
     */
    public function setMessagesSent(ArrayCollection $messagesSent)
    {
        $this->messages_sent = $messagesSent;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMessagesReceived()
    {
        return $this->messages_received;
    }

    /**
     * @param mixed $messagesReceived
     * @return User
     */
    public function setMessagesReceived($messagesReceived)
    {
        $this->messages_received = $messagesReceived;
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
     * @return $this
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
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
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
     * @return User
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    public function isOwnedBy(User $user)
    {
        return $this->isEqualTo($user);
    }

    public function isEqualTo(UserInterface $user)
    {
        return $user->getUsername() === $this->getUsername();
    }

    public function __toString()
    {
	return $this->getLastName() . " " . $this->getFirstName();
    }
}
