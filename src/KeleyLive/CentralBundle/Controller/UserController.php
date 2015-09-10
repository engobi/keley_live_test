<?php

namespace KeleyLive\CentralBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use KeleyLive\CentralBundle\Entity\User;
use KeleyLive\CentralBundle\Form\UserType;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;


/**
 * User controller.
 *
 * @Route("/users")
 * @RouteResource("User")
 */
class UserController extends FOSRestController
{

    /**
     * Lists all User entities.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @Route("/", name="users")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KeleyLiveCentralBundle:User')->findAll();

        return $entities;
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/", name="users_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new User();
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
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="users_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KeleyLiveCentralBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $entity;
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="users_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KeleyLiveCentralBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
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
     * Deletes a User entity.
     *
     * @Route("/{id}", name="users_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KeleyLiveCentralBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
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
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
