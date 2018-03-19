<?php
/**
 * Created by PhpStorm.
 * User: Iurii
 * Date: 23.07.2017
 * Time: 18:12
 */

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\CategComment;
use Blogger\BlogBundle\Form\CategCommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategCommentController extends Controller
{
    /**
     * @param $category_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getCategory($category_id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('BloggerBlogBundle:Category')->find($category_id);
        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category');
        }
        return $category;
    }
    /**
     * Show new Comments
     */
    public function newAction($category_id)
    {

        $category = $this->getCategory($category_id);
        $comment = new CategComment();
        $comment->setCategory($category);
        $form   = $this->createForm(new CategCommentType());
        return $this->render('BloggerBlogBundle:CategComment:form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));


    }

    public function createAction(Request $request, $category_id)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getEntityManager();
            $category = $this->getCategory($category_id);
            $categcomment  = new CategComment();
            $categcomment->setCategory($category);
            $form    = $this->createForm(new CategCommentType(), $categcomment);
           $form->handleRequest($request);

            $response = new Response();
            $myData = ("Categ Comment Added successfull!");
            $data = json_encode($myData);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($data);
            return $response;

            if ($form->isValid()) {
                /*Insert data and commit:*/
                $em->persist($categcomment);
                $em->flush();
                /*Sending response:*/
			     
            }
        }
        return new JsonResponse('no results found', Response::HTTP_NOT_FOUND);
    }
}