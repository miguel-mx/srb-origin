<?php

namespace Ccm\SrbBundle\Form;
use Ccm\SrbBundle\Util;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ccm\SrbBundle\Util\Structures_BibTex;
use Ccm\SrbBundle\Util\PEAR;

class Upload
{


/**
* Attachment
*
* @var string
* @Assert\File(maxSize="2000000")
* @Assert\NotBlank(message="Es necesario seleccionar un archivo")
* @Assert\File(mimeTypes ={"text/plain", "text/x-c++"})
* @Assert\File(mimeTypesMessage={"Favor de seleccionar un archivo válido"})
*/
    protected $attachment;

    protected $upload_dir = '/var/www/srb/uploads';



    /**
* @return string
*/
    public function getAttachment()
    {
        return $this->attachment ?: 'nothing';
    }

    /**
* @param $attachment
*/
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    }

    public function getUploadDir()
    {
        return $this->upload_dir;
    }

/**
* Dummy function to do something in this model
*
* @return string
*/
    public function dummySend()
    {
	


        return sprintf('El archivo se cargo correctamente "%s"  .', $this->getAttachment()
		
        );
    }



/**
* @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
* @return string
*/
    public function generateRandomFileName(UploadedFile $file)
    {
        $extension = $file->guessExtension();
        if (!$extension) {
            // extension cannot be guessed
            $extension = 'bib';
        }
        $this->attachment = rand(1, 99).'-'.time().'.'.'bib';

        return $this->attachment;
    }

/**
* @param $file
* @return array
*/
	public function bibTex($file){
	$bibtex = new Structures_BibTex();
	
	
	//$ret    = $bibtex->loadFile('/var/www/srb/uploads/'.$file);
	$bibtex->loadFile('/var/www/srb/uploads/'.$file);
	$bibtex->parse();
	$data=$bibtex->data;
		//$this->get('session')->setFlash('notice', $bibarray);
		//return new Response('<html><body>'.print_r($bibtex->data).'</body></html>'); 
           // return $bibtex->data;
		return $data;

}




}


