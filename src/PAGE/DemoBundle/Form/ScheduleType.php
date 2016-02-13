<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScheduleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day','choice', array(
                'choices' => $this->getDay(),
                'placeholder' => 'Choose your day',
            ))
            ->add('block','choice', array(
                'choices' => $this->getBlock(),
                'placeholder' => 'Choose your block',
            ))
            ->add('teacher','entity', array('class' => 'PAGEDemoBundle:Teacher','property' => 'rut'))
            ->add('level','entity', array('class' => 'PAGEDemoBundle:Level','property' => 'name'))
            ->add('subject','entity', array('class' => 'PAGEDemoBundle:Subject','property' => 'name'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PAGE\DemoBundle\Entity\Schedule'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'schedule';
    }

    /**
     * @return array
     */
    public function getDay()
    {
        $list = array(
            'lunes'=>'Lunes','martes'=>'Martes',
            'miercoles'=>'Miércoles','jueves'=>'Jueves','viernes'=>'Viernes',
            'sabado'=>'Sábado');
        return $list;
    }

    /**
     * @return array
     */
    public function getBlock()
    {
        $list = array();
        for($i=1; $i <= 20; $i++) {
           array_push($list, $i);
        }
        return array_combine($list,$list);
    }
}
