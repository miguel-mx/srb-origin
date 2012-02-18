<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EditorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
	->add('author','text')
        ->add('title', 'text')
        ->add('type', 'choice', array('choices'=>array('editor'=>'Proceedings')))
	//->add('yearPub','date',array('empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'), 'years'=> range(1950,2012)))
	->add('yearPub','text')
	->add('pages', 'text', array('required' => false))
	->add('publisher')
	->add('placePub')
	
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
