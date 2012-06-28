<?php
//Formulario usado de Unpublished a cualquier otro tipo de publicación
namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EditPreprintType extends AbstractType
{
 public function buildForm(FormBuilder $builder, array $options)
 {
  $builder
  ->add('author', 'text', array('required' => true, 'label'=>'*Author'))
  ->add('title', 'textarea', array('required' => true, 'label'=>'*Title'))
  ->add('type', 'choice', array('choices'=>array('unpublished'=>'Unpublished', 'article'=>'Article', 'incollection'=>'Incollection', 'proceedings'=>'Proceedings', 'book'=>'Book', 'inproceedings'=>'Inproceedings')))
  ->add('yearPreprint','number', array('required' => true,'label'=>'Year End'))
  ->add('keywords', 'textarea', array('required' => false,'label'=>'Keywords'))
  ->add('notas', 'textarea', array('required' => false,'label'=>'Notes'))
  ->add('abst', 'textarea', array('required' => false,'label'=>'Abstract'))
  ->add('arxiv', 'text', array('required' => false,'label'=>'ArXiv'))
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
        return 'ccm_srbbundle_preprinttype';
 }
}
