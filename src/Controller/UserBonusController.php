<?php

namespace App\Controller;

use App\Entity\Bonus;
use App\Entity\Casino;
use App\Entity\Category;
use App\Utils\Slugger;
use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserBonusController extends AbstractController
{
    /**
     * @Route("/user/bonus", name="user_bonus")
     */
    public function index()
    {
        return $this->render('user_bonus/index.html.twig', [
            'controller_name' => 'UserBonusController',
        ]);
    }

    /**
     * @Route("/user/bonus/new", name="user_bonus_new")
     */
    public function new(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $bonus = new Bonus();
        $bonus->setAuthor($user);

        $form = $this->createFormBuilder($bonus)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class,
                array('attr' => array('class' => 'ckeditor'))
            )
            ->add('bonusCode', TextType::class, array(
                'required' => false
            ))
            ->add('casino', EntityType::class, array(
                // looks for choices from this entity
                'class' => Casino::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'title',

                'query_builder' => function (EntityRepository $er) use ($user){
                    return $er->createQueryBuilder('c')
                        ->where('c.author = :user')
                        ->setParameter('user', $user)
                        ->orderBy('c.title', 'ASC');
                },

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ))
            ->add('category', EntityType::class, array(
                // looks for choices from this entity
                'class' => Category::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'title',

                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ))
            ->add('doesNotExpire', ChoiceType::class, [
                'choices'  => [
                    'Yes' => false,
                    'No' => true,
                ],
                'label' => 'Does it expire',
            ])
            ->add('expiryDate', DateTimeType::class, [
                'date_label' => 'Expires at',
                'years' => range(date('Y'), date('Y')+2)
            ])
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);


        // Get bonuses from user published today
        $bonusRepo = $this->getDoctrine()
            ->getRepository(Bonus::class);
        $bonuses = $bonusRepo->getBonusesByUserOnTodaysDate($user);


        if ($form->isSubmitted() && $form->isValid()) {

            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            /** @var Bonus $bonus */
            $bonus = $form->getData();

            $casinoBonuses = $bonusRepo->getBonusesByCasinoOnTodaysDate($bonus->getCasino());

            if(count($casinoBonuses) >= Casino::BONUSES_PER_DAY) {
                // TODO: add flash message
                $this->addFlash('warning', 'Too many submissions for the selected casino in the last 24 hours, '
                    .Casino::BONUSES_PER_DAY . ' bonuses per day allowed.');
                // Message: To many (more than Casino::BONUSES_PER_DAY) submissions for the selected casino in the last 24 hours
                return $this->redirectToRoute('user_bonus_new');
            }

            if(count($bonuses) >= Bonus::BONUSES_PER_USER) {
                // TODO: add flash message
                $this->addFlash('warning', 'You cannot submit more than '
                    .Bonus::BONUSES_PER_USER . ' bonuses per day.');
                return $this->redirectToRoute('user_bonus_new');
            }


            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bonus);
            $entityManager->flush();
            // TODO: add flash message
            $this->addFlash('success', 'Bonus Created!');
            return $this->redirectToRoute('user_bonus_new');
        }


        return $this->render('user_bonus/new.html.twig', [
            //'task' => $task,
            'form' => $form->createView(),
            'bonusesPerUser' => Bonus::BONUSES_PER_USER,
            'bonusesCount' => count($bonuses)
        ]);
    }
}
