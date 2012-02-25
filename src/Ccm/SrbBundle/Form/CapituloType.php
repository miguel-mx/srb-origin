<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CapituloType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        ->add('author','text', array('required' => true, 'label' => '*Author'))
        ->add('title', 'textarea', array('required' => true, 'label' => '*Title'))
        ->add('type', 'choice', array('choices'=>array('incollection'=>'Incollection')))
        ->add('yearPub','text', array('required' => true, 'label'=>'Year'))
	->add('publisher', 'text', array('required' => true, 'label'=>'Publisher'))
	->add('editor', 'text', array('required' => false, 'label'=>'Editor'))
	->add('volume', 'text', array('required' => false, 'label'=>'Volume'))
	->add('pages', 'text', array('required' => false))
	->add('address', 'text', array('required' => false))
	->add('notas', 'textarea', array('required' => false))
	->add('keywords', 'textarea', array('required' => false))
	
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
