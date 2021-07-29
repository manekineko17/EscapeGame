<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddSessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateSession', DateTimeType::class, [
                'label' => 'Date',
                'date_widget' => 'single_text',


            ])
            //choice label va chercher le title dans game et afficher un menu déroulant
            ->add('game', null, ['label' => 'Game', 'choice_label' => 'title'])
            ->add('users', null, ['label' => 'Utilisateur', 'choice_label' => 'fullname']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
