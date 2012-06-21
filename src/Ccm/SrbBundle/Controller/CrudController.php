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
use Ccm\SrbBundle\Form\EditPreprintType;
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
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
class CrudController extends Controller
{
    /**
     * Lists all Referencia entities.
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

        $authors = $entity->getAuthors();

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'authors'     => $authors,
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
        //if($type=='edicion'){       $form   = $this->createForm(new EdicionType(), $entity);}
        if($type=='proceedings'){   $form   = $this->createForm(new EditorType(), $entity);}
        if($type=='incollection'){  $form   = $this->createForm(new CapituloType(), $entity);}

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
        if($type=='incollection'){   	$form   = $this->createForm(new CapituloType(), $entity);}
        $form->bindRequest($request);
        if ($form->isValid()) {


        $repository = $this->getDoctrine()->getRepository('CcmSrbBundle:Referencia');
        $titles= $repository->findOneByTitle($entity->getTitle());

        if ($titles){

            return array(
            'entity' => $entity,'type'=>$type,
            'repeat'=>$titles->getId(),
            'form'   => $form->createView()
     );

    }
           else {
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


           $sid = new RoleSecurityIdentity(ROLE_SUPER_ADMIN);
           $acl->insertClassAce($sid, MaskBuilder::MASK_OWNER); 
           // grant owner access
           $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
           $aclProvider->updateAcl($acl);

           return $this->redirect($this->generateUrl('referencia_show', array('id' => $entity->getId(),'type'=>$type)));
           }
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

           $securityContext = $this->container->get('security.context');

//            if ( (false === $securityContext->isGranted('ROLE_SUPER_ADMIN')) || (false === $securityContext->isGranted('EDIT', $entity) )) {
//                   throw new AccessDeniedHttpException();
//
//            }


        // check for edit access
        if ((false === $securityContext->isGranted('ROLE_SUPER_ADMIN')))
         {

        if ((false === $securityContext->isGranted('EDIT', $entity)))
         {

            throw new AccessDeniedHttpException();
         }
         }

        if (strcasecmp($entity->getType(), 'article') == 0) {		$editForm = $this->createForm(new ArticuloType(), $entity);}
        if (strcasecmp($entity->getType(), 'unpublished') == 0) {	$editForm = $this->createForm(new EditPreprintType(), $entity);}
        if (strcasecmp($entity->getType(), 'inproceedings') == 0) {	$editForm = $this->createForm(new MemoriaType(), $entity);}
        if (strcasecmp($entity->getType(), 'book') == 0) {		$editForm = $this->createForm(new LibroType(), $entity);}
        //if (strcasecmp($entity->getType(), 'edicion') == 0) {		$editForm = $this->createForm(new EdcionType(), $entity);}
        if (strcasecmp($entity->getType(), 'proceedings') == 0) {	$editForm = $this->createForm(new EditorType(), $entity);}
        if (strcasecmp($entity->getType(), 'incollection') == 0) {		$editForm = $this->createForm(new CapituloType(), $entity);}
        if(($entity->getType()=='incollection')||($entity->getType()=='misc') || ($entity->getType()=='') ) {$editForm = $this->createForm(new ReferenciaType(), $entity);}
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
        //if (strcasecmp($entity->getType(), 'edicion') == 0) {		$editForm = $this->createForm(new EdcionType(), $entity);}  
        if (strcasecmp($entity->getType(), 'proceedings') == 0) {	$editForm = $this->createForm(new EditorType(), $entity);}
        if (strcasecmp($entity->getType(), 'incollection') == 0) {		$editForm = $this->createForm(new CapituloType(), $entity);}
        if(($entity->getType()=='incollection')||($entity->getType()=='misc') || ($entity->getType()=='') ) {$editForm = $this->createForm(new ReferenciaType(), $entity);}

        $deleteForm = $this->createDeleteForm($id);
        $request = $this->getRequest();
        $editForm->bindRequest($request);
        $repository = $this->getDoctrine()->getRepository('CcmSrbBundle:Referencia');

        $titles= $repository->findOneById($id);

       if ($editForm->isValid()) {

       if ($titles && ($titles->getId() != $entity->getId()) ){

       return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'repeat'=>'La referencia número '.$titles->getId().' tiene el mismo título',
            'delete_form' => $deleteForm->createView(),
        );

      }
           else {


         if(false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {

                $user = $this->container->get('security.context')->getToken()->getUser();
                $entity->setUser($user); 
                $entity->setRevision(false);
                $em->persist($entity);
                $em->flush();

        }

                $user = $this->container->get('security.context')->getToken()->getUser();
                $entity->setUser($user); 
                $em->persist($entity);
                $em->flush();

            return $this->redirect($this->generateUrl('referencia_edit', array('id' => $id)));

 }
 }


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

       // check for edit access
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

  /**
    * Asocia autores a un artículo
    *
    * @Route("/{id}/authors", name="article_authors")
    */
    public function addAuthorsAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('CcmSrbBundle:Referencia')->find($id);
        if (!$entity) {
          throw $this->createNotFoundException('Unable to find Registro entity.');
        }

        // Crea la forma de asociación
          $form = $this->createFormBuilder($entity)
              ->add('authors', null, array('label'  => 'Autor(es) Institucionales','required'=>false))
              ->getForm();

         $request = $this->getRequest();


         if ($request->getMethod() == 'POST') {

           $form->bindRequest($request);
           if ($form->isValid()) {

             $aclProvider = $this->container->get('security.acl.provider');
             $objectIdentity = ObjectIdentity::fromDomainObject($entity); 
             $authors=$entity->getAuthors(); //Obtiene los autores que se asocian a la referencia
             $acl = $aclProvider->findAcl($objectIdentity);//Verifica si existe un registro en ACL de la referencia
             $aces = $acl->getObjectAces();//Obtiene cada uno de los ACEs relacionados con ACL
             $j=0; 	
             //Se crea un arreglo con los autores existentes
             foreach($aces as $ace){
             $useraces[$j] = $ace->getSecurityIdentity()->getUsername();
               $j++;
             }	
              //Si no hay autores que se vayan a relacionar con la referencia, se hace redirect a referencia_show
                 if (count($authors)==0){
                 $em->persist($entity);
                 $em->flush();
                 return $this->redirect($this->generateUrl('referencia_show', array('id' => $id)));
              }
               //Si existen autores que se vayan a relacionar con la referencia, se valida que no existan como ACE
         else{
                 foreach($authors as $author){
                   $user=$author->getUser();
                if(in_array($user,$useraces)){
                  $aclProvider->updateAcl($acl);
                   }
                //Si no existe un ACE asociado, se crea un nuevo registro ACE usando el autor como usuario y la referencia asociada a la ACL
              else{
                     $securityIdentity = new UserSecurityIdentity($user, 'Ccm\\SrbBundle\\Entity\\User');
                     $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                     $aclProvider->updateAcl($acl);	
                  }
                $em->persist($entity);
                $em->flush();

                }
                return $this->redirect($this->generateUrl('referencia_show', array('id' => $id)));
              }
            }
         }
        return $this->render('CcmSrbBundle:Refs:authors.html.twig', array(
                             'form' => $form->createView(), 'entity' => $entity,
                                                                          ));
   }




}

