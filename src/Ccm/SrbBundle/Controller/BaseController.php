<?php

namespace Ccm\SrbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ccm\SrbBundle\Entity\Referencia;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;


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

      $title=preg_replace("'\s+'",' ', $bibTex[$i]['title']);
      @$ref->setTitle($title);
      //@$ref->setTitle($bibTex[$i]['title']);
      @$ref->setType($bibTex[$i]['entryType']);
      @$ref->setYearPreprint($bibTex[$i]['yearpreprint']);	
      @$ref->setYearPub($bibTex[$i]['year']);
      @$ref->setJournal($bibTex[$i]['journal']);
      @$ref->setVolume($bibTex[$i]['volume']);
      @$ref->setIssue($bibTex[$i]['number']);
      @$ref->setPages($bibTex[$i]['pages']);
      // Obtiene los autores en la variable $autorLast
      // $autores = $this->authString($bibTex);
      @$ref->setIssn($bibTex[$i]['issn']);
      @$ref->setIsbn($bibTex[$i]['isbn']);
      @$ref->setMedium($bibTex[$i]['medium']);
      @$ref->setArea($bibTex[$i]['area']);
      @$ref->setConference($bibTex[$i]['conference']);
      //$notes=preg_replace("'\s+'",' ', $bibTex[$i]['notas']);
      //@$ref->setNotas($notes);
      @$ref->setNotas(preg_replace("'\s+'",' ',$bibTex[$i]['notas']));	
      @$ref->setrevision($bibTex[$i]['revision']);
      @$ref->setFile($bibTex[$i]['file']);
      @$ref->setArxiv($bibTex[$i]['arxiv']);
      @$ref->setAddress($bibTex[$i]['address']);
      @$ref->setKeywords(preg_replace("'\s+'",' ',$bibTex[$i]['keywords']));

      if (preg_match( '/^[\-+]?[0-9]*\.*\,?[0-9]+$/', $bibTex[$i]['cite'])) {
          @$ref->setZmath($bibTex[$i]['cite']);
      }
      else {
          @$ref->setZmath($bibTex[$i]['zmath']);
        }

      @$ref->setMathscinet($bibTex[$i]['mathscinet']);
      @$ref->setInspires($bibTex[$i]['inspires']);
      @$ref->setDoi($bibTex[$i]['doi']);
      @$ref->setUrl($bibTex[$i]['url']);
      @$ref->setPublisher($bibTex[$i]['publisher']);
      @$ref->setReportNumber($bibtex[$i]['reportNumber']);
      @$ref->setMrNumber($bibTex[$i]['mrnumber']);

      if(@$bibTex[$i]['classmath']) {
      @$ref->setMsc(preg_replace("'\s+'",' ',$bibTex[$i]['classmath']));
      }

      if(@$bibTex[$i]['mrclass']) {
      @$ref->setMsc(preg_replace("'\s+'",' ',$bibTex[$i]['mrclass']));
      }

      @$ref->setBookTitle($bibTex[$i]['booktitle']);
      // @$ref->setAuthor($bibTex[$i]['author']);
      //$ref->setAuthors($autorLast);
      // @$ref->setAuthor($this->authString($bibTex));
      //@$ref->setAuthor($bibTex[$i]['author'][0]['last']);
      @$ref->setAuthor(preg_replace("'\s+'",' ',$this->authString($bibTex[$i]['author'])));
      //print_r($bibTex[$i]['author']);
      //$abst=preg_replace("'\s+'",' ', $bibTex[$i]['abstract']);
      //@$ref->setAbst($abst);
      @$ref->setAbst(preg_replace("'\s+'",' ',$bibTex[$i]['abstract']));
      @$ref->setCreated();
      @$ref->setModified();
      // Manejo de errores???
      $em = $this->getDoctrine()->getEntityManager();

       // retrieving the security identity of the currently logged-in user
      $securityContext = $this->get('security.context');
      $user = $securityContext->getToken()->getUser();
      $securityIdentity = UserSecurityIdentity::fromAccount($user);

      if(false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $ref->addAuthor($user->getAuthor());
            }
      $em->persist($ref);
      $em->flush();

      // creating the ACL
      $aclProvider = $this->get('security.acl.provider');
      $objectIdentity = ObjectIdentity::fromDomainObject($ref);
      $acl = $aclProvider->createAcl($objectIdentity);



      // grant owner access
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

//Array ( [0] => Array ( [first] => Alejandro [von] => [last] => Corichi [jr] => ) 
//        [1] => Array ( [first] => Edward [von] => [last] => Wilson-Ewing [jr] => ) 
//        [2] => Array ( [first] => gerardo [von] => tejero [last] => gomez [jr] => ) ) 

         for($i=0; $i<count($bibTex); $i++) {

                if($i==0){ 
                $tmpLast=$bibTex[$i]['last'];
                $tmpVon=$bibTex[$i]['von'];
                $tmpFirst=$bibTex[$i]['first'];
//                $tmpauth=$tmpVon." ".$tmpLast." ".$tmpFirst;
                  $tmpauth=$tmpFirst. " ".$tmpVon." ".$tmpLast;

                }
                if($i>0){ 
                $tmpLast=$bibTex[$i]['last'];
                $tmpVon=$bibTex[$i]['von'];
                $tmpFirst=$bibTex[$i]['first'];
//              $tmpauth1=$tmpVon." ".$tmpLast." ".$tmpFirst;
                $tmpauth1=$tmpFirst." ".$tmpVon." ".$tmpLast;
                $tmpauth=$tmpauth."; ".$tmpauth1;
                }



        }

       return $tmpauth;
    }

}
 
 