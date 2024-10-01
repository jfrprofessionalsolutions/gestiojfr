<?php

namespace App\Form;

use App\Entity\Pagaments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagamentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idComanda')
            ->add('idClient')
            ->add('idFormaPagament')
            ->add('idTipusPagament')
            ->add('idFactura')
            ->add('pagament')
            ->add('pagat')
            ->add('dataCreacio')
            ->add('dataModificacio')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pagaments::class,
        ]);
    }
}
