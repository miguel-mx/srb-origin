<?php
//Formulario para Book
namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LibroType extends AbstractType
{
 public function buildForm(FormBuilder $builder, array $options)
 {
  $builder
  ->add('author','text', array('required'=>false,'label'=>'Author'))
  ->add('title', 'textarea',  array('required'=>true,'label'=>'*Title'))
  ->add('type', 'choice', array('choices'=>array('book'=>'Book')))
  ->add('yearPub','text', array('required'=>true,'label'=>'*Year'))
  ->add('keywords', 'textarea', array('required' => false))
  ->add('publisher', 'text', array('required'=>true, 'label'=>'*Publisher'))
  ->add('isbn', 'text', array('required' => false))
  ->add('editor','text', array('required'=>false,'label'=>'Editor'))
  ->add('notas', 'textarea', array('required' => false,'label'=>'Notes'))
  ->add('address', 'text', array('required' => false))
  ->add('doi', 'text', array('required' => false))
  ->add('arxiv', 'text', array('required' => false))
  ->add('url', 'text', array('required' => false))
  ->add('mrNumber', 'text', array('required' => false, 'label'=>'MR Number'))
  ->add('zmath', 'text', array('required' => false, 'label'=>'Zbl Number'))
  ->add('msc', 'text', array('required'=>false, 'label'=>'MSC'))
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
   return 'ccm_srbbundle_librotype';
 }
}
