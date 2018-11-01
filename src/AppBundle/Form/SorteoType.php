<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SorteoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('primeraImage' , new \AppBundle\Form\imageType())
            ->add('segundaImage' , new \AppBundle\Form\imageType())
            ->add('terceraImage' , new \AppBundle\Form\imageType())
            ->add('titulo', null, array('label'=>'Título'))
            ->add('descripcion', null, array('label'=>'Descripción'))
            ->add('precio', null, array('label'=>'Precio del artículo'))
            ->add('ganancia', ChoiceType::class, array(
                'label' => 'Ganancia',
                'choices'  => array(
                    '1.05'    => "5%",
                    '1.10'    => "10%",
                    '1.15'    => "15%",
                    '1.20'    => "20%",
                    '1.25'    => "25%",
                    '1.30'    => "30%",
                    '1.35'    => "35%",
                    '1.40'    => "40%",
                    '1.45'    => "45%",
                    '1.50'    => "50%",
                    '1.55'    => "55%",
                    '1.60'    => "60%",
                    '1.65'    => "65%",
                    '1.70'    => "70%",
                    '1.75'    => "75%",
                    '1.80'    => "80%",
                    '1.85'    => "85%",
                    '1.90'    => "90%",
                    '1.95'    => "95%",
                    '2.00'    => "100%",
                ),
                'choices_as_values' => false,
                'preferred_choices' => array('1.20','1.25')
            ))
            ->add('costoPorNumero', ChoiceType::class, array(
                'label' => 'Costo por número',
                'choices'  => array(
                    '1'     => "$1.00",
                    '3'     => "$3.00",
                    '5'     => "$5.00",
                    '10'    => "$10.00"
            )))
            ->add('cantidadNumeroPermitido', ChoiceType::class, array(
                'label' => 'Cantidad número(s) permitido(s)',
                'choices'  => array(
                    '1'     => "Uno",
                    '3'     => "Tres",
                    '5'     => "Cinco",
                    '10'    => "Diez",
                    '0'     => "Todos"
            )))
            ->add('tipoSorteo', ChoiceType::class, array(
                'label' => 'Tipo de sorteo',
                'choices'  => array(
                    '1'     => "Público",
                    '2'     => "Privado",
                    '3'     => "Por invitación"
            )))
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
            'data_class' => 'AppBundle\Entity\Sorteo'
        ));
    }

    public function getName()
    {
        return 'sorteo_type';
    }
}
