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

            return $this->redirectToRoute('events_show', [
                'slug' => $event->getSlug()
            ]);
        }


        return $this->render('event/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher un seul évenememnt
     *
     * @Route("/events/{slug}", name="events_show")
     *
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
