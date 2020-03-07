<?php

namespace App\AppBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use App\AppBundle\Entity\Category;

/**
 * This is an example of how to use a custom controller for a backend entity.
 */
class PromotionController extends BaseAdminController
{
    /**
     * This method overrides the default query builder used to search for this
     * entity. This allows to make a more complex search joining related entities.
     */
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        /* @var EntityManager */
        $em = $this->getDoctrine()->getManagerForClass($this->entity['class']);
        /* @var DoctrineQueryBuilder */
        $queryBuilder = $em->createQueryBuilder()
            ->select('entity')
            ->from($this->entity['class'], 'entity')
            ->join('entity.item', 'item')
        ;
        if (!empty($dqlFilter)) {
            $queryBuilder->andWhere($dqlFilter);
        }
        if (null !== $sortField) {
            $queryBuilder->orderBy('entity.'.$sortField, $sortDirection ?: 'DESC');
        }
        return $queryBuilder;
    }

}

