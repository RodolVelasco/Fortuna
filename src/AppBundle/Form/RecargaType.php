<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class RecargaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', HiddenType::class, array(
                'mapped'        =>  false,
                'required'      =>  false,
                'property_path' =>  null,
            ))
            ->add('recarga', ChoiceType::class, array(
                'choices'  => array(
                    '1'    => "$1",
                    '3'    => "$3",
                    '5'    => "$5",
                    '10'   => "$10"
                ),
                'choices_as_values' => false,
                'preferred_choices' => array('5','10')
            ))
            ->add('precio')
            ->add('tipoPagoPorMonedero', ChoiceType::class, array(
                'label' => 'Monedero',
                'choices'  => array(
                    '1'     => "Principal",
                    '2'     => "Bono",
                    '3'     => "Promocional"
            )))
            ->add('estado', ChoiceType::class, array(
                'label' => 'Estado',
                'choices'  => array(
                    '1'     => "Activo",
                    '0'     => "Inactivo",
                    '2'     => "Cancelado"
            )))
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
        return 'recarga_type';
    }
}
