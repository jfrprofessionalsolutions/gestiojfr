<?php

namespace App\Controller;

use App\Entity\PressupostProducte;
use App\Entity\Productes;
use App\Entity\Pressupostos;
use App\Repository\PressupostProducteRepository;
use App\Repository\ProductesRepository;
use App\Form\PressupostProducteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pressupostProducte")
 */
class PressupostProducteController extends AbstractController
{
    /**
     * @Route("/new/{idPressupost}", name="app_pressupost_producte_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PressupostProducteRepository $pressupostProducteRepository, EntityManagerInterface $entityManager, $idPressupost): Response
    {
        $pressupostProducte = new pressupostProducte();
        $form = $this->createForm(PressupostProducteType::class, $pressupostProducte);

        $form->handleRequest($request);

        //S'ha enviat el formulari per a afegir un nou producte a la comanda
        if ($form->isSubmitted() && $form->isValid()) {
            
            //Es busquen els productes que hi ha actualment a dins del pressupost
            $productesPressupost = $entityManager
                ->getRepository(Pressupostos::class)
                ->productesPressupost($idPressupost);
            $idProducteIntroduir = $pressupostProducte->getIdProducte();
            $producteAPressupost = 0;
            //Si el producte a introduir, ja està dins del pressupost, aleshores només s'afegirà al producte, el número de unitats introduits al formulari
            for($i=0;$i<count($productesPressupost);$i++)
            {
                if($productesPressupost[$i]['idProducte'] == $idProducteIntroduir)
                {
                    $producteAPressupost = 1;
                    $idPressupostProducte =  $productesPressupost[$i]['idPressupostProducte'];
                }
            }
            if($producteAPressupost == 1)
            {
                $afegirUnitats = $this->modificarUnitat($request, $pressupostProducte, $entityManager, $idPressupostProducte);

            }
            else
            {
                //S'afageix el producte al pressupost
                $pressupostProducteRepository->add($pressupostProducte, true);
                //S'actualitza el total del pressupost d'acord amb les dades del producte introduit
                $actualitzarTotalPressupost = $this->actualitzarTotalPressupost($pressupostProducte, $entityManager, $idPressupost, $pressupostProducte->getUnitats(), 1);
            }        

            return $this->redirectToRoute('app_pressupostos_edit', ['idPressupost' => $idPressupost] , Response::HTTP_SEE_OTHER);
        }

        //Es construeix el formulari per afegir nou producte al pressupost
        return $this->renderForm('pressupostProducte/new.html.twig', [
            'pressupostProducte' => $pressupostProducte,
            'formAfegirProducte' => $form,
            'idPressupost' => $idPressupost
        ]);
    }

    /**
     * @Route("/{id}", name="app_pressupost_producte_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, PressupostProducte $pressupostProducte, EntityManagerInterface $entityManager, $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pressupostProducte->getId(), $request->request->get('_token'))) {
            //S'actualitza el total del pressupost d'acord amb les dades del producte a treure
            $idPressupost = $pressupostProducte->getIdPressupost();
            $actualitzarTotalPressupost = $this->actualitzarTotalPressupost($pressupostProducte, $entityManager, $idPressupost,0, 0);

            //S'elimina del pressupost el producte seleccionat
            $entityManager->remove($pressupostProducte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pressupostos_edit', ['idPressupost' => $pressupostProducte->getIdPressupost()] , Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/modificarUnitat/{id}", name="app_modificar_unitat_pressupost", methods={"GET", "POST"})
     */
    public function modificarUnitat(Request $request, PressupostProducte $pressupostProducte, EntityManagerInterface $entityManager, $id): Response
    {
        if(isset($_POST['idPressupost']))
        {
            //S'està modificant el número de unitats a través dels botons + / -
            $idPressupost = $_POST['idPressupost'];
            $unitats = $_POST['unitats'];
            $afegirUnitat = $_POST['afegirUnitat'];
            if($afegirUnitat == 1)
            {
                //S'afegeixen unitats
                $unitats = $unitats + 1;
                $actualitzarTotalPressupost = $this->actualitzarTotalPressupost($pressupostProducte, $entityManager, $idPressupost, 1, 1);
            }
            else
            {
                //Es treuen unitats
                $unitats = $unitats - 1;
                $actualitzarTotalPressupost = $this->actualitzarTotalPressupost($pressupostProducte, $entityManager, $idPressupost, 1, 0);
            }
            $productePressupostModificar = $entityManager->getRepository(PressupostProducte::Class)->find($id);
        }
        else
        {
            //S'està modificant el número de unitats a través del formulari d'afegir producte
            $idPressupost = $_POST['pressupost_producte']['idPressupost'];
            $unitatsFormulari = $_POST['pressupost_producte']['unitats'];
            $productePressupostModificar = $entityManager->getRepository(PressupostProducte::Class)->find($id);
            $unitats = $productePressupostModificar->getUnitats();
            $unitats = $unitats + $unitatsFormulari;
            $actualitzarTotalPressupost = $this->actualitzarTotalPressupost($pressupostProducte, $entityManager, $idPressupost, $unitats, 1);
        }
        
        //Es modifica el número d'unitats
        $productePressupostModificar->setUnitats($unitats);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_pressupostos_edit', ['idPressupost' => $productePressupostModificar->getIdPressupost()] , Response::HTTP_SEE_OTHER);
    }

    public function actualitzarTotalPressupost($pressupostProducte, $entityManager, $idPressupost, $unitatsAAfegir, $afegirProducte)
    {
        //Es modifica el total de la comanda, d'acord amb el nou producte a introduir
        $unitatsAfegides = $pressupostProducte->getUnitats();
        $idProducteAfegir = $pressupostProducte->getIdProducte();
        $productesPressupost = $entityManager
        ->getRepository(Pressupostos::class)
        ->productesPressupost($idPressupost);
        $totalAnteriorPressupost = $productesPressupost[0]['totalPressupost'];
        $infoProducteAfegir = $entityManager
            ->getRepository(Productes::class)
            ->buscarProducte($idProducteAfegir);
        $preuProducte = $infoProducteAfegir[0]['preu'];
        if($afegirProducte == 1)
        {
            if($unitatsAAfegir == 1)
            {
                $totalPressupost = $totalAnteriorPressupost + $preuProducte;
            }
            else
            {
                $totalPressupost =  $totalAnteriorPressupost + ($preuProducte * $unitatsAfegides);
            }
        }
        if($afegirProducte == 0)
        {
            if($unitatsAAfegir == 1)
            {
                $totalPressupost = $totalAnteriorPressupost - $preuProducte;
            }
            else
            {
                $totalPressupost =  $totalAnteriorPressupost - ($preuProducte * $unitatsAfegides);
            }
        }
        $pressupostModificar = $entityManager->getRepository(Pressupostos::Class)->find($idPressupost);
        $pressupostModificar->setTotalPressupost($totalPressupost);
        $entityManager->flush();
    }

}
