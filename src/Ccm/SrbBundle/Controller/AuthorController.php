<?php

namespace Ccm\SrbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ccm\SrbBundle\Entity\Author;
use Ccm\SrbBundle\Form\AuthorType;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * Author controller.
 *
 * @Route("/authors")
 */
class AuthorController extends Controller
{
    /**
     * Lists all Author entities.
     *
     * @Route("/list/", name="author")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('CcmSrbBundle:Author')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Author entity.
     *
     * @Route("/author/{id}/show", name="author_show")
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CcmSrbBundle:Author')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Author entity.
     *
     * @Route("/author/new", name="author_new")
    * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Author();
        $form   = $this->createForm(new AuthorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Author entity.
     *
     * @Route("/author/create", name="author_create")
     * @Method("post")
     * @Secure(roles="ROLE_ADMIN")
     * @Template("CcmSrbBundle:Author:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Author();
        $request = $this->getRequest();
        $form    = $this->createForm(new AuthorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('author_show', array('id' => $entity->getId())));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Author entity.
     *
     * @Route("/author/{id}/edit", name="author_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CcmSrbBundle:Author')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }

        $editForm = $this->createForm(new AuthorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Author entity.
     *
     * @Route("/author/{id}/update", name="author_update")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("post")
     * @Template("CcmSrbBundle:Author:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CcmSrbBundle:Author')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }

        $editForm   = $this->createForm(new AuthorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('author_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Author entity.
     *
     * @Route("/author/{id}/delete", name="author_delete")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CcmSrbBundle:Author')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Author entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('author'));
    }

   /**
    * Presenta publicaciones de un autor
    *
    * @Route("/author/{id}/references", name="author_references")
    * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
    */
    public function referencesAction($id)
    {

      $em = $this->getDoctrine()->getEntityManager();
      $entity = $em->getRepository('CcmSrbBundle:Author')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Author entity.');
      }

      $publications = $entity->getPublications();

      return $this->render('CcmSrbBundle:Author:references.html.twig',array('publications'=> $publications, 'name'=> $entity->getName()));

    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
