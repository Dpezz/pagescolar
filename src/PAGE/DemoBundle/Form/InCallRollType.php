<?php

namespace PAGE\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InCallRollType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason')
            ->add('callroll','entity', array('class' => 'PAGEDemoBundle:CallRoll','property' => 'id'))
            ->add('student','entity', array('class' => 'PAGEDemoBundle:Student','property' => 'rut'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PAGE\DemoBundle\Entity\InCallRoll'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'in_callroll';
    }
}
