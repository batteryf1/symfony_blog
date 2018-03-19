<?php
/**
 * Created by PhpStorm.
 * User: Iurii
 * Date: 23.07.2017
 * Time: 19:40
 */

namespace Blogger\BlogBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategCommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author1')
            ->add('content')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\CategComment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogger_blogbundle_categ_comment_create';
    }
}