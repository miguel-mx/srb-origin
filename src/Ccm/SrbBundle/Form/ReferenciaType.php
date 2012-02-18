<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ReferenciaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        ->add('author','text')
        ->add('title', 'text')
        ->add('type', 'choice', array('empty_value' => 'Choose an option','choices'=>array('articulo'=>'articulo','preprint'=>'Preprint','memoria'=>'Memoria de Congreso','libro'=>'Libro','edicion'=>'Edicion de Libro','editor'=>'Editor de Memorias de Congreso','capitulo'=>'Capitulo de Libro')))
     //   ->add('yearPub','date',array('empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'), 'years'=> range(1950,2012)))
//	->add('yearPreprint','date',array('empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'), 'years'=> range(1950,2012)))
        ->add('publication', 'text', array('required' => false))
        ->add('journal', 'text', array('required' => false))
	->add('issue')
	->add('pages')
	->add('corporateAuthor','text')
	->add('thesis')
	->add('address')
	->add('keywords')
	->add('abst','textarea')
	->add('publisher')
	->add('placePub')
	->add('editor')
	->add('issn')
	->add('isbn')
	->add('medium')
	->add('area')
	->add('conference')
	->add('notas')
	->add('revision')
	->add('file')
	->add('url')
	->add('doi')
	->add('arxiv')
	->add('mathscinet')
	->add('zmath')
	->add('inspires')
	
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
