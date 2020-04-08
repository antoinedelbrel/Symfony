<?php

namespace App\Controller;

use App\Entity\Expence;
use App\Form\ExpenceType;
use App\Repository\ExpenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpenceController extends AbstractController
{
    /**
     * @Route("/expences", name="expences_index")
     */
    public function index(ExpenceRepository $repo)
    {
        $expences = $repo->findAll();

        return $this->render('expence/index.html.twig', [
            'expences' => $expences
        ]);
    }

    /**
     * Permet de d'ajouter une dépence
     * 
     * @Route("expences/new", name="expences_create")
     * 
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $expence = new Expence();

        $form = $this->createForm(ExpenceType::class, $expence);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $manager->persist($expence);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'achat <strong>{$expence->getName()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('expences_index');
        }


        return $this->render('expence/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier un achat
     * 
     * @Route("/expences/edit/{id}", name="expences_edit")
     * 
     * @param Expence $expence
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Expence $expence, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ExpenceType::class, $expence);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($expence);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de l'achat <strong>{$expence->getName()}</strong> ont bien été enregistré !"
            );

            return $this->redirectToRoute('expences_index');
        }

        return $this->render('expence/edit.html.twig', [
            'form' => $form->createView(),
            'expence' => $expence
        ]);
    }

    /**
     * Permet d'afficher un seul achat
     *
     * @Route("/expences/{id}", name="expences_show")
     *
     * @param Expence $expence
     * @return Response
     */
    public function show(Expence $expence)
    {
        return $this->render('expence/show.html.twig', [
            'expence' => $expence
        ]);
    }

    /**
     * Permet de supprimer un évenement
     *
     * @Route("/expences/delete/{id}", name="expences_delete")
     * @param Expence $expence
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Expence $expence, EntityManagerInterface $manager)
    {
        $manager->remove($expence);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'achat <strong>{$expence->getName()}</strong> a bien été supprimée !"
        );

        return $this->redirectToRoute("expences_index");
    }
}
