<?php

namespace Ccm\SrbBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ccm\SrbBundle\Util;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ccm\SrbBundle\Util\Structures_BibTex;
use Ccm\SrbBundle\Util\PEAR;
use Ccm\SrbBundle\Util\SimplePie\SimplePie;
use Ccm\SrbBundle\Form\Upload;
use Ccm\SrbBundle\Form\Urls;
use Ccm\SrbBundle\Form\UrlType;
use Ccm\SrbBundle\Form\UploadType;
use Ccm\SrbBundle\Form\EditType;
use Ccm\SrbBundle\Entity\Referencia;




class FileController extends BaseController
{
    
  
    /**
     * Carga archivo en formato BibTex
     * @Route("/upload", name="upload")
     * @Template()
     */
    public function indexAction()
{
    $upload = new Upload();
    $form = $this->createForm(new UploadType(), $upload);
    $request = $this->container->get('request');

    if ('POST' === $request->getMethod()) {
        $form->bindRequest($request);
        if ($form->isValid()) {
            $file = $form['attachment']->getData();
		    $randomName= $upload->generateRandomFileName($file);
            if ($file) {
                $file->move($upload->getUploadDir(), $randomName);
            }
	//$ret = $upload->dummySend();

        // upload->bibTex regresa una estructura de Bibtex
		$bibTex = $upload->bibTex($randomName);
	$numrefs=count($bibTex);
        // ******************************
        // Guarda las referencias
        $this->persistBibStructure($bibTex);

        // ******************************
        // Muestra las referencias leídas
        return $this->render('CcmSrbBundle:Refs:confirm.html.twig', array('bibTex' => $bibTex,'numrefs'=>$numrefs));

	    // $this->get('session')->setFlash('notice', $randomName);
        // return $this->render('CcmSrbBundle::upload.html.twig', array('refs'=>$refs, ));

        } // Is valid

      }

        return $this->render('CcmSrbBundle::upload.html.twig', array(
            'form' => $form->createView(),
        ));

}


} // Class


  