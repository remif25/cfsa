<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', null, [
                'label' => 'Nom'
            ])
            ->add('firstname', null, [
                'label' => 'Prénom'
            ])
            ->add('birthday',  DateType::class, [
                'label' => "Date d'anniversaire",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'input_format' => 'dd/MM/yyyy',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
            ->add('roles', ChoiceType::class, array(
                'label' => 'Rôle',
                'expanded' => false,
                'multiple' => false,
                'choices' => $this->getChoices(),
                'attr' => ['class' => 'form-control'],
                'data' => $options['data']->getRoles()
            ))
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder', 'attr' => ['class'=> 'btn btn-primary']])
            ->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray) {
                    if ($rolesAsArray === null)
                        return "";

                    if (!is_array($rolesAsArray))
                        return $rolesAsArray;
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
