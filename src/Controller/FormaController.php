<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class FormaController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/forma", name="forma")
     */
    public function index(): Response
    {
        return $this->render('forma/index.html.twig', [
            'controller_name' => 'FormaController',
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="home")
     */

    public function home() {

        return $this->render('forma/home.html.twig');
    }

}
