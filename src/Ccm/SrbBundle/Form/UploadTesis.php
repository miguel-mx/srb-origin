<?php

namespace Ccm\SrbBundle\Form;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class UploadTesis
{

    protected $tesis_dir = '/var/www/srb/uploads/tesis';

    public function getUploadDir()
    {
        return $this->tesis_dir;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return string
     */
    public function generateTesisName(UploadedFile $file)
    {
        $extension = $file->guessExtension();
        if (!$extension) {
            // extension cannot be guessed
            $extension = 'pdf';
        }
        $this->file = rand(1, 99).'-'.time().'.'.'pdf';
        return $this->file;
    }
}
