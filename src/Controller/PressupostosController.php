<?php

namespace App\Controller;

use App\Entity\Pressupostos;
use App\Form\PressupostosType;
use App\Repository\PressupostosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pressupostos")
 */
class PressupostosController extends AbstractController
{
    /**
     * @Route("/", name="app_pressupostos_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $pressupostos = $entityManager
            ->getRepository(Pressupostos::class)
            ->pressupostos();

        return $this->render('pressupostos/index.html.twig', [
            'pressupostos' => $pressupostos,
        ]);
    }

    /**
     * @Route("/new", name="app_pressupostos_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PressupostosRepository $pressupostosRepository, EntityManagerInterface $entityManager): Response
    {
        $pressupost = new Pressupostos();
        $form = $this->createForm(PressupostosType::class, $pressupost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //S'ha enviat el formulari, es crea el nou pressupost
            $pressupostosRepository->add($pressupost, true);

            //Es busca el nou pressupost creat (La seva ID), i la APP et redirigeix a la pantalla d'edició del nou pressupost
            $buscaNouPressupost = $entityManager->getRepository(Pressupostos::class)->idNouPressupost();  
            $idNouPressupost = $buscaNouPressupost[0]['idPressupost'];
            return $this->redirectToRoute('app_pressupostos_edit', ['idPressupost' => $idNouPressupost], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pressupostos/new.html.twig', [
            'pressupost' => $pressupost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idPressupost}", name="app_pressupostos_show", methods={"GET"})
     */
    public function show(EntityManagerInterface $entityManager, $idPressupost): Response
    {
        $pressupost = $entityManager
            ->getRepository(Pressupostos::class)
            ->buscarPressupost($idPressupost);

        $productesPressupost = $entityManager
            ->getRepository(Pressupostos::class)
            ->productesPressupost($idPressupost);

        return $this->render('pressupostos/show.html.twig', [
            'pressupost' => $pressupost[0],
            'productesPressupost' => $productesPressupost
        ]);
    }

    /**
     * @Route("/{idPressupost}/edit", name="app_pressupostos_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Pressupostos $pressupost, PressupostosRepository $pressupostosRepository, EntityManagerInterface $entityManager, $idPressupost): Response
    {
        $form = $this->createForm(PressupostosType::class, $pressupost);
        $form->handleRequest($request);

        $dadesPressupost = $entityManager
        ->getRepository(Pressupostos::class)
        ->buscarPressupost($idPressupost);

        $productesPressupost = $entityManager
            ->getRepository(Pressupostos::class)
            ->productesPressupost($idPressupost);

        if ($form->isSubmitted() && $form->isValid()) {
            $pressupostosRepository->add($pressupost, true);

            return $this->redirectToRoute('app_pressupostos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pressupostos/edit.html.twig', [
            'pressupost' => $pressupost,
            'form' => $form,
            'dadesPressupost' => $dadesPressupost[0],
            'productesPressupost' => $productesPressupost,
        ]);
    }

    /**
     * @Route("/{idPressupost}", name="app_pressupostos_delete", methods={"POST"})
     */
    public function delete(Request $request, Pressupostos $pressuposto, PressupostosRepository $pressupostosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pressuposto->getIdPressupost(), $request->request->get('_token'))) {
            $pressupostosRepository->remove($pressuposto, true);
        }

        return $this->redirectToRoute('app_pressupostos_index', [], Response::HTTP_SEE_OTHER);
    }
}
