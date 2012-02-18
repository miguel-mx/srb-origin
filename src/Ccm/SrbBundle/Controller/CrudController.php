<?php

namespace Ccm\SrbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ccm\SrbBundle\Entity\Referencia;
use Ccm\SrbBundle\Form\ReferenciaType;
use Ccm\SrbBundle\Form\ArticuloType;
use Ccm\SrbBundle\Form\PreprintType;
use Ccm\SrbBundle\Form\MemoriaType;
use Ccm\SrbBundle\Form\EdicionType;
use Ccm\SrbBundle\Form\LibroType;
use Ccm\SrbBundle\Form\EditorType;
use Ccm\SrbBundle\Form\CapituloType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use MakerLabs\PagerBundle\Pager;
use MakerLabs\PagerBundle\Adapter\DoctrineOrmAdapter;


class CrudController extends Controller
{
    /**
     * Lists all Reeferencia entities.
     *
     * @Route("/refs/{page}", defaults={"page" = 1 }, name="refs")
     * @Template()
     */
    public function indexAction($page)
    {
        
	$em = $this->getDoctrine()->getEntityManager();

    $entities = $em->getRepository('CcmSrbBundle:Referencia')->createQueryBuilder('m');
	$adapter = new DoctrineOrmAdapter($entities);
	$pager = new Pager($adapter,array('page' => $page, 'limit' => 10));
	return $this->render('CcmSrbBundle:Refs:list.html.twig',array('pager'=>$pager));

        //return array('entities' => $entities);
    }

    /**
     * Finds and displays a Reeferencias entity.
     *
     * @Route("/{id}/show", name="referencia_show")
     * @Template("CcmSrbBundle:Refs:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CcmSrbBundle:Referencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Registro entity.
     *
     * @Route("/{type}/new", name="referencia_new")
     * @Template("CcmSrbBundle:Refs:new.html.twig")
     */
    public function newAction($type)
    {
        $entity = new Referencia();
	if($type=='article'){       $form   = $this->createForm(new ArticuloType(), $entity);}
	if($type=='unpublished'){   $form   = $this->createForm(new PreprintType(), $entity);}
	if($type=='inproceedings'){ $form   = $this->createForm(new MemoriaType(), $entity);}
	if($type=='book'){          $form   = $this->createForm(new LibroType(), $entity);}
	if($type=='edicion'){       $form   = $this->createForm(new EdicionType(), $entity);}
	if($type=='proceedings'){   $form   = $this->createForm(new EditorType(), $entity);}
	if($type=='inbook'){  $form   = $this->createForm(new CapituloType(), $entity);}
        
        return array(
            'entity' => $entity,
	     'type'=> $type,
            'form'   => $form->createView()
        );
	
	
    }

    /**
     * Creates a new Referencia entity.
     *
     * @Route("/{type}/create", name="referencia_create")
     * @Method("post")
     * @Template("CcmSrbBundle:Refs:new.html.twig")
     */
    public function createAction($type)
    {
        $entity  = new Referencia();
        $request = $this->getRequest();
        if($type=='article'){        $form   = $this->createForm(new ArticuloType(), $entity);}
	if($type=='unpublished'){    $form   = $this->createForm(new PreprintType(), $entity);}
	if($type=='inproceedings'){  $form   = $this->createForm(new MemoriaType(), $entity);}
	if($type=='book'){           $form   = $this->createForm(new LibroType(), $entity);}
	if($type=='edicion'){        $form   = $this->createForm(new EdicionType(), $entity);}
	if($type=='proceedings'){    $form   = $this->createForm(new EditorType(), $entity);}
	if($type=='inbook'){   	$form   = $this->createForm(new CapituloType(), $entity);}
        $form->bindRequest($request);
        if ($form->isValid()) {
	    
	    $em = $this->getDoctrine()->getEntityManager();
	    $em->persist($entity);
            $em->flush();

           // creating the ACL
           $aclProvider = $this->get('security.acl.provider');
           $objectIdentity = ObjectIdentity::fromDomainObject($entity);
           $acl = $aclProvider->createAcl($objectIdentity);
 
          // retrieving the security identity of the currently logged-in user
           $securityContext = $this->get('security.context');
           $user = $securityContext->getToken()->getUser();
           $securityIdentity = UserSecurityIdentity::fromAccount($user);
// 
//         // grant owner access
           $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
           $aclProvider->updateAcl($acl);


            return $this->redirect($this->generateUrl('referencia_show', array('id' => $entity->getId(),'type'=>$type)));
            
        }
	

        return array(
            'entity' => $entity,
	'type'=>$type,
            'form'   => $form->createView()
	  
        );
    }

    /**
     * Displays a form to edit an existing Referencia entity.
     *
     * @Route("/{id}/edit", name="referencia_edit")
     * @Template("CcmSrbBundle:Refs:edit.html.twig")
     */
    public function editAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CcmSrbBundle:Referencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registro entity.');
        }


       $securityContext = $this->get('security.context');
// 
//     // check for edit access
       if (false === $securityContext->isGranted('EDIT', $entity))
        {
 		throw $this->createNotFoundException('Denied permission.');
        }
 
	if (strcasecmp($entity->getType(), 'article') == 0) {		$editForm = $this->createForm(new ArticuloType(), $entity);}
 	if (strcasecmp($entity->getType(), 'unpublished') == 0) {	$editForm = $this->createForm(new PreprintType(), $entity);}
	if (strcasecmp($entity->getType(), 'inproceedings') == 0) {	$editForm = $this->createForm(new MemoriaType(), $entity);}
	if (strcasecmp($entity->getType(), 'book') == 0) {		$editForm = $this->createForm(new LibroType(), $entity);}
	if (strcasecmp($entity->getType(), 'edicion') == 0) {		$editForm = $this->createForm(new EdcionType(), $entity);}
	if (strcasecmp($entity->getType(), 'proceedings') == 0) {	$editForm = $this->createForm(new EditorType(), $entity);}
	if (strcasecmp($entity->getType(), 'inbook') == 0) {		$editForm = $this->createForm(new CapituloType(), $entity);}
	if(($entity->getType()=='incollection')||($entity->getType()=='misc') ) {$editForm = $this->createForm(new ReferenciaType(), $entity);}
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Referencia entity.
     *
     * @Route("/{id}/update", name="referencia_update")
     * @Method("post")
     * @Template("CcmSrbBundle:Refs:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CcmSrbBundle:Referencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registro entity.');
        }

	if (strcasecmp($entity->getType(), 'article') == 0) {		$editForm = $this->createForm(new ArticuloType(), $entity);}
 	if (strcasecmp($entity->getType(), 'unpublished') == 0) {	$editForm = $this->createForm(new PreprintType(), $entity);}
	if (strcasecmp($entity->getType(), 'inproceedings') == 0) {	$editForm = $this->createForm(new MemoriaType(), $entity);}
	if (strcasecmp($entity->getType(), 'book') == 0) {		$editForm = $this->createForm(new LibroType(), $entity);}
	if (strcasecmp($entity->getType(), 'edicion') == 0) {		$editForm = $this->createForm(new EdcionType(), $entity);}
	if (strcasecmp($entity->getType(), 'proceedings') == 0) {	$editForm = $this->createForm(new EditorType(), $entity);}
	if (strcasecmp($entity->getType(), 'inbook') == 0) {		$editForm = $this->createForm(new CapituloType(), $entity);}
	if(($entity->getType()=='incollection')||($entity->getType()=='misc') ) {$editForm = $this->createForm(new ReferenciaType(), $entity);}

        
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('referencia_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Referencia entity.
     *
     * @Route("/{id}/delete", name="referencia_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CcmSrbBundle:Referencia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Registro entity.');
            }
      $securityContext = $this->get('security.context');
// 
//     // check for edit access
       if (false === $securityContext->isGranted('DELETE', $entity))
        {
 		throw $this->createNotFoundException('Denied permission.');
        }
 
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('refs'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
