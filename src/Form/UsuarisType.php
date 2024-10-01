<?php

namespace App\Form;

use App\Entity\Usuaris;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('usuari')
            ->add('contrasenya')
            ->add('nom')
            ->add('cognoms')
            ->add('dataCreacio')
            ->add('dataModificacio')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuaris::class,
        ]);
    }
}
