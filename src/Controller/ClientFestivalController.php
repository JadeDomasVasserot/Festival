<?php
/**
 * Contrôleur permettant de gerer l'association entre les clients/festival
 */
namespace App\Controller;

use App\Entity\ClientFestival;
use App\Form\ClientFestivalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Entity\Festival;

/**
 * @Route("/clientFestival")
 * permet d'accéder à l'URL client festival
 */
class ClientFestivalController extends AbstractController
{
    /**
     * @Route("/", name="client_festival_index", methods={"GET"})
     * affiche un tableau avec toutes les associations client/festival
     */
    public function index(): Response
    {
        $clientFestivals = $this->getDoctrine()
            ->getRepository(ClientFestival::class)
            ->findAll();

        $clients = $this->getDoctrine()
            ->getRepository(Client::class)
            ->findAll();

        $festivals = $this->getDoctrine()
            ->getRepository(Festival::class)
            ->findAll();

        return $this->render('client_festival/index.html.twig', [
            'client_festivals' => $clientFestivals,
            'clients' => $clients,
            'festivals' => $festivals,
        ]);
    }

    /**
     * @Route("/new", name="client_festival_new", methods={"GET","POST"})
     * permet de créer une association entre un client et un festival
     */
    public function new(Request $request): Response
    {
        $clientFestival = new ClientFestival();
        $form = $this->createForm(ClientFestivalType::class, $clientFestival);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clientFestival);
            $entityManager->flush();

            return $this->redirectToRoute('client_festival_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_festival/new.html.twig', [
            'client_festival' => $clientFestival,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_festival_show", methods={"GET"})
     *permet de voir les détails de l'association sélectionnée
     */
    public function show(ClientFestival $clientFestival): Response
    {
        return $this->render('client_festival/show.html.twig', [
            'client_festival' => $clientFestival,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_festival_edit", methods={"GET","POST"})
     * permet d'éditer les informations de l'association sélectionée
     */
    public function edit(Request $request, ClientFestival $clientFestival): Response
    {
        $form = $this->createForm(ClientFestivalType::class, $clientFestival);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_festival_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_festival/edit.html.twig', [
            'client_festival' => $clientFestival,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_festival_delete", methods={"POST"})
     * permet de supprimer l'association sélectionée
     */
    public function delete(Request $request, ClientFestival $clientFestival): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clientFestival->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($clientFestival);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_festival_index', [], Response::HTTP_SEE_OTHER);
    }
}
