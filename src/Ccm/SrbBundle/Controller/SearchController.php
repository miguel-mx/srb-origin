<?php

namespace Ccm\SrbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Ccm\SrbBundle\Entity\Referencia;
use Ccm\SrbBundle\Form\BusquedaType;
use MakerLabs\PagerBundle\Pager;
use MakerLabs\PagerBundle\Adapter\ArrayAdapter;
use MakerLabs\PagerBundle\Adapter\DoctrineOrmAdapter;


class SearchController extends Controller
{

    /**
     * @Route("/search" , name="search")
     * @Template()
     */
    public function searchAction(Request $request)
    {

      $queryData = array('query' => 'Search');
      
      $form = $this->createFormBuilder($queryData)
          ->add('query', 'text')
          ->getForm();

      if ($request->getMethod() == 'POST') {

        $form->bindRequest($request);

        if ($form->isValid()) {

           $queryData = $form->getData();

           $finder = $this->get('foq_elastica.finder.srb.Referencia');
           $referencias = $finder->find($queryData['query'], 100);

           $page = 1;
           $adapter = new ArrayAdapter($referencias);
           $pager = new Pager($adapter, array('page' => $page, 'limit' => 10));

           return $this->render('CcmSrbBundle:Search:result.html.twig', array('pager' => $pager, 'queryData' => $queryData));

        }
        
       }

       $msg = 'no POST';

       return $this->render('CcmSrbBundle:Search:query.html.twig', array('form' => $form->createView(), 'msg' => $msg));

    }

    /**
    * @Route("/qsearch", name="quick_search")
    * @Method({ "head", "get" })
    * @Template
    */
    public function qsearchAction(Request $request)
    {
      $finder = $this->get('foq_elastica.finder.srb.Referencia');
      $searchTerm = $request->query->get('query');
      $referencias = $finder->find($searchTerm, 100);

      $page = 1;
      $adapter = new ArrayAdapter($referencias);
      $pager = new Pager($adapter, array('page' => $page, 'limit' => 10));

      return $this->render('CcmSrbBundle:Search:result.html.twig', array('pager' => $pager, 'queryData' => $searchTerm));

    }

   /**
    * @Route("/busqueda", name="busqueda")
    * @Template()
    */
    public function busquedaAction(Request $request)
    {

      $criterios = array();

      $form = $this->createForm(new BusquedaType(), $criterios);

      // Crea la forma de consulta
      if ($request->getMethod() == 'POST') {

        $form->bindRequest($request);

        if ($form->isValid()) {

          $criterios = $form->getData();

          $em = $this->getDoctrine()->getEntityManager();
          $em->getRepository('CcmSrbBundle:Referencia');

          $qb = $em->createQueryBuilder('p');

          $dql = "";

          // Construye la consulta

          if(!empty($criterios['Type'])) {
            $dql .= 'LOWER(r.type) LIKE :type AND ';
            $qb->setParameter('type', '%'.strtolower($criterios['Type']).'%');
          }

          if(!empty($criterios['Author'])) {
              $dql .= 'LOWER(r.author) LIKE :author AND ';
              $qb->setParameter('author', '%'.strtolower($criterios['Author']).'%');
          }

          if(!$criterios['allYears']) {

            if(intval($criterios['yearStart']) > intval($criterios['yearEnd'])){
              
              $dql .= 'r.yearPub BETWEEN :yearstart AND :yearend AND ';
              $qb->setParameter('yearstart', $criterios['yearEnd']);
              $qb->setParameter('yearend', $criterios['yearStart']);
              
              }
            else{

              $dql .= 'r.yearPub BETWEEN :yearstart AND :yearend AND ';
              $qb->setParameter('yearstart', $criterios['yearStart']);
              $qb->setParameter('yearend', $criterios['yearEnd']);

            }
          }

          $dql = substr($dql, 0, -4); // remove the last " AND ";

          $qb->add('select', 'r')
              ->add('from', 'CcmSrbBundle:Referencia r')
              ->add('where', $dql)
              ->orderBy('r.yearPub', 'DESC');

          $page = 1;
          $adapter = new DoctrineOrmAdapter($qb);
          $pager = new Pager($adapter, array('page' => $page, 'limit' => 10));

          return $this->render('CcmSrbBundle:Search:result.html.twig', array('pager' => $pager));

        }
      }

      return $this->render('CcmSrbBundle:Search:busqueda.html.twig', array(
                           'form' => $form->createView(),
                                                                       ));

    }
    
   /**
    * Lists all Reeferencia entities.
    *
    * @Route("/results/{page}", defaults={"page" = 1 }, name="results")
    * @Template()
    */
    public function resultsAction($page)
    {
        
      $em = $this->getDoctrine()->getEntityManager();

      $entities = $em->getRepository('CcmSrbBundle:Referencia')->createQueryBuilder('m');
      $adapter = new DoctrineOrmAdapter($entities);
      $pager = new Pager($adapter,array('page' => $page, 'limit' => 10));

      return $this->render('CcmSrbBundle:Search:result.html.twig', array('pager' => $pager, 'queryData' => $queryData, 'form' => $form->createView(),));

        //return array('entities' => $entities);
    }

}
