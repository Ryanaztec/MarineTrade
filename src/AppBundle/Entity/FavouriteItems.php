<?php

namespace App\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 *
 * @ORM\Table(name="favourite_items")
 * @ORM\Entity()
 *
 * @Serializer\ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class FavouriteItems {
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\AppBundle\Entity\Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $itemId;

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId) {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int {
        return $this->userId;
    }

    /**
     * @param int $itemId
     * @return $this
     */
    public function setItemId(int $itemId) {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * @return int
     */
    public function getItemId(): int {
        return $this->itemId;
    }
}
