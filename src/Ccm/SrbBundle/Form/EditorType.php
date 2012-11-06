<?php
//Formulario para Proceedings
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
  ->add('journal', 'text', array('required'=>false))
  ->add('issue', 'text', array('required'=>false, 'label'=>'Number'))
  ->add('notas', 'textarea', array('required'=>false, 'label'=>'Notes'))
  ->add('doi', 'text', array('required' => false, 'label'=>'DOI'))
  ->add('url', 'text', array('required'=>false))
  ->add('mrNumber', 'text', array('required'=>false, 'label'=>'MR Number'))
  ->add('zmath', 'text', array('required'=>false, 'label'=>'Zbl Number'))
  ->add('msc', 'textarea', array('required'=>false, 'label'=>'MSC'))
  ->add('keywords', 'textarea', array('required'=>false, 'label'=>'Keywords'))
  ->add('revision', 'checkbox', array('label' => 'Aprobación','required'=> false))
  ->add('issn', 'text', array('required' => false, 'label'=>'ISSN'))
  ->add('pages', 'text', array('required' => false))



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