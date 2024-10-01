<?php

namespace App\Form;

use App\Entity\Pressupostos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PressupostosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idClient')
            ->add('pressupost')
            ->add('totalPressupost')
            ->add('idEstat')
            ->add('dataCreacio')
            ->add('dataModificacio')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pressupostos::class,
        ]);
    }
}
