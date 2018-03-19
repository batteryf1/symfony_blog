<?php
/**
 * User: YZub
 * Date: 13.06.2017
 * Time: 15:36
 */
namespace Blogger\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function getCommentsForBlog($blogId)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.blog = :blog_id')
            ->addOrderBy('c.create_at')
            ->setParameter('blog_id', $blogId);

        return $qb->getQuery()
            ->getResult();
    }

}