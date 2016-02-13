<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PAGE\DemoBundle\Controller\LoadController;

class InTeacherType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('team','choice', array(
                'choices' => $this->getTeam(),
                'placeholder' => 'Choose your team',
            ))
            ->add('role','choice', array(
                'choices' => $this->getRole(),
                'placeholder' => 'Choose your role',
            ))
            ->add('level','choice', array(
                'choices' => $this->getLevel(),
                'placeholder' => 'Choose your level',
            ))
            ->add('subject','entity', array('class' => 'PAGEDemoBundle:Subject','property' => 'name'))
            ->add('certificate')
            ->add('teacher','entity', array('class' => 'PAGEDemoBundle:Teacher','property' => 'rut'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PAGE\DemoBundle\Entity\InTeacher'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'in_teacher';
    }
    
    /**
     * @return array()
     */
    private function getTeam(){
        $load = new LoadController();
        $list = explode(',', $load->grupoAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getRole(){
        $load = new LoadController();
        $list = explode(',', $load->funcionAction());
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
}
