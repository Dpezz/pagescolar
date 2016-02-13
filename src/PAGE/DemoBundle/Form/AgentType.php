<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PAGE\DemoBundle\Controller\LoadController;

class AgentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rut')
            ->add('relation','choice', array(
                'choices' => $this->getRelation(),
                'placeholder' => 'Choose your relation',
            ))
            ->add('name')
            ->add('lastname')
            ->add('address')
            ->add('area','choice', array(
                'choices' => $this->getArea(),
                'placeholder' => 'Choose your area',
            ))
            ->add('commune')
            ->add('phone')
            ->add('email')
            ->add('level','choice', array(
                'choices' => $this->getLevel(),
                'placeholder' => 'Choose your level',
            ))
            ->add('live','choice', array(
                'choices' => array('si'=>'Si','no'=>'No'),
                'placeholder' => 'Choose your live',
            ))
            ->add('school','choice', array(
                'choices' => $this->getSchool(),
                'placeholder' => 'Choose your school',
            ))
            ->add('student','entity', array('class' => 'PAGEDemoBundle:Student','property' => 'rut'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PAGE\DemoBundle\Entity\Agent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agent';
    }

    /**
     * @return array()
     */
    private function getRelation(){
        $load = new LoadController();
        $list = explode(',', $load->parentescoAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getArea(){
        $load = new LoadController();
        $list = explode(',', $load->regionAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getLevel(){
        $load = new LoadController();
        $list = explode(',', $load->nivelAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getSchool(){
        $load = new LoadController();
        $list = explode(',', $load->escolaridadAction());
        return array_combine($list,$list);
    }

}
