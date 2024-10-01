<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Comandes;
use App\Form\ClientsType;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/clients")
 */
class ClientsController extends AbstractController
{
    /**
     * @Route("/", name="app_clients_index", methods={"GET"})
     */
    public function index(ClientsRepository $clientsRepository): Response
    {
        return $this->render('clients/index.html.twig', [
            'clients' => $clientsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nou-client/", name="app_clients_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ClientsRepository $clientsRepository): Response
    {
        $client = new Clients();
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientsRepository->add($client, true);

            return $this->redirectToRoute('app_clients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('clients/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idClient}", name="app_clients_show", methods={"GET"})
     */
    public function show(Clients $client): Response
    {
        return $this->render('clients/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{idClient}/edit", name="app_clients_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Clients $client, ClientsRepository $clientsRepository): Response
    {
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientsRepository->add($client, true);

            return $this->redirectToRoute('app_clients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('clients/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/eliminar-client/{idClient}", name="app_clients_delete", methods={"POST"})
     */
    public function delete(Request $request, Clients $client, ClientsRepository $clientsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getIdClient(), $request->request->get('_token'))) {
            $clientsRepository->remove($client, true);
        }

        return $this->redirectToRoute('app_clients_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/nomClients/", name="app_nom_clients", methods={"GET"})
     */
    public function nomClients(EntityManagerInterface $entityManager, $form): Response
    {
        $nomClients = $entityManager
            ->getRepository(Clients::class)
            ->findAll();

        return $this->render('clients/clients.html.twig', [
            'nomClients' => $nomClients,
            'form' => $form,
        ]);
    }
}
