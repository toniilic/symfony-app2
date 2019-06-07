<?php

namespace App\Form;

use App\Entity\RegistrationSubmissionForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationSubmissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('username')
            ->add('skype')
            ->add('email')
            ->add('casinoTitle')
            ->add('casinoUrl')
            /*->add('approved')*/
            ->add('save', SubmitType::class, array('label' => 'Submit Application'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegistrationSubmissionForm::class,
        ]);
    }
}
