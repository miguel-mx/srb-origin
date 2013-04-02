<?php

namespace Ccm\SrbBundle\Form;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class UploadFile
{

    protected $files_dir = '/var/www/web/SRB/web/uploads/files';

    public function getUploadDir()
    {
        return $this->files_dir;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return string
     */
    public function generateFileName(UploadedFile $file)
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
