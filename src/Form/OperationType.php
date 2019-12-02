<?php

namespace App\Form;

use App\Entity\Operation;
use App\Entity\PosteTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('numero', IntegerType::class, [
                'attr' => ['min' => '10', 'max' => '500', 'step' => '10', 'class' => 'form-control']
            ])
            ->add('pdt', null, [
                'attr' => ['class' => 'form-control select2-form']

            ])
            ->add('activite',null, [
                'attr' => ['class' => 'form-control select2-form']

            ])
            ->add('linkregleoperation')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
