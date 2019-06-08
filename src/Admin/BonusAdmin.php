<?php

namespace App\Admin;

use App\Entity\BlogPost;
use App\Entity\Bonus;
use App\Entity\Casino;
use App\Entity\Category;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class BonusAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class)
            ->add('bonusCode', TextType::class, [
                'required' => false
            ])
            ->add('summary', TextType::class, [
                'required' => false
            ])
            ->add('content', TextareaType::class,
                array('attr' => array('class' => 'ckeditor'))
            )
            ->add('doesNotExpire', ChoiceType::class, array(
                'choices'  => array(
                    'Yes' => true,
                    'No' => false,
                ),
            ))
            ->add('expiryDate', DateTimeType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
            ])
            ->add('casino', EntityType::class, [
                'class' => Casino::class,
                'choice_label' => 'title',
            ])
            ->add('author', EntityType::class, [
                // looks for choices from this entity
                'class' => User::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'username',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ]);
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
        ;
    }

    public function toString($object)
    {
        return $object instanceof Bonus
            ? $object->getTitle()
            : 'Bonus'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }
}