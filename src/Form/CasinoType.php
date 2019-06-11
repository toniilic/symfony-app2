<?php

namespace App\Form;

use App\Entity\Casino;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CasinoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
            //->add('slug')
            ->add('content', TextType::class, [
                'required' => false
            ])
            ->add('publishedAt')
            ->add('allowedCountries', CountryType::class, [
                'multiple' => true
            ])
            ->add('image', FileType::class, array('data_class' => null, 'required' => false))
            ->add('author')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Casino::class,
        ]);
    }
}
