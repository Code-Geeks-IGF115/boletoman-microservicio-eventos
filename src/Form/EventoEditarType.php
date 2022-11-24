<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{DateType,TimeType};

class EventoEditarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('tipoDeEvento')
            ->add('categoria')
            ->add('fechaInicio')
            ->add('horaInicio')
            ->add('fechaFin')
            ->add('horaFin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
}
