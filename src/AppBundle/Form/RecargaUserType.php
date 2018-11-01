<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RecargaUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', null, array(
                'label' => 'Código'
            ))
            ->add('recargador', EntityType::class, array(
                'label' => 'Asignar recarga a',
                'class' => 'AppBundle:User',
                //'choice_label' => 'username',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recarga'
        ));
    }

    public function getName()
    {
        return 'recarga_user_type';
    }
}
