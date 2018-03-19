<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;

class BlogType extends AbstractType
{
    private $isedit = 0;
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('file', 'file', array('label' => 'Attached File (2Mb Max)', 'data_class' => null))
        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\Blog'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogger_blogbundle_blog';
    }

}
