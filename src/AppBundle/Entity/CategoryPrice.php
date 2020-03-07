<?php

namespace App\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Yacht\ApiBundle\Security\Authorization\UserOwnableInterface;

/**
 * @ORM\Table(name="category_price")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 *
 * @Serializer\ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class CategoryPrice
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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="urgent_7", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $urgent7;

    /**
     * @var string
     *
     * @ORM\Column(name="urgent_14", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $urgent14;

    /**
     * @var string
     *
     * @ORM\Column(name="urgent_21", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $urgent21;

    /**
     * @var string
     *
     * @ORM\Column(name="highlight_7", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $highlight7;

    /**
     * @var string
     *
     * @ORM\Column(name="highlight_14", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $highlight14;

    /**
     * @var string
     *
     * @ORM\Column(name="highlight_21", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $highlight21;

    /**
     * @var string
     *
     * @ORM\Column(name="spotlight_7", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $spotlight7;

    /**
     * @var string
     *
     * @ORM\Column(name="spotlight_14", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $spotlight14;

    /**
     * @var string
     *
     * @ORM\Column(name="spotlight_21", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $spotlight21;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return CategoryPrice
     */
    public function setCategory(Category $category)
    {
        $this->category= $category;
        return $this;
    }

    /**
     * Set urgent7
     *
     * @param string $urgent7
     *
     * @return CategoryPrice
     */
    public function setUrgent7($urgent7)
    {
        $this->urgent7 = $urgent7;

        return $this;
    }

    /**
     * Get urgent7
     *
     * @return string
     */
    public function getUrgent7()
    {
        return $this->urgent7;
    }

    /**
     * Set urgent14
     *
     * @param string $urgent14
     *
     * @return CategoryPrice
     */
    public function setUrgent14($urgent14)
    {
        $this->urgent14 = $urgent14;

        return $this;
    }

    /**
     * Get urgent14
     *
     * @return string
     */
    public function getUrgent14()
    {
        return $this->urgent14;
    }

    /**
     * Set urgent21
     *
     * @param string $urgent21
     *
     * @return CategoryPrice
     */
    public function setUrgent21($urgent21)
    {
        $this->urgent21 = $urgent21;

        return $this;
    }

    /**
     * Get urgent21
     *
     * @return string
     */
    public function getUrgent21()
    {
        return $this->urgent21;
    }

    /**
     * Set highlight7
     *
     * @param string $highlight7
     *
     * @return CategoryPrice
     */
    public function setHighlight7($highlight7)
    {
        $this->highlight7 = $highlight7;

        return $this;
    }

    /**
     * Get highlight7
     *
     * @return string
     */
    public function getHighlight7()
    {
        return $this->highlight7;
    }

    /**
     * Set highlight14
     *
     * @param string $highlight14
     *
     * @return CategoryPrice
     */
    public function setHighlight14($highlight14)
    {
        $this->highlight14 = $highlight14;

        return $this;
    }

    /**
     * Get highlight14
     *
     * @return string
     */
    public function getHighlight14()
    {
        return $this->highlight14;
    }

    /**
     * Set highlight21
     *
     * @param string $highlight21
     *
     * @return CategoryPrice
     */
    public function setHighlight21($highlight21)
    {
        $this->highlight21 = $highlight21;

        return $this;
    }

    /**
     * Get highlight21
     *
     * @return string
     */
    public function getHighlight21()
    {
        return $this->highlight21;
    }

    /**
     * Set spotlight7
     *
     * @param string $spotlight7
     *
     * @return CategoryPrice
     */
    public function setSpotlight7($spotlight7)
    {
        $this->spotlight7 = $spotlight7;

        return $this;
    }

    /**
     * Get spotlight7
     *
     * @return string
     */
    public function getSpotlight7()
    {
        return $this->spotlight7;
    }

    /**
     * Set spotlight14
     *
     * @param string $spotlight14
     *
     * @return CategoryPrice
     */
    public function setSpotlight14($spotlight14)
    {
        $this->spotlight14 = $spotlight14;

        return $this;
    }

    /**
     * Get spotlight14
     *
     * @return string
     */
    public function getSpotlight14()
    {
        return $this->spotlight14;
    }

    /**
     * Set spotlight21
     *
     * @param string $spotlight21
     *
     * @return CategoryPrice
     */
    public function setSpotlight21($spotlight21)
    {
        $this->spotlight21 = $spotlight21;

        return $this;
    }

    /**
     * Get spotlight21
     *
     * @return string
     */
    public function getSpotlight21()
    {
        return $this->spotlight21;
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
     * @return CategoryPrice
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
     * @return CategoryPrice
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
     * @return CategoryPrice
     */
    public function setDeleted(\DateTime $deleted = null)
    {
        $this->deleted = $deleted;
        return $this;
    }
}

