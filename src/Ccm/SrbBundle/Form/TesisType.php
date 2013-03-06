<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;

class TesisType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('author','text', array('required'=> true, 'label'=>'*Author'))
            ->add('advisor','text', array('required'=> true, 'label'=>'*Advisor'))
            ->add('title','textarea', array ('required'=>true, 'label'=>'*Title'))
            ->add('type', 'choice', array('choices'=>array('thesis'=>'Thesis')))
            ->add('yearPub','number', array ('required'=> true, 'label'=>'*Year'))
            ->add('school', 'text', array('required' => true, 'label'=>'*School'))
            ->add('thesisType', 'choice', array('required' => false, 'label'=>'Grade', 'empty_value'=>'Choose an option',
                                                'choices'=>array('licenciatura'=>'Licenciatura',
                                                                 'maestria'=>'Maestría',
                                                                 'doctorado'=>'Doctorado')))
            ->add('keywords', 'textarea', array('required' => false))
            ->add('notas', 'textarea', array('required' => false, 'label'=>'Notes'))
            ->add('url', 'text', array('required' => false))
            ->add('file', 'file', array('required' => false, 'data_class' => null))
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
        return 'ccm_srbbundle_tesistype';
    }
}