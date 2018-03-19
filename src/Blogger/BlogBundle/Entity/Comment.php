<?php
/**
 * Created by PhpStorm.
 * User: YZub
 * Date: 09.06.2017
 * Time: 16:12
 */
// src/Blogger/BlogBundle/Entity/Comment.php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\Repository\CommentRepository")
 * @ORM\Table(name="comments")
 * @ORM\HasLifecycleCallbacks
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $author;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="comments")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
     */
    protected $blog;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $create_at;

    /*Set current datetime for new comment*/
    public function __construct()
    {
        $this->setCreateAt(new \DateTime());

    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set create_at
     *
     * @param \DateTime $createAt
     * @return Comment
     */
    public function setCreateAt($createAt)
    {
        $this->create_at = $createAt;

        return $this;
    }

    /**
     * Get create_at
     *
     * @return \DateTime 
     */
    public function getCreateAt()
    {
        return $this->create_at;
    }

    /**
     * Set blog
     *
     * @param \Blogger\BlogBundle\Entity\Blog $blog
     * @return Comment
     */
    public function setBlog(\Blogger\BlogBundle\Entity\Blog $blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return \Blogger\BlogBundle\Entity\Blog 
     */
    public function getBlog()
    {
        return $this->blog;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('author', new NotBlank(array(
            'message' => 'You must enter your name'
        )));
        $metadata->addPropertyConstraint('content', new NotBlank(array(
            'message' => 'You must enter a comment'
        )));
    }

}
