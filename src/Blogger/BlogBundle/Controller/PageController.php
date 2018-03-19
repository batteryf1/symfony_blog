<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * Show all Categoryes
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categoryes = $em->getRepository('BloggerBlogBundle:Category')
            ->getLatestCategoryes();

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'categoryes' => $categoryes
        ));
    }
    /**
     * Show About page
     */
  public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }

}
?>