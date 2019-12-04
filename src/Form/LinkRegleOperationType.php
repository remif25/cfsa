<?php

namespace App\Form;

use App\Entity\LinkRegleOperation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkRegleOperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('regle',null, [
                'attr' => ['class' => 'form-control select2-form'],
                'required' => false

            ])
            ->add('branche', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez le numéro de branche'],
            ])

            ->get('branche')
                ->addModelTransformer(new CallbackTransformer(
                    function ($branchesAsArray) {
                        if ($branchesAsArray === null)
                            return "";
                        // transform the array to a string
                        return implode('-', $branchesAsArray);
                    },
                    function ($branchesAsString) {
                        if ($branchesAsString === '')
                            return null;
                        // transform the string back to an array
                        return explode('-', $branchesAsString);
                    }
                ))
            ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LinkRegleOperation::class,
        ]);
    }
}
