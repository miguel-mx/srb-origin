<?php

namespace Ccm\SrbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser as Parser;

class DocController extends Controller
{
    /**
     * @Route("/doc/{file}", defaults={"file" = "index.markdown"}, name="doc")
     * @Template()
     */
    public function indexAction($file)
    {
        $parser = new Parser();

        $text = file_get_contents('bundles/ccmsrb/md/'.$file);

        $html = $parser->transform($text);

        return $this->render('CcmSrbBundle:Doc:index.html.twig', array('html'=>$html));
    }
}
