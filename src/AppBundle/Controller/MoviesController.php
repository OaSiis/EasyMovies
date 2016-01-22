<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Movies;
use AppBundle\Form\MoviesType;

/**
 * Movies controller.
 *
 * @Route("/movies")
 */
class MoviesController extends Controller
{
    /**
     * Lists all Movies entities.
     *
     * @Route("/", name="movies_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $movies = $this->getDoctrine()->getManager()->getRepository('AppBundle:Movies')->findAll();

        return $this->render('movies/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * Creates a new Movies entity.
     *
     * @Route("/new", name="movies_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $movie = new Movies();
        $form = $this->createForm('AppBundle\Form\MoviesType', $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('movies_show', array('id' => $movie->getId()));
        }

        return $this->render('movies/new.html.twig', array(
            'movie' => $movie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Movies entity.
     *
     * @Route("/{id}", name="movies_show")
     * @Method("GET")
     */
    public function showAction(Movies $movie)
    {
        $deleteForm = $this->createDeleteForm($movie);

        return $this->render('movies/show.html.twig', array(
            'movie' => $movie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Movies entity.
     *
     * @Route("/{id}/edit", name="movies_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Movies $movie)
    {
        $deleteForm = $this->createDeleteForm($movie);
        $editForm = $this->createForm('AppBundle\Form\MoviesType', $movie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('movies_edit', array('id' => $movie->getId()));
        }

        return $this->render('movies/edit.html.twig', array(
            'movie' => $movie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Movies entity.
     *
     * @Route("/{id}", name="movies_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Movies $movie)
    {
        $form = $this->createDeleteForm($movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movie);
            $em->flush();
        }

        return $this->redirectToRoute('movies_index');
    }

    /**
     * Creates a form to delete a Movies entity.
     *
     * @param Movies $movie The Movies entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Movies $movie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movies_delete', array('id' => $movie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
