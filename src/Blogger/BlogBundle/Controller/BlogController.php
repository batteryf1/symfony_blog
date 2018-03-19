<?php
/**
 * Created by PhpStorm.
 * User: YZub
 * Date: 08.06.2017
 * Time: 9:53
 */

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Blog;
use Blogger\BlogBundle\Form\BlogType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 */
class BlogController extends Controller
{
    /**
     * @param $category_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getCategory($category_id)
    {
        $em = $this->getDoctrine()
            ->getManager();

        $category = $em->getRepository('BloggerBlogBundle:Category')->find($category_id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category.');
        }
        return $category;
    }

    /**
     * Show a blog entry
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        $comments = $em->getRepository('BloggerBlogBundle:Comment')
            ->getCommentsForBlog($blog->getId());

        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }

    /**
     * Show edit Blog form
     */
    public function blogeditAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);


        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog.');
        }
        $form   = $this->createForm(new BlogType(1), $blog);
        return $this->render('BloggerBlogBundle:Blog:edit.html.twig', array(
            'blog' => $blog,
            'form'   => $form->createView()
        ));
    }
    /**
     * Show new Blog
     */
    public function newAction($category_id)
    {
        $category = $this->getCategory($category_id);
        $blog = new Blog();
        $blog->setCategory($category);
        $form   = $this->createForm(new BlogType(), $blog);
        return $this->render('BloggerBlogBundle:Blog:form.html.twig', array(
            'blog' => $blog,
            'form'   => $form->createView()
        ));
    }
    /**
     * Create new Blog
     */
    public function createAction(Request $request, $category_id)
    {
        $category = $this->getcategory($category_id);
        $blog  = new Blog();
        $blog->setCategory($category);
        $form    = $this->createForm(new BlogType(), $blog);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($blog);
            $em->flush();

            return $this->redirect($this->generateUrl('BloggerBlogBundle_allblogs', array(
                'id' => $blog->getCategory()->getId()))
            );
        }
        return $this->render('BloggerBlogBundle:Blog:create.html.twig', array(
            'blog' => $blog,
            'form'    => $form->createView()
        ));
		
    }
    /**
     * Update exist Blog by id
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $editForm = $this->createForm(new BlogType(), $blog);
        $request = $this->getRequest();
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($blog);
            $em->flush();

            return $this->redirect($this->generateUrl('BloggerBlogBundle_allblogs', array(
                'id' => $blog->getCategory()->getId()))
            );
        }
        return $this->render('BloggerBlogBundle:Blog:edit.html.twig', array(
            'blog' => $blog,
            'form'    => $editForm->createView()
        ));
    }

    /**
     * Delete Blog by id
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }
        $em->remove($blog);
        $em->flush();
        return $this->redirect($this->generateUrl('BloggerBlogBundle_allblogs', array(
            'id' => $blog->getCategory()->getId()))
        );
    }
}