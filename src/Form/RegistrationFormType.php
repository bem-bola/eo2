<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label'       => 'Nom',
                'required'    => true,
                'constraints' =>[
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit contenir au moins deux caractères alphabétiques',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern'   => '/^[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]+$/',
                        'match'     => true,
                        'message'   => 'Veuillez entrer un nom correct !'
                    )),
                ]

            ])
            ->add('prenom', TextType::class,[
                'label'       => 'Prénom',
                'required'    => true,
                'constraints' =>[

                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit contenir au moins deux caractères alphabétiques',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern'   => '/^[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]+$/',
                        'match'     => true,
                        'message'   => 'Veuillez entrer un nom correct !'
                    )),
                ]
            ])
            ->add('email', EmailType::class, [
                'label'     => 'Email',
                'constraints' =>[
                    new Regex(array(
                        'pattern'   => '/^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i',
                        'match'     => true,
                        'message'   => 'Veuillez entrer une adresse email correcte !'
                    )),
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type'            => PasswordType::class,
                'first_options'   => ['label' => 'Mot de passe'],
                'second_options'  => ['label' => 'Confirmation de votre mot de passe'],
                'invalid_message' => 'Les deux champs doivent être identiques',
                'options' => ['attr' => ['class' => 'password']],
                'mapped'          => false,
                'constraints'     => [
                    new NotBlank([
                        'message' => 'Veuillez-rensigner un mot de passe svp !',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage'  => 'Votre mot de passe doit conténir au moins 8 caractères !',
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern'   => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!#%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'match'     => true,
                        'message'   => 'Votre mot de passe doit contenir au moins un chiffre, un caractère spécial (@$!#%*?&), une lettre minuscule et une lettre majuscule !'
                    )),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
