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

// use Pagerfanta\Adapter\ArrayAdapter;
// use Pagerfanta\Pagerfanta;
// use Pagerfanta\Adapter\DoctrineORMAdapter;
// use Pagerfanta\Exception\NotValidCurrentPageException;

class SearchController extends Controller
{

    /**
    * @Route("/search2" , name="search2")
    * @Template()
    */
    public function search2Action(Request $request)
    {
//     $form = $this->createFormBuilder($queryData, array('csrf_protection' => false))
//         ->add('query', 'text')
//         ->getForm();

    $msg = "Mensaje";

    return $this->render('CcmSrbBundle:Search:search2.html.twig', array('msg' => $msg));

    }



    /**
     * @Route("/search1" , name="search1")
     * @Template()
     */
    public function search1Action(Request $request)
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
/*
           $pagerfanta = new Pagerfanta(new ArrayAdapter($referencias));
           $pagerfanta->setCurrentPage($this->get('request')->query->get('page', 1), false, true);
           $pagerfanta->setMaxPerPage(15);

           return $this->render('CcmSrbBundle:Search:result2.html.twig', array('paginator' => $pagerfanta));*/

           $page = 1;
           $adapter = new ArrayAdapter($referencias);
           $pager = new Pager($adapter, array('page' => $page, 'limit' => 10));

           return $this->render('CcmSrbBundle:Search:result.html.twig', array('pager' => $pager, 'queryData' => $queryData, 'ruta' => 'search'));

        }

       }

       $msg = "Mensaje";

       return $this->render('CcmSrbBundle:Search:query.html.twig', array('form' => $form->createView(), 'msg' => $msg));

    }

    /**
    * @Route("/qsearch", name="quick_search")
    * @Method({ "head", "get" })
    * @Template
    */
    public function qsearchAction(Request $request)
    {

      $page = '1';

      $finder = $this->get('foq_elastica.finder.srb.Referencia');
      $searchTerm = $request->query->get('query');
      $page = $request->query->get('page');
      $referencias = $finder->find($searchTerm, 100);
/*
      $pagerfanta = new Pagerfanta(new ArrayAdapter($referencias));
      $pagerfanta->setCurrentPage($this->get('request')->query->get('page', 1), false, true);
      $pagerfanta->setMaxPerPage(15);

      return $this->render('CcmSrbBundle:Search:result2.html.twig', array('paginator' => $pagerfanta));*/

      $adapter = new ArrayAdapter($referencias);
      $pager = new Pager($adapter, array('page' => $page, 'limit' => 10));

      return $this->render('CcmSrbBundle:Search:qresult.html.twig', array(
                           'pager' => $pager,
                           'queryData' => $searchTerm,
                           'ruta' => 'quick_search'
                           ));
    }

   /**
    * @Route("/busqueda", name="busqueda")
    * @Template()
    */
    public function busquedaAction(Request $request)
    {

      $criterios = array();

      $form = $this->createForm(new BusquedaType(), $criterios);

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

            $dql .= 'r.yearPub BETWEEN :yearstart AND :yearend AND ';

            if(intval($criterios['yearStart']) > intval($criterios['yearEnd'])){

              $qb->setParameter('yearstart', $criterios['yearEnd']);
              $qb->setParameter('yearend', $criterios['yearStart']);

            }
            else{

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

          //$this->setPager($pager);

          return $this->render('CcmSrbBundle:Search:result.html.twig', array('pager' => $pager));

        }
      }

      return $this->render('CcmSrbBundle:Search:query.html.twig');
    }

    /**
    * Lists all Reeferencia entities.
    *
    * @Route("/query", name="query")
    * @Method({ "head", "get" })
    * @Template()
    */
    public function queryAction(Request $request)
    {

      $criterios = array();
      $queryString = urldecode($request->getQueryString());
      $params = $request->query->all();
      // URL Decode ...
          

//       $criterios = $form->getData();
//       $criterios = $this->get('request')->request->all();
//       $request = $this->get('request');
//       $request = $this->get('request');

      $em = $this->getDoctrine()->getEntityManager();
      $em->getRepository('CcmSrbBundle:Referencia');

      $qb = $em->createQueryBuilder('p');

      $dql = "";

          // Construye la consulta
              $criterios['Title'] = $request->query->get('Title', '');

              if(empty($criterios['Title']) == FALSE) {
                $dql .= 'LOWER(r.title) LIKE :title AND ';
                $qb->setParameter('title', '%'.strtolower($criterios['Title']).'%');
              }
 
              $criterios['Type'] = $request->query->get('Type', '');

              if(empty($criterios['Type']) == FALSE) {
                $dql .= 'LOWER(r.type) LIKE :type AND ';
                $qb->setParameter('type', '%'.strtolower($criterios['Type']).'%');
              }

              $criterios['Author'] = $request->query->get('Author', '');

              if(empty($criterios['Author']) == FALSE) {
                $dql .= 'LOWER(r.author) LIKE :author AND ';
                $qb->setParameter('author', '%'.strtolower($criterios['Author']).'%');
              }

              $criterios['allYears'] = $request->query->get('allYears', '');
              $criterios['yearStart'] = $request->query->get('yearStart', '');
              $criterios['yearEnd'] = $request->query->get('yearEnd', '');

//               if(in_array("allYears", $criterios) == FALSE) {
              if(empty($criterios['allYears'])) {

                  $dql .= 'r.yearPub BETWEEN :yearstart AND :yearend AND ';
//                 if(intval($criterios['yearStart']) > intval($criterios['yearEnd'])){
                  if(intval($criterios['yearStart']) > intval($criterios['yearEnd'])) {

                      $qb->setParameter('yearstart', $criterios['yearEnd']);
                      $qb->setParameter('yearend', $criterios['yearStart']);

                  }
                  else {

                      $qb->setParameter('yearstart', $criterios['yearStart']);
                      $qb->setParameter('yearend', $criterios['yearEnd']);

                  }
              }

              $dql = substr($dql, 0, -4); // remove the last " AND ";

              $qb->add('select', 'r')
                  ->add('from', 'CcmSrbBundle:Referencia r')
                  ->add('where', $dql)
                  ->orderBy('r.yearPub', 'DESC');

              $criterios['page'] = $request->query->get('page', '');

              if(empty($criterios['page']))
                 $page = 1;
              else
                  $page = $criterios['page'];

              $adapter = new DoctrineOrmAdapter($qb);
              $pager = new Pager($adapter, array('page' => $page, 'limit' => 10));

          //$this->setPager($pager);

          return $this->render('CcmSrbBundle:Search:result.html.twig', array('pager' => $pager, 'queryString' => $queryString, 'params' => $params));
    }


   /**
    * Lists all Reeferencia entities.
    *
    * @Route("/search", name="search")
    * @Method({ "head", "get" })
    * @Template()
    */
    public function searchAction(Request $request)
    {

      $finder = $this->get('foq_elastica.finder.srb.Referencia');
      $searchTerm = $request->query->get('q');
      $page = $request->query->get('page');

      if(!$page) { $page = 1; }

      $referencias = $finder->find($searchTerm, 100);

      $adapter = new ArrayAdapter($referencias);
      $pager = new Pager($adapter, array('page' => $page, 'limit' => 10));

      return $this->render('CcmSrbBundle:Search:search.html.twig', array('pager' => $pager));
    }

}
