<?php

namespace Ccm\SrbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class BusquedaType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {

      $years = array('choices' => array(
          '2013' => '2013',
          '2012' => '2012',
          '2011' => '2011',
          '2010' => '2010',
          '2009' => '2009',
          '2008' => '2008',
          '2007' => '2007',
          '2006' => '2006',
          '2005' => '2005',
          '2004' => '2004',
          '2003' => '2003',
          '2002' => '2002',
          '2001' => '2001',
          '2000' => '2000',
          '1999' => '1999',
                                       ));

       $type = array('choices' => array(
                    'all' => 'Todos',
                    'article' => 'Article',
                    'incollection' => 'Incollection',
                    'proceedings' => 'Proceedings',
                    'book' => 'Book',
                    'inproceedings' => 'Inproceedings',
                    'unpublished' => 'Unpublished',
                                       ));

        $builder
            ->add('Title', 'text', array('required'  => false))
            ->add('Type', 'choice', $type)
            ->add('Author', 'entity', array('class' => 'CcmSrbBundle:User'))
            ->add('yearStart','choice', $years)
            ->add('yearEnd','choice', $years)
            ->add('allYears','checkbox', array(
                  'label'     => '¿Mostrar todos los años? ',
                  'required'  => false
                  ));
    }

   public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ccm\SrbBundle\Entity\Referencia',
        );
    }
    public function getName()
    {
        return 'ccm_srbbundle_busquedatype';
    }
}
