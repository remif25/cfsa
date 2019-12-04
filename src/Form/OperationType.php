<?php

namespace App\Form;

use App\Entity\Operation;
use App\Entity\PosteTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('id', HiddenType::class)
            ->add('numero', IntegerType::class, [
                'attr' => ['min' => '10', 'max' => '500', 'step' => '10', 'class' => 'form-control'],
                'required' => false
            ])
            ->add('pdt', null, [
                'attr' => ['class' => 'form-control select2-form', 'placeholder' => 'Entrez le PDT'],
                'required' => false

            ])
            ->add('activite',null, [
                'attr' => ['class' => 'form-control select2-form', 'placeholder' => 'Entrez le activité'],
                'required' => false

            ])
            ->add('linkregleoperation', LinkRegleOperationType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
