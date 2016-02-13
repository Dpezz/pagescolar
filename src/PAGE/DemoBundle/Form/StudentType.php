<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PAGE\DemoBundle\Controller\LoadController;

class StudentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rut','text')
            ->add('name','text')
            ->add('lastname','text')
            ->add('mlastname','text')
            ->add('birthdate')
            ->add('sex','choice', array(
                'choices' => $this->getSex(),
                'placeholder' => 'Choose your sex',
            ))
            ->add('address','text')
            ->add('area','choice', array(
                'choices' => $this->getArea(),
                'placeholder' => 'Choose your area',
            ))
            ->add('commune','text')
            ->add('phone','number')
            ->add('email','email')
            ->add('etnia','choice', array(
                'choices' => $this->getEtnia(),
                'placeholder' => 'Choose your etnia',
            ))
            ->add('country','choice', array(
                'choices' => $this->getCountry(),
                'placeholder' => 'Choose your country',
            ))
            ->add('year_in','number')
            ->add('year_end','number')
            ->add('health')
            ->add('interest')
            ->add('record')
            ->add('user','entity', array('class' => 'PAGEDemoBundle:User','property' => 'username'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PAGE\DemoBundle\Entity\Student'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'student';
    }

    /**
     * @return array()
     */
    private function getSex(){
        $load = new LoadController();
        $list = explode(',', $load->sexoAction());
        return array_combine($list,$list);
    }
    
    /**
     * @return array()
     */
    private function getEtnia(){
        $load = new LoadController();
        $list = explode(',', $load->etniaAction());
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
    private function getCountry(){
        $load = new LoadController();
        $list = explode(',', $load->paisAction());
        return array_combine($list,$list);
    }
}
