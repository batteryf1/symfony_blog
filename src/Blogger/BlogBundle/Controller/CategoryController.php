<?php
/**
 * Created by PhpStorm.
 * User: YZub
 * Date: 08.06.2017
 * Time: 9:13
 */
// src/Blogger/BlogBundle/Controller/BlogController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Category;
use Blogger\BlogBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 */
class CategoryController extends Controller
{
    /**
     * Show a category entry
    */
    public function categoryshowAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $category = $em->getRepository('BloggerBlogBundle:Category')->find($id);
        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
            ->getLatestBlogsByCategory($id);

        $comments = $em->getRepository('BloggerBlogBundle:CategComment')
            ->getCommentsForCategory($category->getId());

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category.');
        }

            return $this->render('BloggerBlogBundle:Category:show.html.twig', array(
                'category' => $category,
                'blogs' => $blogs,
                'comments' => $comments
            ));
    }
    /**
     * Show a category edit form
     */
    public function categoryeditAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $category = $em->getRepository('BloggerBlogBundle:Category')->find($id);


        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category.');
        }
        $form   = $this->createForm(new CategoryType(), $category);
        return $this->render('BloggerBlogBundle:Category:edit.html.twig', array(
            'category' => $category,
            'form'   => $form->createView()

        ));

    }
    /**
     * Show new Category
     */
    public function newAction()
    {
        $category = new Category();
        $form   = $this->createForm(new CategoryType(), $category);
        return $this->render('BloggerBlogBundle:Category:form.html.twig', array(
            'category' => $category,
            'form'   => $form->createView()
        ));
    }
    /**
     * Create new Category
     */
    public function createAction(Request $request)
    {
        $category  = new Category();
        $form    = $this->createForm(new CategoryType(), $category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($category);
            $em->flush();
            $category->getBlogs();
            return $this->redirect($this->generateUrl('BloggerBlogBundle_homepage')
            );
        }
        return $this->render('BloggerBlogBundle:Category:create.html.twig', array(
            'category' => $category,
            'form'    => $form->createView()
        ));
    }
    /**
     * Update exist Category by id
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $category = $em->getRepository('BloggerBlogBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $category);
        $request = $this->getRequest();
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('BloggerBlogBundle_homepage'));
        }
        return $this->render('BloggerBlogBundle:Category:edit.html.twig', array(
            'category' => $category,
            'form'    => $editForm->createView(),
        ));
    }
    /**
     * Delete Category by id
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $category = $em->getRepository('BloggerBlogBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
            $em->remove($category);
            $em->flush();
            return $this->redirect($this->generateUrl('BloggerBlogBundle_homepage'));
    }

}