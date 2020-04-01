<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GuestController extends AbstractController
{
    /**
     * @Route("/guest", name="guest")
     */
    public function index()
    {
        return $this->render('guest/index.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }
}
