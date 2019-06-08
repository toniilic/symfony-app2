<?php

namespace App\Controller;

use App\Entity\RegistrationSubmissionForm;
use App\Form\RegistrationSubmissionFormType;
use App\Repository\RegistrationSubmissionFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/registration/submission/form")
 */
class RegistrationSubmissionFormController extends AbstractController
{

    /**
     * @Route("/new", name="registration_submission_form_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if($this->getUser()) {
            $this->addFlash('warning', 'You are already registered.');
            return $this->redirectToRoute('home');
        }
        $registrationSubmissionForm = new RegistrationSubmissionForm();
        $form = $this->createForm(RegistrationSubmissionFormType::class, $registrationSubmissionForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($registrationSubmissionForm);
            $entityManager->flush();

            $this->addFlash('warning', 'Thank you, your submission has been received.
             We will review it in a shortly manner.');
            return $this->redirectToRoute('home');
        }

        return $this->render('registration_submission_form/new.html.twig', [
            'registration_submission_form' => $registrationSubmissionForm,
            'form' => $form->createView(),
        ]);
    }

}
