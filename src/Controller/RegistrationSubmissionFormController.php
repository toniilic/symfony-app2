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
     * @Route("/", name="registration_submission_form_index", methods={"GET"})
     */
    public function index(RegistrationSubmissionFormRepository $registrationSubmissionFormRepository): Response
    {
        return $this->render('registration_submission_form/index.html.twig', [
            'registration_submission_forms' => $registrationSubmissionFormRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="registration_submission_form_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
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

    /**
     * @Route("/{id}", name="registration_submission_form_show", methods={"GET"})
     */
    public function show(RegistrationSubmissionForm $registrationSubmissionForm): Response
    {
        return $this->render('registration_submission_form/show.html.twig', [
            'registration_submission_form' => $registrationSubmissionForm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="registration_submission_form_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RegistrationSubmissionForm $registrationSubmissionForm): Response
    {
        $form = $this->createForm(RegistrationSubmissionFormType::class, $registrationSubmissionForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('registration_submission_form_index', [
                'id' => $registrationSubmissionForm->getId(),
            ]);
        }

        return $this->render('registration_submission_form/edit.html.twig', [
            'registration_submission_form' => $registrationSubmissionForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="registration_submission_form_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RegistrationSubmissionForm $registrationSubmissionForm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$registrationSubmissionForm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($registrationSubmissionForm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('registration_submission_form_index');
    }
}
