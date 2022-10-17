<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{DateType,TimeType};

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('tipoDeEvento')
            ->add('categoria')
            ->add('fechaInicio', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'string'
            ])
            ->add('horaInicio', TimeType::class, [
                'widget' =>  'single_text',
                'input'  => 'string'
            ])
            ->add('fechaFin', DateType::class, [
                'widget' =>  'single_text',
                'input'  => 'string'
            ])
            ->add('horaFin', TimeType::class, [
                'widget' =>  'single_text',
                'input'  => 'string'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
            'csrf_protection' => false,
        ]);
    }
}
