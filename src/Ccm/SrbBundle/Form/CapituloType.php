<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CapituloType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        ->add('author','text')
        ->add('title', 'text')
        ->add('type', 'choice', array('choices'=>array('inbook'=>'Inbook')))
        //->add('yearPub','date',array('empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'), 'years'=> range(1950,2012)))
	->add('yearPub','text')
	->add('publication', 'text', array('required' => false))
        ->add('journal', 'text', array('required' => false))
	->add('publisher')
	->add('placePub')
	->add('editor')
	->add('isbn', 'text', array('required' => false))
	
	
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
        return 'ccm_srbbundle_referenciatype';
    }
}
