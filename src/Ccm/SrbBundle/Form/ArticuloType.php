<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;

class ArticuloType extends AbstractType
{

 public function buildForm(FormBuilder $builder, array $options)
 {
   $builder
   ->add('author','text', array('required'=> true, 'label'=>'*Author'))
   ->add('title','textarea', array ('required'=>true , 'label'=>'*Title'))
   ->add('type', 'choice', array('choices'=>array('article'=>'Article')))
   ->add('yearPub','number', array ('required'=> true , 'label'=>'*Year'))
   ->add('journal', 'text', array('required' => true, 'label'=>'*Journal'))
   ->add('issue', 'text', array('required' => false, 'label'=>'Number'))
   ->add('pages', 'text', array('required' => false))
   ->add('volume', 'text', array('required' => false))
   ->add('keywords', 'textarea', array('required' => false))
   ->add('notas', 'textarea', array('required' => false, 'label'=>'Notes'))
   ->add('abst', 'textarea', array('required' => false, 'label'=>'Abstract'))
   ->add('issn', 'text', array('required' => false, 'label'=>'ISSN'))
   ->add('url', 'text', array('required' => false))
   ->add('doi', 'text', array('required' => false, 'label'=>'DOI'))
   ->add('arxiv', 'text', array('required' => false, 'label'=>'arXiv'))
   ->add('mrNumber', 'text', array('required' => false, 'label'=>'MR Number'))
   ->add('msc', 'textarea', array('required' => false, 'label'=>'MSC'))
   ->add('zmath', 'text', array('required' => false, 'label'=>'Zbl Number'))
   ->add('revision', 'checkbox', array('label' => 'Aprobación','required'  => false))
   ->add('file', 'file', array('required' => false, 'data_class' => null))


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
    return 'ccm_srbbundle_articulotype';
 }
}