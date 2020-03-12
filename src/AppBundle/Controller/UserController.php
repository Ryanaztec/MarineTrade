<?php

namespace App\AppBundle\Controller;

use App\AppBundle\Entity\Address;
use App\AppBundle\Entity\Bid;
use App\AppBundle\Entity\BidInvite;
use App\AppBundle\Entity\Device;
use App\AppBundle\Entity\Message;
use App\AppBundle\Entity\Promotion;
use App\AppBundle\Entity\Sync;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use App\AppBundle\Entity\Category;
use App\AppBundle\Entity\Item;
use App\AppBundle\Entity\Search;
use Symfony\Component\HttpFoundation\Request;


/**
 * This is an example of how to use a custom controller for a backend entity.
 */
class UserController extends BaseAdminController
{

    public function deleteUserAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('AppBundle:Item')->findBy(['user' => $id]);
        $itemIds = [];

        /** @var Item $item */
        foreach ($items as $item)
        {
            $itemIds[] = $item->getId();
            $bids = $em->getRepository('AppBundle:Bid')->find($item->getId());
            /** @var Bid $bid */
            foreach ($bids as $bid)
            {
                $bid->setArchived(true);
                $bid->setUpdated(new \DateTime());

                $bid->getMessages()->map(function(Message $message) use ($em) {
                    $message->setUpdated(new \Datetime());
                    $message->setDeleted(new \Datetime());
                    $em->persist($message);
                });

                $em->persist($bid);
            }

            $item->getMessages()->map(function(Message $message) use ($em) {
                $message->setUpdated(new \Datetime());
                $message->setDeleted(new \Datetime());
                $em->persist($message);
            });

            // delete promotions
            $promotions = $em->getRepository('AppBundle:Promotion')->findBy(['item' => $item]);
            /** @var Promotion $promotion */
            foreach ($promotions as $promotion){
                $promotion->setUpdated(new \Datetime());
                $promotion->setDeleted(new \Datetime());
                $em->persist($promotion);
            }

            $item->setArchived(true);
            $item->setUpdated(new \Datetime());

            $em->persist($item);
        }

        // DELETE favorite items
        if (count($itemIds)) {
            $sql = sprintf('DELETE FROM favorite_items WHERE item_id IN (%s) OR user_id=%s;', join(', ', $itemIds), $id);
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();

            // DELETE item categories items
            $sql = sprintf('DELETE FROM item_category WHERE item_id IN (%s);', join(', ', $itemIds));
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
        }

        // DELETE followers items
        $sql = sprintf('DELETE FROM followers WHERE user_id=%s OR follower_user_id=%s;', $id, $id);
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();

        // DELETE ratings
        $sql = sprintf('DELETE FROM rating WHERE user_id=%s;', $id);
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();

        // DELETE user settings
        $sql = sprintf('DELETE FROM user_setting WHERE user_id=%s;', $id);
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();

        // delete devices
        $devices = $em->getRepository('AppBundle:Device')->findBy(["user" => $id]);
        /** @var Device $device */
        foreach ($devices as $device) {
            $device->setUpdated(new \Datetime());
            $device->setDeleted(new \Datetime());

            $em->persist($device);
        }

        // delete syncs
        $syncs = $em->getRepository('AppBundle:Sync')->findBy(["user" => $id]);
        /** @var Sync $sync */
        foreach ($syncs as $sync) {
            $sync->setUpdated(new \Datetime());
            $sync->setDeleted(new \Datetime());

            $em->persist($sync);
        }

        $bidInvites = $em->getRepository('AppBundle:BidInvite')->findBy(["bidOwner" => $id]);
        /** @var BidInvite $bidInvite */
        foreach ($bidInvites as $bidInvite)
        {
            $bidInvite->setUpdated(new \Datetime());
            $bidInvite->setDeleted(new \Datetime());

            $em->persist($bidInvite);
        }


        $addresses = $em->getRepository('AppBundle:Address')->find($id);

        /** @var Address $address */
        foreach ($addresses as $address) {
            //$category = $em->getRepository('AppBundle:Category')->find($id);
            $address->setUpdated(new \Datetime());
            $address->setDeleted(new \Datetime());

            $em->persist($item);
        }

        $savedSearches = $em->getRepository('AppBundle:Search')->findBy(["user" => $id]);
        /** @var Search $search */
        foreach ($savedSearches as $search)
        {
            $search->setUpdated(new \Datetime());
            $search->setDeleted(new \Datetime());

            $em->persist($search);
        }


        $user = $em->getRepository('AppBundle:User')->find($id);
        $user->setDeleted(new \DateTime());
        $user->setUpdated(new \DateTime());
        $em->persist($user);

        try{
            $em->flush();
        } catch (\Exception $e){
            var_dump($e->getMessage());
            exit();
        }

        //TOATE SUNT RESOLVED  TEST!!!
            // item_messages
            // bid_messages
            // bid_invites
            // favourite_items
            // followers
            // devices
            // item_category
            // promotion
            // rating
            // sync
            // user_settings

        // redirect to the 'list' view of the given entity
        return $this->redirectToRoute('admin', array(
            'view' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));
    }

    public function deactivateAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('AppBundle:Item')->findBy(['user' => $id]);
        $itemIds = [];

        /** @var Item $item */
        foreach ($items as $item)
        {
            $itemIds[] = $item->getId();
            $bids = $em->getRepository('AppBundle:Bid')->find($item->getId());
            /** @var Bid $bid */
            if(count($bids) >= 1 ) {
                foreach ($bids as $bid) {
                    $bid->setArchived(true);
                    $bid->setUpdated(new \DateTime());

                    $bid->getMessages()->map(function (Message $message) use ($em) {
                        $message->setUpdated(new \Datetime());
                        $message->setDeleted(new \Datetime());
                        $em->persist($message);
                    });

                    $em->persist($bid);
                }
            }

            $item->getMessages()->map(function(Message $message) use ($em) {
                $message->setUpdated(new \Datetime());
                $message->setArchived(true);
                $em->persist($message);
            });

            // delete promotions
            $promotions = $em->getRepository('AppBundle:Promotion')->findBy(['item' => $item]);
            /** @var Promotion $promotion */
            foreach ($promotions as $promotion){
                $promotion->setUpdated(new \Datetime());
                $promotion->setDeleted(new \Datetime());
                $em->persist($promotion);
            }

            $item->setArchived(true);
            $item->setUpdated(new \Datetime());

            $em->persist($item);
        }

        $user = $em->getRepository('AppBundle:User')->find($id);
        $user->setDeactivated(true);
        $user->setTrendingScore(0);
        //$user->setDeleted(new \DateTime());
        $user->setUpdated(new \DateTime());
        $em->persist($user);

        try{
            $em->flush();
        } catch (\Exception $e){
            var_dump($e->getMessage());
            exit();
        }

        // redirect to the 'list' view of the given entity
        return $this->redirectToRoute('easyadmin', array(
            'view' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));
    }

//    public function editAction() {
//        $all = $this->request->request->all();
//        var_dump($all['user']);die;
//    }

}

