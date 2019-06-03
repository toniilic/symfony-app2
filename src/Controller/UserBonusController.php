<?php

namespace App\Controller;

use App\Entity\Bonus;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            ->add('content', TextareaType::class)
            ->add('bonusCode', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $taskApplication = $form->getData();
            $taskApplication->addUser($user);

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $user->addTaskApplication($taskApplication);
            $entityManager->persist($taskApplication);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('task_show', array('id' => $task->getId()));
        }


        return $this->render('user_bonus/new.html.twig', [
            //'task' => $task,
            'form' => $form->createView(),
            'bonusesPerUser' => Bonus::BONUSES_PER_USER
        ]);
    }
}
