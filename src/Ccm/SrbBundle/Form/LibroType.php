<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LibroType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        ->add('author','text', array('required'=>true))
        ->add('title', 'text',  array('required'=>true))
        ->add('type', 'choice', array('choices'=>array('libro'=>'Libro')))
        //->add('yearPub','date',array('empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'), 'years'=> range(1950,2012)))
	->add('yearPub','text', array('required'=>true))
	//->add('pages', 'text', array('required' => false))
	//->add('address', 'text', array('required' => false))
	//->add('keywords', 'text', array('required' => false))
	->add('publisher', 'text', array('required'=>true))
	->add('isbn', 'text', array('required' => false))
	//->add('editor')
	//->add('notas', 'text', array('required' => false))
	
	
	
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
        return 'ccm_srbbundle_librotype';
    }
}
