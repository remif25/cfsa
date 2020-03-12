<?php

namespace App\Form;

use App\Entity\ActivitePosteTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitePosteTravailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activite')
            ->add('posteTravail')
            ->add(
                $builder->create('time', ActivitePosteTravailTimeType::class, [])
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActivitePosteTravail::class,
        ]);
    }
}
