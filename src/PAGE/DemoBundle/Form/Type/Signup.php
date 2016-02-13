<?php
namespace PAGE\DemoBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class Signup extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username','text')
        ->add('phone','number')
        ->add('email', 'repeated', array( 'type' => 'email', 'invalid_message' => 'Email do not match' ) )
        ->add('password', 'repeated', array( 'type' => 'password', 'invalid_message' => 'Passwords do not match' ) )
        ->add('save', 'submit');
    }
 
    public function getName()
    {
        return 'user';
    }
}