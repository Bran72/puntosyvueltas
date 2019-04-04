<?php

namespace App\Controller;

use App\Entity\Gamme;
use App\Form\GammeType;
use App\Repository\GammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gamme")
 */
class GammeController extends AbstractController
{
    /**
     * @Route("/", name="gamme_index", methods={"GET"})
     */
    public function index(GammeRepository $gammeRepository): Response
    {
        return $this->render('gamme/index.html.twig', [
            'gammes' => $gammeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="gamme_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gamme = new Gamme();
        $form = $this->createForm(GammeType::class, $gamme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gamme);
            $entityManager->flush();

            return $this->redirectToRoute('gamme_index');
        }

        return $this->render('gamme/new.html.twig', [
            'gamme' => $gamme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gamme_show", methods={"GET"})
     */
    public function show(Gamme $gamme): Response
    {
        return $this->render('gamme/show.html.twig', [
            'gamme' => $gamme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gamme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Gamme $gamme): Response
    {
        $form = $this->createForm(GammeType::class, $gamme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gamme_index', [
                'id' => $gamme->getId(),
            ]);
        }

        return $this->render('gamme/edit.html.twig', [
            'gamme' => $gamme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gamme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Gamme $gamme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gamme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gamme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gamme_index');
    }
}
