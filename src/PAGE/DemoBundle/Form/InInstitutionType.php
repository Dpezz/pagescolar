<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PAGE\DemoBundle\Controller\LoadController;

class InInstitutionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('period','choice', array(
                'choices' => $this->getJornada(),
                'placeholder' => 'Choose your jornada',
            ))  
            ->add('mode','choice', array(
                'choices' => $this->getModalidad(),
                'placeholder' => 'Choose your modalidad',
            ))
            ->add('regime','choice', array(
                'choices' => $this->getRegimen(),
                'placeholder' => 'Choose your regimen',
            ))
            ->add('date_start')
            ->add('date_end')
            ->add('institution','entity', array('class' => 'PAGEDemoBundle:Institution','property' => 'rbd'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PAGE\DemoBundle\Entity\InInstitution'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'in_institution';
    }

    /**
     * @return array()
     */
    private function getJornada(){
        $load = new LoadController();
        $list = explode(',', $load->jornadaAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getModalidad(){
        $load = new LoadController();
        $list = explode(',', $load->modalidadAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getRegimen(){
        $load = new LoadController();
        $list = explode(',', $load->regimenAction());
        return array_combine($list,$list);
    }
}
