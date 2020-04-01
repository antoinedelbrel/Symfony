<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    /**
     * @Route("/events", name="events_index")
     */
    public function index(EventRepository $repo)
    {
        $events = $repo->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events
        ]);
    }

    /**
     * Permet de crée une annonce
     * 
     * @Route("events/new", name="events_create")
     * 
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $manager->persist($event);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$event->getName()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('events_index', [
                'slug' => $event->getSlug()
            ]);
        }


        return $this->render('event/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier un évenement
     * 
     * @Route("/events/{slug}/edit", name="events_edit")
     * 
     * @param Event $event
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Event $event, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($event);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de l'évenement <strong>{$event->getName()}</strong> ont bien été enregistré !"
            );

            return $this->redirectToRoute('events_index', [
                'slug' => $event->getSlug()
            ]);
        }

        return $this->render('event/edit.html.twig', [
            'form' => $form->createView(),
            'event' => $event
        ]);
    }

    /**
     * Permet d'afficher un seul évenememnt
     *
     * @Route("/events/{slug}", name="events_show")
     *
     * @param Event $event
     * @return Response
     */
    public function show(Event $event)
    {
        return $this->render('event/show.html.twig', [
            'event' => $event
        ]);
    }

    /**
     * Permet de supprimer un évenement
     *
     * @Route("/events/{slug}/delete", name="events_delete")
     * @param Event $event
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Event $event, EntityManagerInterface $manager)
    {
        $manager->remove($event);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'annonce <strong>{$event->getName()}</strong> a bien été supprimée !"
        );

        return $this->redirectToRoute("events_index");
    }
}
