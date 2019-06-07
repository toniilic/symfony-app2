<?php


namespace App\Admin;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\RegistrationSubmissionForm;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class RegistrationSubmissionFormAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class)
            ->add('surname', TextareaType::class)
            ->add('username', TextareaType::class)
            ->add('skype', TextareaType::class)
            ->add('email', TextareaType::class)
            ->add('casinoTitle', TextareaType::class)
            ->add('casinoUrl', TextareaType::class)
            ->add('approved', BooleanType::class)
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('casinoTitle')
            ->addIdentifier('casinoUrl')
            ->add('approved')
        ;
    }

    public function toString($object)
    {
        return $object instanceof RegistrationSubmissionForm
            ? $object->getCasinoTitle()
            : 'Registration Submission Form'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('casinoTitle');
    }
}