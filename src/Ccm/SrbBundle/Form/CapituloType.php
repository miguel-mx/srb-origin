<?php
//Formulario para Incollection
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
            ->add('yearPub','text', array('required' => true, 'label'=>'*Year'))
            ->add('publisher', 'text', array('required' => true, 'label'=>'*Publisher'))
            ->add('editor', 'text', array('required' => false, 'label'=>'Editor'))
            ->add('volume', 'text', array('required' => false, 'label'=>'Volume'))
            ->add('bookTitle', 'textarea', array('required' => true, 'label'=>'*Book Title'))
            ->add('pages', 'text', array('required' => false))
            ->add('address', 'text', array('required' => false))
            ->add('notas', 'textarea', array('required' => false))
            ->add('keywords', 'textarea', array('required' => false))
            ->add('doi', 'text', array('required' => false, 'label'=>'DOI'))
            ->add('arxiv', 'text', array('required' => false, 'label'=>'arXiv'))
            ->add('url', 'text', array('required' => false))
            ->add('mrNumber', 'text', array('required' => false, 'label'=>'MR Number'))
            ->add('zmath', 'text', array('required' => false, 'label'=>'Zbl Number'))
            ->add('msc', 'textarea', array('required' => false, 'label'=>'MSC'))
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
        return 'ccm_srbbundle_referenciatype';
    }
}
