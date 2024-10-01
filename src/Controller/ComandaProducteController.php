<?php

namespace App\Controller;

use App\Entity\ComandaProducte;
use App\Entity\Productes;
use App\Entity\Comandes;
use App\Repository\ComandaProducteRepository;
use App\Repository\ComandesRepository;
use App\Form\ComandaProducteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comandaProducte")
 */
class ComandaProducteController extends AbstractController
{
    /**
     * @Route("/new/{idComanda}", name="app_comanda_producte_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ComandaProducteRepository $comandaProducteRepository, EntityManagerInterface $entityManager, $idComanda): Response
    {
        $comandaProducte = new comandaProducte();
        $form = $this->createForm(ComandaProducteType::class, $comandaProducte);

        $form->handleRequest($request);

        //S'ha enviat el formulari per a afegir un nou producte a la comanda
        if ($form->isSubmitted() && $form->isValid()) {
            
            //Es busquen els productes que hi ha actualment a la comanda
            $productesComanda = $entityManager
                ->getRepository(Comandes::class)
                ->productesComanda($idComanda);
            $idProducteIntroduir = $comandaProducte->getIdProducte();
            $producteAComanda = 0;
            //Si el producte a introduir, ja està dins de la comanda, aleshores només s'afegirà al producte, el número de unitats introduits al formulari
            for($i=0;$i<count($productesComanda);$i++)
            {
                if($productesComanda[$i]['idProducte'] == $idProducteIntroduir)
                {
                    $producteAComanda = 1;
                    $idComandaProducte =  $productesComanda[$i]['idComandaProducte'];
                }
            }
            if($producteAComanda == 1)
            {
                $afegirUnitats = $this->modificarUnitat($request, $comandaProducte, $entityManager, $idComandaProducte);

            }
            else
            {
                //S'afageix el producte a la comanda
                $comandaProducteRepository->add($comandaProducte, true);
                //S'actualitza el total de la comanda d'acord amb les dades del producte introduit
                $actualitzarTotalComanda = $this->actualitzarTotalComanda($comandaProducte, $entityManager, $idComanda, $comandaProducte->getUnitats(), 1);
            }        

            return $this->redirectToRoute('app_comandes_edit', ['idComanda' => $idComanda] , Response::HTTP_SEE_OTHER);
        }

        //Es construeix el formulari per afegir nou producte a la comanda
        return $this->renderForm('comandaProducte/new.html.twig', [
            'comandaProducte' => $comandaProducte,
            'formAfegirProducte' => $form,
            'idComanda' => $idComanda
        ]);
    }

    /**
     * @Route("/{id}", name="app_comanda_producte_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, ComandaProducte $comandaProducte, EntityManagerInterface $entityManager, $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comandaProducte->getId(), $request->request->get('_token'))) {
            //S'actualitza el total de la comanda d'acord amb les dades del producte a treure
            $idComanda = $comandaProducte->getIdComanda();
            $actualitzarTotalComanda = $this->actualitzarTotalComanda($comandaProducte, $entityManager, $idComanda,0, 0);

            //S'elimina de la comanda el producte seleccionat
            $entityManager->remove($comandaProducte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comandes_edit', ['idComanda' => $comandaProducte->getIdComanda()] , Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/modificarUnitat/{id}", name="app_modificar_unitat", methods={"GET", "POST"})
     */
    public function modificarUnitat(Request $request, ComandaProducte $comandaProducte, EntityManagerInterface $entityManager, $id): Response
    {
        if(isset($_POST['idComanda']))
        {
            //S'està modificant el número de unitats a través dels botons + / -
            $idComanda = $_POST['idComanda'];
            $unitats = $_POST['unitats'];
            $afegirUnitat = $_POST['afegirUnitat'];
            if($afegirUnitat == 1)
            {
                //S'afegeixen unitats
                $unitats = $unitats + 1;
                $actualitzarTotalComanda = $this->actualitzarTotalComanda($comandaProducte, $entityManager, $idComanda, 1, 1);
            }
            else
            {
                //Es treuen unitats
                $unitats = $unitats - 1;
                $actualitzarTotalComanda = $this->actualitzarTotalComanda($comandaProducte, $entityManager, $idComanda, 1, 0);
            }
            $producteComandaModificar = $entityManager->getRepository(ComandaProducte::Class)->find($id);
        }
        else
        {
            //S'està modificant el número de unitats a través del formulari d'afegir producte
            $idComanda = $_POST['comanda_producte']['idComanda'];
            $unitatsFormulari = $_POST['comanda_producte']['unitats'];
            $producteComandaModificar = $entityManager->getRepository(ComandaProducte::Class)->find($id);
            $unitats = $producteComandaModificar->getUnitats();
            $unitats = $unitats + $unitatsFormulari;
            $actualitzarTotalComanda = $this->actualitzarTotalComanda($comandaProducte, $entityManager, $idComanda, $unitats, 1);
        }
        
        //Es modifica el número d'unitats
        $producteComandaModificar->setUnitats($unitats);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_comandes_edit', ['idComanda' => $producteComandaModificar->getIdComanda()] , Response::HTTP_SEE_OTHER);
    }

    public function actualitzarTotalComanda($comandaProducte, $entityManager, $idComanda, $unitatsAAfegir, $afegirProducte)
    {
        //Es modifica el total de la comanda, d'acord amb el nou producte a introduir
        $unitatsAfegides = $comandaProducte->getUnitats();
        $idProducteAfegir = $comandaProducte->getIdProducte();
        $productesComanda = $entityManager
        ->getRepository(Comandes::class)
        ->productesComanda($idComanda);
        $totalAnteriorComanda = $productesComanda[0]['totalComanda'];
        $infoProducteAfegir = $entityManager
            ->getRepository(Productes::class)
            ->buscarProducte($idProducteAfegir);
        $preuProducte = $infoProducteAfegir[0]['preu'];
        if($afegirProducte == 1)
        {
            if($unitatsAAfegir == 1)
            {
                $totalComanda = $totalAnteriorComanda + $preuProducte;
            }
            else
            {
                $totalComanda =  $totalAnteriorComanda + ($preuProducte * $unitatsAfegides);
            }
        }
        if($afegirProducte == 0)
        {
            if($unitatsAAfegir == 1)
            {
                $totalComanda = $totalAnteriorComanda - $preuProducte;
            }
            else
            {
                $totalComanda =  $totalAnteriorComanda - ($preuProducte * $unitatsAfegides);
            }
        }
        $comandaModificar = $entityManager->getRepository(Comandes::Class)->find($idComanda);
        $comandaModificar->setTotalComanda($totalComanda);
        $entityManager->flush();
    }

}
