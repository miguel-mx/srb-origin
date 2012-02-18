<?php

namespace Ccm\SrbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ccm\SrbBundle\Entity\Referencia;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;



class BaseController extends Controller
{

// TODO: Completar las entradas

     /**
     * Guarda en la base de datos las referencias importadas
     * 
     * @param $bibTex
     */

    protected function persistBibStructure($bibTex)
{

    for($i=0; $i<count($bibTex); $i++) {

      $ref = new Referencia();

      @$ref->setTitle($bibTex[$i]['title']);
      @$ref->setType($bibTex[$i]['entryType']);
      @$ref->setYearPreprint($bibTex[$i]['yearpreprint']);	
      @$ref->setYearPub($bibTex[$i]['year']);
      @$ref->setJournal($bibTex[$i]['journal']);
      @$ref->setVolume($bibTex[$i]['volume']);
      @$ref->setIssue($bibTex[$i]['number']);
      @$ref->setPages($bibTex[$i]['pages']);
      // Obtiene los autores en la variable $autorLast
      $autores = $this->authString($bibTex);
      @$ref->setIssn($bibTex[$i]['issn']);
      @$ref->setIsbn($bibTex[$i]['isbn']);
      @$ref->setMedium($bibTex[$i]['medium']);
      @$ref->setArea($bibTex[$i]['area']);
      @$ref->setConference($bibTex[$i]['conference']);
      @$ref->setNotas($bibTex[$i]['notas']);	
      @$ref->setrevision($bibTex[$i]['revision']);
      @$ref->setFile($bibTex[$i]['file']);
      @$ref->setArxiv($bibTex[$i]['arxiv']);
      @$ref->setMathscinet($bibTex[$i]['mathscinet']);
      @$ref->setZmath($bibTex[$i]['zmath']);
      @$ref->setInspires($bibTex[$i]['inspires']);
      @$ref->setDoi($bibTex[$i]['doi']);
      @$ref->setUrl($bibTex[$i]['url']);
     // @$ref->setAuthor($bibTex[$i]['author']);
      //$ref->setAuthors($autorLast);
      @$ref->setAuthor($this->authString($bibTex));
      @$ref->setAbst($bibTex[$i]['abstract']);
      @$ref->setCreated();
      @$ref->setModified();
      // Manejo de errores???
      $em = $this->getDoctrine()->getEntityManager();
      $em->persist($ref);
      $em->flush();

	// creating the ACL
           $aclProvider = $this->get('security.acl.provider');
           $objectIdentity = ObjectIdentity::fromDomainObject($ref);
           $acl = $aclProvider->createAcl($objectIdentity);
 
          // retrieving the security identity of the currently logged-in user
           $securityContext = $this->get('security.context');
           $user = $securityContext->getToken()->getUser();
           $securityIdentity = UserSecurityIdentity::fromAccount($user);
// 
//         // grant owner access
           $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
           $aclProvider->updateAcl($acl);
    } // For cada referencia

}
     
    /**
     * Obtiene la cadena de autores
     * 
     * @param $bibTex
     */
protected function authString($bibTex)
{
// Obtiene los autores en la variable $autorLast
    $authorLast = '';
    $authorJr = '';
    $authorVon = '';
    $tmpFirst = '';
    $tmpLast = '';
    

    for($i=0; $i<count($bibTex); $i++) {
        for($j=0;$j<count($bibTex[$i]['author']);$j++){

            $tmpFirst=$bibTex[$i]['author'][$j]['first'];

            if(array_key_exists('von',$bibTex[$i]['author'][$j])) {
            $authorVon=$bibTex[$i]['author'][$j]['von'];
            }

            $tmpLast=$bibTex[$i]['author'][$j]['last'];

            if(array_key_exists('jr',$bibTex[$i]['author'][$j])) {
              $authorJr=$bibTex[$i]['author'][$j]['jr'];
            }

            if(count($bibTex[$i]['author'])>1){
                if($j==0)
                    $authorLast=$tmpLast." ".$authorVon." ".$tmpFirst;
                if($j>0)
                    $authorLast=$authorLast."; ".$authorVon." ".$tmpLast." ".$tmpFirst;
            }
            else {
                $authorLast=$tmpLast." ".$tmpFirst;
            }
        }
    }

    return $authorLast;
}


 


} // Class


  