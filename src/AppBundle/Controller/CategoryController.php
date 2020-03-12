<?php

namespace App\AppBundle\Controller;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use App\AppBundle\Entity\Category;

/**
 * This is an example of how to use a custom controller for a backend entity.
 */
class CategoryController extends BaseAdminController
{

    public $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function deleteCategoryAction()
    {
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->find(1);
        /**
         * @var UserPasswordEncoder $encoder;
         */
        var_dump($this->encoder->encodePassword($user, '2rpcpAgfHAuTJU7z'));die;
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Category')->createQueryBuilder('c');
        $qb
            ->select('c')
            ->where($qb->expr()->orX(
                $qb->expr()->eq('c.id', ':id'),
                $qb->expr()->eq('c.parent', ':id')
            ))
            ->setParameter('id', $id)
        ;

        $allCategories = $qb->getQuery()->getResult();
        foreach ($allCategories as $category)
        {
                //$category = $em->getRepository('AppBundle:Category')->find($id);
            $category->setUpdated(new \Datetime());
            $category->setDeleted(new \Datetime());

            $categoriesPrice = $em->getRepository('AppBundle:CategoryPrice')->findBy(['category' => $category]);
            if($categoriesPrice)
            {
                foreach($categoriesPrice as $categoryPrice){
                    $categoryPrice->setUpdated(new \Datetime());
                    $categoryPrice->setDeleted(new \Datetime());
                    $em->persist($categoryPrice);
                }
            }

            $em->persist($category);
        }

        try{
            $em->flush();
        }catch (\Exception $e){
            var_dump($e->getMessage());
            exit();
        }

        // redirect to the 'list' view of the given entity
        return $this->redirectToRoute('admin', array(
            'view' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));
    }
}

