<?php

namespace App\Controller\Admin;

use App\Entity\Show;
use App\Form\ShowType;
use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/show")
 */
class ShowController extends AbstractController
{
    public function getLast(ShowRepository $showRepository): Response
    {
        return $this->render('admin/show/_last.html.twig', [
            'last_shows' => $showRepository->findAll()
        ]);
    }
    /**
     * @Route("/", name="admin_show_index", methods={"GET"})
     */
    public function index(ShowRepository $showRepository): Response
    {
        return $this->render('admin/show/index.html.twig', [
            'shows' => $showRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_show_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($show);
            $entityManager->flush();

            return $this->redirectToRoute('admin_show_index');
        }

        return $this->render('admin/show/new.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_show_show", methods={"GET"})
     */
    public function show(Show $show): Response
    {
        return $this->render('admin/show/show.html.twig', [
            'show' => $show,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_show_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Show $show): Response
    {
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_show_index', [
                'id' => $show->getId(),
            ]);
        }

        return $this->render('admin/show/edit.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_show_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Show $show): Response
    {
        if ($this->isCsrfTokenValid('delete'.$show->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($show);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_show_index');
    }
}
