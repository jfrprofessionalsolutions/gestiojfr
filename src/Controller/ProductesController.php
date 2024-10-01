<?php

namespace App\Controller;

use App\Entity\Productes;
use App\Form\ProductesType;
use App\Repository\ProductesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productes")
 */
class ProductesController extends AbstractController
{
    /**
     * @Route("/", name="app_productes_index", methods={"GET"})
     */
    public function index(ProductesRepository $productesRepository): Response
    {
        return $this->render('productes/index.html.twig', [
            'productes' => $productesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_productes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductesRepository $productesRepository): Response
    {
        $producte = new Productes();
        $form = $this->createForm(ProductesType::class, $producte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productesRepository->add($producte, true);

            return $this->redirectToRoute('app_productes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('productes/new.html.twig', [
            'producte' => $producte,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idProducte}", name="app_productes_show", methods={"GET"})
     */
    public function show(Productes $producte): Response
    {
        return $this->render('productes/show.html.twig', [
            'producte' => $producte,
        ]);
    }

    /**
     * @Route("/{idProducte}/edit", name="app_productes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Productes $producte, ProductesRepository $productesRepository): Response
    {
        $form = $this->createForm(ProductesType::class, $producte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productesRepository->add($producte, true);

            return $this->redirectToRoute('app_productes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('productes/edit.html.twig', [
            'producte' => $producte,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idProducte}", name="app_productes_delete", methods={"POST"})
     */
    public function delete(Request $request, Productes $producte, ProductesRepository $productesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producte->getIdProducte(), $request->request->get('_token'))) {
            $productesRepository->remove($producte, true);
        }

        return $this->redirectToRoute('app_productes_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/infoProductes", name="app_info_productes", methods={"GET"})
     */
    public function infoProductes(EntityManagerInterface $entityManager, $formAfegirProducte): Response
    {
        $productes = $entityManager
            ->getRepository(Productes::class)
            ->findAll();

        return $this->render('productes/productes.html.twig', [
            'productes' => $productes,
            'formAfegirProducte' => $formAfegirProducte
        ]);
    }


}
