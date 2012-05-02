<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EditorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
	->add('editor','text', array('required'=>true,'label'=>'*Editor'))
        ->add('title', 'textarea',array('required'=>true, 'label'=>'*Title'))
        ->add('type', 'choice', array('choices'=>array('proceedings'=>'Proceedings')))
	->add('yearPub', 'number', array('required'=>true,'label'=>'*Year'))
	->add('publisher','text', array('required'=>true,'label'=>'*Publisher'))
	->add('volume', 'text', array('required' => false,'label'=>'Volume'))
	->add('address', 'text', array('required'=>false, 'label'=>'Address'))
	->add('notas', 'textarea', array('required'=>false, 'label'=>'Notes'))
	->add('keywords', 'textarea', array('required'=>false, 'label'=>'Keywords'))
	
        ;
    }

   public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ccm\SrbBundle\Entity\Referencia',
        );
    }
    public function getName()
    {
        return 'ccm_srbbundle_editortype';
    }
}
