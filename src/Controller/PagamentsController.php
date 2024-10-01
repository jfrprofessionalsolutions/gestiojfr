<?php

namespace App\Controller;

use App\Entity\Pagaments;
use App\Form\PagamentsType;
use App\Repository\PagamentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pagaments")
 */
class PagamentsController extends AbstractController
{
    /**
     * @Route("/", name="app_pagaments_index", methods={"GET"})
     */
    public function index(PagamentsRepository $pagamentsRepository): Response
    {
        return $this->render('pagaments/index.html.twig', [
            'pagaments' => $pagamentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_pagaments_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PagamentsRepository $pagamentsRepository): Response
    {
        $pagament = new Pagaments();
        $form = $this->createForm(PagamentsType::class, $pagament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pagamentsRepository->add($pagament, true);

            return $this->redirectToRoute('app_pagaments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pagaments/new.html.twig', [
            'pagament' => $pagament,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idPagament}", name="app_pagaments_show", methods={"GET"})
     */
    public function show(Pagaments $pagament): Response
    {
        return $this->render('pagaments/show.html.twig', [
            'pagament' => $pagament,
        ]);
    }

    /**
     * @Route("/{idPagament}/edit", name="app_pagaments_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Pagaments $pagament, PagamentsRepository $pagamentsRepository): Response
    {
        $form = $this->createForm(PagamentsType::class, $pagament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pagamentsRepository->add($pagament, true);

            return $this->redirectToRoute('app_pagaments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pagaments/edit.html.twig', [
            'pagament' => $pagament,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idPagament}", name="app_pagaments_delete", methods={"POST"})
     */
    public function delete(Request $request, Pagaments $pagament, PagamentsRepository $pagamentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pagament->getIdPagament(), $request->request->get('_token'))) {
            $pagamentsRepository->remove($pagament, true);
        }

        return $this->redirectToRoute('app_pagaments_index', [], Response::HTTP_SEE_OTHER);
    }
}
