<?php
/**
 * User: YZub
 * Date: 13.06.2017
 * Time: 15:36
 */

namespace Blogger\BlogBundle\Entity\Repository;


class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLatestCategoryes($limit = null)
    {
        $qb = $this->createQueryBuilder('cat')
            ->select('cat')
            ->addOrderBy('cat.name', 'ASC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()
            ->getResult();
    }
}