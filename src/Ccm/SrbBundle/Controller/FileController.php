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

                // upload->bibTex regresa una estructura de Bibtex
                $bibTex = $upload->bibTex($randomName);

                //if ($bibTex) {
                //  throw $this->createNotFoundException(print_r($bibTex));
                //}


                $repository = $this->getDoctrine()->getRepository('CcmSrbBundle:Referencia');
                $j=0;
                $k=0;
                $norepeat=null;
                $repeat=null;


                for($i=0;$i<count($bibTex);$i++){
                    $titles= $repository->findOneByTitle(preg_replace("'\s+'",' ', $bibTex[$i]['title']));
                    if ($titles){
                        $repeat[$k]=$bibTex[$i];
                        $k++;
                        unset($titles);
                    }
                    else {
                        $norepeat[$j]=$bibTex[$i];
                        $j++;
                    }
                }

                $numrefsTotal=count($repeat)+count($norepeat);
                $numrefsRepeat= count($repeat);
                $numrefsNoRepeat= count($norepeat);

                // ******************************
                // Guarda las referencias
                $this->persistBibStructure($norepeat);

                // ******************************
                // Muestra las referencias leídas
                return $this->render('CcmSrbBundle:Refs:confirm.html.twig', array('bibTex' => $norepeat,'numrefsTotal'=>$numrefsTotal,
                    'numrefsRepeat'=>$numrefsRepeat, 'numrefsNoRepeat'=>$numrefsNoRepeat, 'bibTexRepeat'=>$repeat));

                // $this->get('session')->setFlash('notice', $randomName);
                // return $this->render('CcmSrbBundle::upload.html.twig', array('refs'=>$refs, ));

            } // Is valid

        }

        return $this->render('CcmSrbBundle::upload.html.twig', array(
            'form' => $form->createView(),
        ));

    }


} // Class

