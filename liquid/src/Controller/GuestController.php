<?php

namespace App\Controller;

use App\Entity\Guest;
use App\Form\GuestType;
use App\Repository\GuestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GuestController extends AbstractController
{
    /**
     * @Route("/guests", name="guests_index")
     */
    public function index(GuestRepository $repo)
    {
        $guests = $repo->findAll();

        return $this->render('guest/index.html.twig', [
            'guests' => $guests
        ]);
    }

    /**
     * Permet d'ajouter un invité
     * 
     * @Route("guests/new", name="guests_create")
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $guest = new Guest();

        $form = $this->createForm(GuestType::class, $guest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($guest);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'invité <strong>{$guest->getName()}</strong> a bien été ajouté !"
            );

            return $this->redirectToRoute('guests_index', [
                'slug' => $guest->getSlug()
            ]);
        }

        return $this->render('guest/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier les caractéristique d'un invité
     * 
     * @Route("/guests/edit/{id}", name="guests_edit")
     * 
     * @param Guest $guest
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Guest $guest, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(GuestType::class, $guest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($guest);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modification de l'invité <strong>{$guest->getName()}</strong> ont bien été enregistré !"
            );

            return $this->redirectToRoute('guests_index', [
                'slug' => $guest->getSlug()
            ]);
        }

        return $this->render('guest/edit.html.twig', [
            'form' => $form->createView(),
            'guest' => $guest
        ]);
    }

    /**
     * Permet d'afficher un invité
     * 
     * @Route("/guests/{id}", name="guests_show")
     * 
     * @param Guest $guest
     * @return Response
     */
    public function show(Guest $guest)
    {
        return $this->render('guest/show.html.twig', [
            'guest' => $guest
        ]);
    }

    /**
     * Permet de supprimer un invité
     * 
     * @Route("/guests/delete/{id}", name="guests_delete")
     * 
     * @param Guest $guest
     * @param EntityManagerInterface $manager
     * @return Response 
     */
    public function delete(Guest $guest, EntityManagerInterface $manager)
    {

        $manager->remove($guest);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'annonce <strong>{$guest->getName()}</strong> a bin été supprimé !"
        );

        return $this->redirectToRoute("guests_index");
    }
}
