<?php

namespace App\Controller;

use App\Entity\Casino;
use App\Form\CasinoType;
use App\Repository\CasinoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/casino")
 * @IsGranted("ROLE_ADMIN")
 */
class CasinoController extends AbstractController
{
    /**
     * @Route("/", name="casino_index", methods={"GET"})
     */
    public function index(CasinoRepository $casinoRepository): Response
    {
        return $this->render('casino/index.html.twig', [
            'casinos' => $casinoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="casino_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $casino = new Casino();
        $form = $this->createForm(CasinoType::class, $casino);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($casino);
            $entityManager->flush();

            return $this->redirectToRoute('casino_index');
        }

        return $this->render('casino/new.html.twig', [
            'casino' => $casino,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="casino_show", methods={"GET"})
     */
    public function show(Casino $casino): Response
    {
        return $this->render('casino/show.html.twig', [
            'casino' => $casino,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="casino_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Casino $casino): Response
    {
        $form = $this->createForm(CasinoType::class, $casino);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('casino_index', [
                'id' => $casino->getId(),
            ]);
        }

        return $this->render('casino/edit.html.twig', [
            'casino' => $casino,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="casino_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Casino $casino): Response
    {
        if ($this->isCsrfTokenValid('delete'.$casino->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($casino);
            $entityManager->flush();
        }

        return $this->redirectToRoute('casino_index');
    }
}
