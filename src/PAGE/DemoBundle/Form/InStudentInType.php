<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PAGE\DemoBundle\Controller\LoadController;

class InStudentInType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('basic', 'choice', array(
                'choices' => $this->getBasic(),
                'multiple' => true,
                'expanded'=> true,
            ))
            ->add('studio', 'choice', array(
                'choices' => $this->getStudio(),
                'multiple' => true,
                'expanded'=> true,
            ))
            ->add('know', 'choice', array(
                'choices' => $this->getKnow(),
                'multiple' => true,
                'expanded'=> true,
            ))
            ->add('other')
            ->add('student','entity', array('class' => 'PAGEDemoBundle:Student','property' => 'rut'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PAGE\DemoBundle\Entity\InStudentIn'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'in_student_in';
    }

    /**
     * @return array()
     */
    private function getBasic(){
        $load = new LoadController();
        $list = explode(',', $load->basicoAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getStudio(){
        $load = new LoadController();
        $list = explode(',', $load->tallerAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getKnow(){
        $load = new LoadController();
        $list = explode(',', $load->reforzamientoAction());
        return array_combine($list,$list);
    }
}
