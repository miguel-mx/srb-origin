<?php
//Formulario para Inproceedings
namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MemoriaType extends AbstractType
{
 public function buildForm(FormBuilder $builder, array $options)
 {
  $builder
  ->add('author','text', array('required'=>true,'label'=>'*Author'))
  ->add('title', 'textarea', array('required'=>true,'label'=>'*Title'))
  ->add('type', 'choice', array('choices'=>array('inproceedings'=>'Inproceedings')))
  ->add('yearPub','text', array('required'=>true,'label'=>'*Year'))
  ->add('pages', 'text', array('required'=>false,'label'=>'Pages'))
  ->add('issue', 'text', array('required'=>false,'label'=>'Issue'))
  ->add('volume', 'text', array('required'=>false,'label'=>'Volume'))
  ->add('journal', 'text', array('required'=>false,'label'=>'Journal'))
  ->add('address', 'text',array('required'=>false,'label'=>'Address'))
  ->add('notas', 'textarea', array('required'=>false,'label'=>'Notes'))
  ->add('keywords', 'textarea' , array('required'=>false,'label'=>'Keywords'))
  ->add('publisher', 'text', array('required'=>false,'label'=>'Publisher'))
  ->add('revision', 'checkbox', array('label' => 'Aprobación','required'  => false))

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
    return 'ccm_srbbundle_memoriatype';
 }
}
