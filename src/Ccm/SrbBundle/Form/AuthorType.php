<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', null, array('label'=>'Nombre'))
            ->add('alias', null, array('label'=>'Alias'))
//             ->add('publications')
        ;
    }

    public function getName()
    {
        return 'ccm_srbbundle_authortype';
    }
}
