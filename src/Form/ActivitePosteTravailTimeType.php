<?php

namespace App\Form;

use App\Entity\Time;
use App\Entity\Unite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitePosteTravailTimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tempsReglage', null, ['label' => 'Temps de réglage'])
            ->add('tempsMO', null, ['label' => 'Temps MO'])
            ->add('tempsMA', null, ['label' => 'Temps MA'])
            ->add('acheminement', null, ['label' => 'Acheminement'])
            ->add('quantite', null, ['label' => 'Quantité'])
            ->add('unite', null, ['label' => 'Unité'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Time::class,
        ]);
    }
}
