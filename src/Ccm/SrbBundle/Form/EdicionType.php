<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EdicionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
	//->add('author')
	->add('editor', 'text', array('required'=>true))
        ->add('title', 'text', array('required'=>true))
        ->add('type', 'choice', array('choices'=>array('edicion'=>'Edicion')))
        //->add('yearPub','date',array('empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'), 'years'=> range(1950,2012)))
	->add('yearPub','text', array('required'=>true))
	->add('conference','text', array('required'=>true))
	->add('pages', 'number', array ('required'=>true))
	->add('publisher', 'text', array('required'=>true))
	->add('placePub', 'text', array('required'=>true))
	//->add('isbn', 'text', array('required' => false))
	
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
        return 'ccm_srbbundle_ediciontype';
    }
}
