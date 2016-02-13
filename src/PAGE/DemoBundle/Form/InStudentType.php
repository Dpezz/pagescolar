<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PAGE\DemoBundle\Controller\LoadController;

class InStudentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level','entity', array('class' => 'PAGEDemoBundle:Level','property' => 'name'))
            ->add('origin')
            ->add('documents', 'choice', array(
                'choices' => $this->getDocument(),
                'multiple' => true,
                'expanded'=> true,
            ))
            ->add('programs', 'choice', array(
                'choices' => $this->getProgram(),
                'multiple' => true,
                'expanded'=> true
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
            'data_class' => 'PAGE\DemoBundle\Entity\InStudent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'in_student';
    }

    /**
     * @return array()
     */
    private function getDocument(){
        $load = new LoadController();
        $list = explode(',', $load->documentosAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getProgram(){
        $load = new LoadController();
        $list = explode(',', $load->programasAction());
        return array_combine($list,$list);
    }
}
