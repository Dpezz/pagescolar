<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PAGE\DemoBundle\Controller\LoadController;

class SubjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','choice', array(
                'choices' => $this->getAsignaturas(),
                'placeholder' => 'Choose your name',
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
            'data_class' => 'PAGE\DemoBundle\Entity\Subject'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'subject';
    }

    /**
     * @return array()
     */
    private function getAsignaturas(){
        $load = new LoadController();
        $list = explode('-', $load->asignaturasAction());
        return array_combine($list,$list);
    }
}
