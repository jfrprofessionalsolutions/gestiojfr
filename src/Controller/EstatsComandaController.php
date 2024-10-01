<?php

namespace App\Controller;

use App\Entity\EstatsComanda;
use App\Repository\EstatsComandaRepository;
use App\Form\ComandesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/estatsComanda")
 */
class EstatsComandaController extends AbstractController
{
    /**
     * @Route("/", name="app_estats_comanda_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, $form): Response
    {
        $estatsComanda = $entityManager
            ->getRepository(EstatsComanda::class)
            ->findAll();

        return $this->render('estatsComanda/index.html.twig', [
            'estatsComanda' => $estatsComanda,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new", name="app_estats_comanda_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comande = new Comandes();
        $form = $this->createForm(ComandesType::class, $comande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comande);
            $entityManager->flush();

            return $this->redirectToRoute('app_comandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comandes/new.html.twig', [
            'comande' => $comande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idComanda}", name="app_estats_comanda_show", methods={"GET"})
     */
    public function show(EntityManagerInterface $entityManager, $idComanda): Response
    {
        $comanda = $entityManager
            ->getRepository(Comandes::class)
            ->buscarComanda($idComanda);

        $productesComanda = $entityManager
            ->getRepository(Comandes::class)
            ->productesComanda($idComanda);


        return $this->render('comandes/show.html.twig', [
            'comanda' => $comanda[0],
            'productesComanda' => $productesComanda,
        ]);
    }

    /**
     * @Route("/{idComanda}/edit", name="app_estats_comanda_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Comandes $comanda, ComandesRepository $comandesRepository, EntityManagerInterface $entityManager, $idComanda): Response
    {
        $form = $this->createForm(ComandesType::class, $comanda);
        $form->handleRequest($request);

        $dadesComanda = $entityManager
        ->getRepository(Comandes::class)
        ->buscarComanda($idComanda);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_comandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comandes/edit.html.twig', [
            'comanda' => $comanda,
            'form' => $form,
            'dadesComanda' => $dadesComanda[0]
        ]);
    }

    /**
     * @Route("/{idComanda}", name="app_estats_comanda_delete", methods={"POST"})
     */
    public function delete(Request $request, Comandes $comande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comande->getIdComanda(), $request->request->get('_token'))) {
            $entityManager->remove($comande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comandes_index', [], Response::HTTP_SEE_OTHER);
    }

}
