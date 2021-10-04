<?php

namespace App\Form;

use App\Entity\Chanteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;


class ChanteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomScene')
            ->add('prenom')
            ->add('nom')
            ->add('dateNaissance',BirthdayType::class, array(
            'format' => 'dd-MM-yyyy')
           )
            ->add('sexe')
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chanteur::class,
        ]);
    }
}