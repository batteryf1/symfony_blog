<?php
// src/Blogger/BlogBundle/Controller/CommentController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Comment;
use Blogger\BlogBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Comment controller.
 */
class CommentController extends Controller
{
    /**
     * @param $blog_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($blog_id);
        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        return $blog;
    }
    /**
     * Show new Comments
     */
    public function newAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);
        $comment = new Comment();
        $comment->setBlog($blog);
        $form   = $this->createForm(new CommentType());
        return $this->render('BloggerBlogBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }
    /**
     * Create new Comments
     */
    public function createAction(Request $request, $blog_id)
    {
        if ($request->isXmlHttpRequest()) {
			$em = $this->getDoctrine()->getEntityManager();
            $blog = $this->getBlog($blog_id);        
			$comment  = new Comment();
            $comment->setBlog($blog);
            $form    = $this->createForm(new CommentType(), $comment);
            $form->handleRequest($request);

            if ($form->isValid()) {
                /*Insert data and commit:*/
				$em->persist($comment);
                $em->flush();
				/*Sending response:*/
				$response = new Response();
				$myData = ("Added successfull!");
				$data = json_encode($myData);
				$response->headers->set('Content-Type', 'application/json');
				$response->setContent($data);
				return $response;
			}
        }
        return new JsonResponse('no results found', Response::HTTP_NOT_FOUND);
    }
    /**
     * Create new Comments
     */
    public function create2Action(Request $request, $blog_id)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getEntityManager();
            $blog = $this->getBlog($blog_id);
            $comment  = new Comment();
            $comment->setBlog($blog);
            $form    = $this->createForm(new CommentType(), $comment);
            $form->handleRequest($request);

            if ($form->isValid()) {
                /*Insert data and commit:*/
                $em->persist($comment);
                $em->flush();
                /*Sending response:*/
                $response = new Response();
                $myData = ("Adde successfull!");
                $data = json_encode($myData);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);
                return $response;
            }
        }
        return new JsonResponse('no results found', Response::HTTP_NOT_FOUND);
    }

}



