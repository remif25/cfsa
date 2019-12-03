<?php

namespace App\Form;

use App\Entity\GammeEnveloppe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GammeEnveloppeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            /*->add('nom', TextType::class)
            ->add('reference', TextType::class)*/
            ->add('operations', CollectionType::class, [
                'entry_type' => OperationType::class,
                'entry_options' => ['label' => false],
            ])
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder', 'attr' => ['class'=> 'btn btn-primary']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GammeEnveloppe::class,
        ]);
    }
}
