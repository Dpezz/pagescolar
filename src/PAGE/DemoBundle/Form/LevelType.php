<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PAGE\DemoBundle\Controller\LoadController;

class LevelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','choice', array(
                'choices' => $this->getCursos(),
                'placeholder' => 'Choose your name',
            ))
            ->add('position','choice', array(
                'choices' => $this->getIndices(),
                'placeholder' => 'Choose your indice',
            ))  
            ->add('user','entity', array('class' => 'PAGEDemoBundle:User','property' => 'username'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PAGE\DemoBundle\Entity\Level'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'level';
    }

    /**
     * @return array()
     */
    private function getCursos(){
        $load = new LoadController();
        $list = explode(',', $load->cursosAction());
        return array_combine($list,$list);
    }

    /**
     * @return array()
     */
    private function getIndices(){
        $load = new LoadController();
        $list = explode(',', $load->indicesAction());
        return array_combine($list,$list);
    }
}
