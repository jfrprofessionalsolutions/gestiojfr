<?php

namespace App\Controller;

use App\Entity\Factures;
use App\Form\FacturesType;
use App\Repository\FacturesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/factures")
 */
class FacturesController extends AbstractController
{
    /**
     * @Route("/", name="app_factures_index", methods={"GET"})
     */
    public function index(FacturesRepository $facturesRepository): Response
    {
        return $this->render('factures/index.html.twig', [
            'factures' => $facturesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_factures_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FacturesRepository $facturesRepository): Response
    {
        $facture = new Factures();
        $form = $this->createForm(FacturesType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facturesRepository->add($facture, true);

            return $this->redirectToRoute('app_factures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('factures/new.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idFactura}", name="app_factures_show", methods={"GET"})
     */
    public function show(Factures $facture): Response
    {
        return $this->render('factures/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{idFactura}/edit", name="app_factures_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Factures $facture, FacturesRepository $facturesRepository): Response
    {
        $form = $this->createForm(FacturesType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facturesRepository->add($facture, true);

            return $this->redirectToRoute('app_factures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('factures/edit.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idFactura}", name="app_factures_delete", methods={"POST"})
     */
    public function delete(Request $request, Factures $facture, FacturesRepository $facturesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getIdFactura(), $request->request->get('_token'))) {
            $facturesRepository->remove($facture, true);
        }

        return $this->redirectToRoute('app_factures_index', [], Response::HTTP_SEE_OTHER);
    }
}
