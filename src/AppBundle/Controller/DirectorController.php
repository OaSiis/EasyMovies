<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Director;
use AppBundle\Form\DirectorType;

/**
 * Director controller.
 *
 * @Route("/director")
 */
class DirectorController extends Controller
{
    /**
     * Lists all Director entities.
     *
     * @Route("/", name="director_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $directors = $this->getDoctrine()->getManager()->getRepository('AppBundle:Director')->findAll();

        return $this->render('director/index.html.twig', [
            'directors' => $directors,
        ]);
    }

    /**
     * Creates a new Director entity.
     *
     * @Route("/new", name="director_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $director = new Director();
        $form = $this->createForm('AppBundle\Form\DirectorType', $director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($director);
            $em->flush();

            return $this->redirectToRoute('director_show', array('id' => $director->getId()));
        }

        return $this->render('director/new.html.twig', array(
            'director' => $director,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Director entity.
     *
     * @Route("/{id}", name="director_show")
     * @Method("GET")
     */
    public function showAction(Director $director)
    {
        $deleteForm = $this->createDeleteForm($director);

        return $this->render('director/show.html.twig', array(
            'director' => $director,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Director entity.
     *
     * @Route("/{id}/edit", name="director_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Director $director)
    {
        $deleteForm = $this->createDeleteForm($director);
        $editForm = $this->createForm('AppBundle\Form\DirectorType', $director);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($director);
            $em->flush();

            return $this->redirectToRoute('director_edit', array('id' => $director->getId()));
        }

        return $this->render('director/edit.html.twig', array(
            'director' => $director,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Director entity.
     *
     * @Route("/{id}", name="director_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Director $director)
    {
        $form = $this->createDeleteForm($director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($director);
            $em->flush();
        }

        return $this->redirectToRoute('director_index');
    }

    /**
     * Creates a form to delete a Director entity.
     *
     * @param Director $director The Director entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Director $director)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('director_delete', array('id' => $director->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
