<?php

namespace App\Controller;

use App\Entity\Comandes;
use App\Repository\ComandesRepository;
use App\Entity\EstatsComanda;
use App\Entity\ComandaProducte;
use App\Repository\ComandaProducteRepository;
use App\Form\ComandesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comandes")
 */
class ComandesController extends AbstractController
{
    /**
     * @Route("/", name="app_comandes_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $comandes = $entityManager
            ->getRepository(Comandes::class)
            ->comandes();

        return $this->render('comandes/index.html.twig', [
            'comandes' => $comandes,
        ]);
    }

    /**
     * @Route("/new", name="app_comandes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comanda = new Comandes();
        $form = $this->createForm(ComandesType::class, $comanda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //S'ha enviat el formulari, es crea la nova comanda
            $entityManager->persist($comanda);
            $entityManager->flush();

            //Es busca la nova comanda creada (La seva ID), i la APP et redirigeix a la pantalla d'edició de la nova comanda
            $buscaNovaComanda = $entityManager->getRepository(Comandes::class)->idNovaComanda();  
            $idNovaComanda = $buscaNovaComanda[0]['idComanda'];
            return $this->redirectToRoute('app_comandes_edit', ['idComanda' => $idNovaComanda], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comandes/new.html.twig', [
            'comanda' => $comanda,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idComanda}", name="app_comandes_show", methods={"GET"})
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
     * @Route("/{idComanda}/edit", name="app_comandes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Comandes $comanda, ComandesRepository $comandesRepository, EntityManagerInterface $entityManager, $idComanda): Response
    {
        $form = $this->createForm(ComandesType::class, $comanda);
        $form->handleRequest($request);

        $dadesComanda = $entityManager
        ->getRepository(Comandes::class)
        ->buscarComanda($idComanda);

        $productesComanda = $entityManager
            ->getRepository(Comandes::class)
            ->productesComanda($idComanda);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_comandes_edit', ['idComanda' => $idComanda], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comandes/edit.html.twig', [
            'comanda' => $comanda,
            'form' => $form,
            'dadesComanda' => $dadesComanda[0],
            'productesComanda' => $productesComanda
        ]);
    }

    /**
     * @Route("/{idComanda}", name="app_comandes_delete", methods={"POST"})
     */
    public function delete(Request $request, Comandes $comanda, EntityManagerInterface $entityManager): Response
    {
        

        if ($this->isCsrfTokenValid('delete'.$comanda->getIdComanda(), $request->request->get('_token'))) {
            //Abans de borrar la comanda, es borren tots els productes que hi pugui haber creats dins de la comanda
            $productesComanda = $entityManager
            ->getRepository(Comandes::class)
            ->productesComanda($comanda->getIdComanda());

            for($i=0;$i<count($productesComanda);$i++)
            {
                $producteEliminar = $entityManager->getRepository(ComandaProducte::class)->find($productesComanda[$i]['idComandaProducte']);
                $eliminar = $entityManager->getRepository(ComandaProducte::class)->remove($producteEliminar);
            }
            
            //Es borra definitivament la comanda creada
            $entityManager->remove($comanda);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comandes_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/comandesClient/{idClient}", name="app_comandes_client_show", methods={"GET"})
     */
    public function comandesClient(EntityManagerInterface $entityManager, $idClient): Response
    {
        $comandesClient = $entityManager
            ->getRepository(Comandes::class)
            ->comandesClient($idClient);

        return $this->render('comandes/comandesClient.html.twig', [
            'comandesClient' => $comandesClient,
        ]);
    }
}
