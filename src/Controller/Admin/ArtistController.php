<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use App\Repository\TagRepository;
use App\Service\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/artist")
 */
class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="admin_artist_index", methods={"GET"})
     */
    public function index(ArtistRepository $artistRepository): Response
    {
        return $this->render('admin/artist/index.html.twig', [
            'artists' => $artistRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_artist_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artist);
            $entityManager->flush();

            return $this->redirectToRoute('admin_artist_index');
        }

        return $this->render('admin/artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search", name="admin_search_artist")
     */
    public function search(Request $request, ArtistRepository $artistRepo)
    {
        $search = $request->query->get('search');

        if( ! $search){
            throw $this->createNotFoundException();
        }

        $artists = $artistRepo->findByPseudonym($search);
        $artists = array_map(function(Artist $artist){return [
            'id'=>$artist->getId(),
            'pseudonym'=>$artist->getPseudonym()
        ];}, $artists);

        return $this->json(['data' => $artists]);
    }

    /**
     * @Route("/{id}", name="admin_artist_show", methods={"GET"})
     */
    public function show(Artist $artist): Response
    {
        return $this->render('admin/artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_artist_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artist $artist): Response
    {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_artist_index', [
                'id' => $artist->getId(),
            ]);
        }

        return $this->render('admin/artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}", name="admin_artist_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Artist $artist): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_artist_index');
    }
}
