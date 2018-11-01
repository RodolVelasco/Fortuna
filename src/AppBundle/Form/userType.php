<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class userType extends AbstractType
{
    private $isAdmin;
    private $isOwner;

    public function __construct($isAdmin = true, $isOwner = false)
    {
        $this->isAdmin = $isAdmin;
        $this->isOwner = $isOwner;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('telefono')
            ->add('dui')
            ->add('image' , new \AppBundle\Form\imageType())
            ;
        if($this->isAdmin)
            $builder
            ->add('username')
            ->add('email')
            ->add('plainpassword', 'text', array('required' => false))
            ->add('enabled', 'checkbox', array('required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\user'
        ));
    }

    public function getName()
    {
        return 'user_type';
    }
}
