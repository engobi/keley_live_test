<?php

namespace KeleyLive\CentralBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use KeleyLive\CentralBundle\Entity\Group;
use KeleyLive\CentralBundle\Form\GroupType;

/**
 * Group controller.
 *
 * @Route("/groups")
 * @RouteResource("Group")
 */
class GroupController extends FOSRestController
{

    /**
     * Lists all Group entities.
     *
     * @Route("/", name="groups")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KeleyLiveCentralBundle:Group')->findAll();

        return $entities;
    }

    /**
     * Creates a new Group entity.
     *
     * @Route("/", name="groups_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new Group();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $entity;
        }

        return array(
            'errors' => $form->getErrors(true),
            'entity' => $entity
        );
    }

    /**
     * Creates a form to create a Group entity.
     *
     * @param Group $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Group $entity)
    {
        $form = $this->createForm(new GroupType(), $entity, array(
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Finds and displays a Group entity.
     *
     * @Route("/{id}", name="groups_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KeleyLiveCentralBundle:Group')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        return $entity;
    }

    /**
     * Creates a form to edit a Group entity.
     *
     * @param Group $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Group $entity)
    {
        $form = $this->createForm(new GroupType(), $entity, array(
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Group entity.
     *
     * @Route("/{id}", name="groups_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KeleyLiveCentralBundle:Group')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $entity;
        }

        return array(
            'errors' => $editForm->getErrors(true),
            'entity' => $entity
        );
    }

    /**
     * Deletes a Group entity.
     *
     * @Route("/{id}", name="groups_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KeleyLiveCentralBundle:Group')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        try {
            $em->remove($entity);
            $em->flush();
        } catch (\Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }

        return array(
            'success' => true,
            'message' => "Entity deleted."
        );
    }

    /**
     * Creates a form to delete a Group entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groups_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
