<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PAGE\DemoBundle\Controller\LoadController;

class TestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('period')
            ->add('title')
            ->add('system','choice', array(
                'choices' => $this->getSistema(),
                'placeholder' => 'Choose your system',
            ))
            ->add('date')
            ->add('moment','choice', array(
                'choices' => $this->getMomento(),
                'placeholder' => 'Choose your system',
            ))
            ->add('evaluator','choice', array(
                'choices' => $this->getEvaluador(),
                'placeholder' => 'Choose your evaluator',
            ))
            ->add('assess','choice', array(
                'choices' => $this->getEvalua(),
                'placeholder' => 'Choose your assess',
            ))
            ->add('value_teacher','choice', array(
                'choices' => $this->getEvaluacionDocente(),
                'placeholder' => 'Choose your value_teacher',
            ))
            ->add('finality','choice', array(
                'choices' => $this->getFinalidad(),
                'placeholder' => 'Choose your finality',
            ))
            ->add('instrument','choice', array(
                'choices' => $this->getInstrument(),
                'placeholder' => 'Choose your instrument',
            ))
            ->add('learning','choice', array(
                'choices' => $this->getAprendizaje(),
                'placeholder' => 'Choose your learning',
            ))
            ->add('user','entity', array('class' => 'PAGEDemoBundle:User','property' => 'username'))
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
            'data_class' => 'PAGE\DemoBundle\Entity\Test'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'test';
    }

    /**
     * @return array()
     */
    private function getMomento(){
        $load = new LoadController();
        $list = explode(',', $load->momentoAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getSistema(){
        $load = new LoadController();
        $list = explode(',', $load->sistemaAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getEvaluador(){
        $load = new LoadController();
        $list = explode(',', $load->evaluadorAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getEvalua(){
        $load = new LoadController();
        $list = explode(',', $load->evaluaAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getEvaluacionDocente(){
        $load = new LoadController();
        $list = explode(',', $load->evaluacionDAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getFinalidad(){
        $load = new LoadController();
        $list = explode(',', $load->finalidadAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getInstrument(){
        $load = new LoadController();
        $list = explode(',', $load->instrumentoAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getAprendizaje(){
        $load = new LoadController();
        $list = explode(',', $load->aprendizajeAction());
        return array_combine($list,$list);
    }
}
