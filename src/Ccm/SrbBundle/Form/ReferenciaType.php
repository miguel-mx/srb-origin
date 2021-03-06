<?php
//Formulario que contiene todos los campos de una referencia
//es usado cuando no se sabe con que tipo de referencia se esta tratando
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
            ->add('type', 'choice', array('choices'=>array('empty_value' => 'Choose an option','preprint'=>'Preprint',
                                                                                               'article'=>'Article',
                                                                                               'incollection'=>'Incollection',
                                                                                               'proceedings'=>'Proceedings',
                                                                                               'book'=>'Book',
                                                                                               'inproceedings'=>'Inproceedings')))
            ->add('publication', 'text', array('required' => false))
            ->add('journal', 'text', array('required' => false))
            ->add('issue')
            ->add('pages')
            ->add('corporateAuthor','text', array('required' => false))
            ->add('school')
            ->add('address')
            ->add('keywords')
            ->add('abst','textarea',array('required' => false))
            ->add('publisher')
            ->add('placePub')
            ->add('editor')
            ->add('issn')
            ->add('isbn')
            ->add('medium')
            ->add('advisor')
            ->add('thesisType')
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
