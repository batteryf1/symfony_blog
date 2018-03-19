<?php
/**
 * Created by PhpStorm.
 * User: YZub
 * Date: 07.06.2017
 * Time: 17:01
 */

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */

class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="category")
     */
    protected $blogs;

    /**
     * @ORM\OneToMany(targetEntity="CategComment", mappedBy="category")
     */
    protected $comments;


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
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blogs = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /**
     * Add blogs
     *
     * @param \Blogger\BlogBundle\Entity\Blog $blogs
     * @return Category
     */
    public function addBlog(\Blogger\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs[] = $blogs;

        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \Blogger\BlogBundle\Entity\Blog $blogs
     */
    public function removeBlog(\Blogger\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs()
    {
        return $this->blogs;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank(array(
            'message' => 'You must enter category name'
        )));
        $metadata->addPropertyConstraint('description', new NotBlank(array(
            'message' => 'You must enter a description'
        )));
    }

    /**
     * Add comments
     *
     * @param \Blogger\BlogBundle\Entity\CategComment $comments
     * @return Category
     */
    public function addComment(\Blogger\BlogBundle\Entity\CategComment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Blogger\BlogBundle\Entity\CategComment $comments
     */
    public function removeComment(\Blogger\BlogBundle\Entity\CategComment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
