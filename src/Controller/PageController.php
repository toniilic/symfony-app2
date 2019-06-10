<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/page/problem-gamling", name="page_problem_gambling")
     */
    public function problemGambling()
    {
        return $this->render('page/problem_gambling.html.twig');
    }

    /**
     * @Route("/page/tos", name="page_tos")
     */
    public function termsOfService()
    {
        return $this->render('page/tos.html.twig');
    }
}
