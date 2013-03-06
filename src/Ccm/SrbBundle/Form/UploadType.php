<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UploadType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('attachment', 'file', array('required' => false, 'label' => 'Archivo:'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ccm\SrbBundle\Form\Upload',
        );
    }

    public function getName()
    {
        return 'upload';
    }
}

