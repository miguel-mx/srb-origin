<?php

namespace Ccm\SrbBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ccm\SrbBundle\Util;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ccm\SrbBundle\Util\Structures_BibTex;
use Ccm\SrbBundle\Util\PEAR;
use Ccm\SrbBundle\Util\SimplePie\SimplePie;
use Ccm\SrbBundle\Form\Upload;
use Ccm\SrbBundle\Entity\Referencia;



class WebController extends BaseController
{


/**
     * Forma de solucitud de web
     * @Route("/arxiv", name="arxiv")
     * @Template()
     */
  public function arxivAction(Request $request)
{
    $idlist = '';

    $form = $this->createFormBuilder($idlist)
        ->add('idlist', 'text', array('label' => 'ArXiv Ids:'))
        ->getForm();

    return $this->render('CcmSrbBundle:Refs:arxiv.html.twig', array(
                         'form' => $form->createView(),
                         ));
  }


  /**
      * Forma de solucitud de web
      * Realiza una consulta al API de arxiv.org, agrega las referencias encontradas a la base de datos
      * @Route("/arxiv_post", name="arxiv_post")
      * @Method("post")
      * @Template()
    */
  public function arxivPostAction(Request $request)
{

    $addarray = array();
    $idlist = '';

    $form = $this->createFormBuilder($idlist)
        ->add('idlist', 'text')
        ->getForm();

    $form->bindRequest($request);

    //Valida la forma; *****************************************************************

    $idlist= $form['idlist']->getData();

    // Base api query url
    $base_url = 'http://export.arxiv.org/api/query?';

    // Search parameters
    // $search_query = 'au:Oeckl';

    //Registro Inexistente
    // $search_query = 'id_list=1106.9000';

    //Registro con Error
    // $search_query = 'id_list=1106.1605x';

    // Un registro
    //$search_query = 'id_list=1106.1605';

    // Dos registros
    //$search_query = 'id_list=0804.4631,1106.1605';
    $search_query = 'id_list='.$idlist;
    
    $start = 0;                     // retreive the first 5 results
    $max_results = 30;

    $query = $search_query."&start=".$start."&max_results=".$max_results;

    $feed = new SimplePie($base_url.$query);

    $feed->init();
    $feed->handle_content_type();

    $atom_ns = 'http://www.w3.org/2005/Atom';
    $opensearch_ns = 'http://a9.com/-/spec/opensearch/1.1/';
    $arxiv_ns = 'http://arxiv.org/schemas/atom';

    $totalResults = $feed->get_feed_tags($opensearch_ns,'totalResults');
    // Run through each entry, and print out information
    $i = 0;

    foreach ($feed->get_items() as $entry) {


        $addarray[$i]['title'] = $entry->get_title();

        // Prueba si hubo un error
        if(!strcmp('Error', $addarray[$i]['title']))
        {
          $error = $entry->get_description();

          return new Response('Error! '.$error);

        }

        // Prueba si no existe el registro
        if(!strcmp('', $addarray[$i]['title']))
        {
          return new Response('No se encontró el registro! ');

        }

        $addarray[$i]['entryType'] = 'Unpublished';

        $temp = explode('/abs/',$entry->get_id());
        $addarray[$i]['arxiv'] = $temp[1];

        $authors = array();
        $j = 0;

        foreach ($entry->get_item_tags($atom_ns,'author') as $author) {
            $name = $author['child'][$atom_ns]['name'][0]['data'];

            // Convierte $name en last/first
            $lfname = explode(" ", $name);

            
            // $addarray[$i]['author'][$j]['first'] = $lfname[0];
	    $addarray[$i]['author'][$j]['first'] = $lfname[0];	
	    $addarray[$i]['author'][$j]['von'] = '';
	    //$addarray[$i]['author'][$j++]['first'] = $name;
            $addarray[$i]['author'][$j]['last']  = $lfname[1];

        array_push($authors,' '.$name);
        }

        // get the links to the abs page and pdf for this e-print
        foreach ($entry->get_item_tags($atom_ns,'link') as $link) {

          if ($link['attribs']['']['rel'] == 'alternate') {
                $addarray[$i]['url'] = $link['attribs']['']['href'];
                //print("abs page link: ".$link['attribs']['']['href'].EOL);
            } elseif ($link['attribs']['']['title'] == 'pdf') {
                $addarray[$i]['file'] = $link['attribs']['']['href'];
                //print("pdf link: ".$link['attribs']['']['href'].EOL);
            }
        
        }

        # The journal reference, comments and primary_category sections live under
        # the arxiv namespace
        $journal_ref_raw = $entry->get_item_tags($arxiv_ns,'journal_ref');
        
        if ($journal_ref_raw) {
            $journal_ref = $journal_ref_raw[0]['data'];
            $addarray[$i]['journal'] = $journal_ref_raw[0]['data'];
        }

        $comments_raw = $entry->get_item_tags($arxiv_ns,'comment');
        
        if ($comments_raw) {
            $addarray[$i]['notas'] = $comments_raw[0]['data'];
        }

        $primary_category_raw = $entry->get_item_tags($arxiv_ns, 'primary_category');
        $primary_category = $primary_category_raw[0]['attribs']['']['term'];

        // Lets get all the categories
        $categories = array();

        foreach ($entry->get_categories() as $category) {
            array_push($categories,$category->get_label());
        }

        $categories_string = join(', ',$categories);
    
        $addarray[$i]['keywords'] = $categories_string;
        $addarray[$i]['abstract'] = $entry->get_description();

        $i++;
    } // For cada referencia

        $repository = $this->getDoctrine()->getRepository('CcmSrbBundle:Referencia');
        $m=0;
        $n=0;
        $norepeat=null;
        $repeat=null;


        for($m=0;$m<count($addarray);$m++){
           $titles= $repository->findOneByTitle($addarray[$m]['title']);
           if ($titles){
              $repeat[$n]=$addarray[$m];
              $n++;
              unset($titles);
           }
           else {
           $norepeat[$n]=$addarray[$m];
           $n++;
           }
       }

        $numrefsTotal=count($repeat)+count($norepeat);
        $numrefsRepeat= count($repeat);
        $numrefsNoRepeat= count($norepeat);


    // Guarda las referencias
    $this->persistBibStructure($addarray);
    $numrefsTotal=count($addarray);

         //return $this->render('CcmSrbBundle:Refs:confirm.html.twig', array('bibTex' => $addarray,'numrefsTotal'=>$numrefsTotal));
        return $this->render('CcmSrbBundle:Refs:confirm.html.twig', array('bibTex' => $norepeat,'numrefsTotal'=>$numrefsTotal,
                 'numrefsRepeat'=>$numrefsRepeat, 'numrefsNoRepeat'=>$numrefsNoRepeat, 'bibTexRepeat'=>$repeat));


}

} // Class


