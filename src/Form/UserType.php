<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('birthday')
            ->add('email')
            ->add('password', PasswordType::class)
            ->add('roles', ChoiceType::class, array(
                'expanded' => false,
                'multiple' => false,
                'choices' => $this->getChoices(),
                'attr' => ['class' => 'class="form-control']
                ))
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder', 'attr' => ['class'=> 'btn btn-primary']])
            ->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray) {
                    if ($rolesAsArray === null)
                        return "";
                    // transform the array to a string
                    return implode('-', $rolesAsArray);
                },
                function ($rolesAsString) {
                    if ($rolesAsString === '')
                        return null;
                    // transform the string back to an array
                    return explode('-', $rolesAsString);
                }));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'choices' => $this->getChoices(),
            'choices_as_values' => true,
            'choice_value' => function (User $object) {
                // Use the string representation as values
                return (string) $object;
            },
        ]);
    }

    public function getChoices() {
        return [
            'Lecteur' => 'ROLE_LECTEUR',
            'Modificateur' => 'ROLE_MODIFICATEUR',
            'Administrateur' => 'ROLE_ADMIN'
        ];
    }
}
