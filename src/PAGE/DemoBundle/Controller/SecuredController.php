<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

use PAGE\DemoBundle\Entity\User;


class SecuredController extends Controller
{
    /**
    * @Route("/profile/account", name="_profile_secured_account")
    * @Method("GET")
    * @Template()
    */
    public function accountAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        //Cargar Datos Personales Usuario
        $id = $this->getUser() -> getId();
        $personal = $this->getDoctrine()->getRepository('PAGEDemoBundle:User')->find($id);

        return array(
            'flag' => $flag,
            'dataU' => $personal
        );
    }

    /**
     * @Route("/profile/password", name="_profile_secured_password")
     * @Method("GET")
     * @Template()
     */
    public function passwordAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);
    	
        return array(
            'flag' => $flag
        );
    }

    /**
     * @Route("/resend", name="_secured_resend")
     * @Route("/profile/resend", name="_profile_secured_resend")
     * @Method("GET")
     * @Template()
     */
    public function resendAction(Request $request){
        if($request->getSession()->get('flag')){
            //Asignar el FLAG
            $flag = $request->getSession()->get('flag');
            $request->getSession()->set('flag',-1);
                return array( 'flag' => $flag);
        }else
            return $this->render('PAGEDemoBundle:Secured:resendPublic.html.twig');
    }


    /**
     * @Route("/restore/{codigo}", name="_secured_restore")
     * @Template()
     */
    public function restoreAction($codigo, Request $request){
        $flag = -1;
        if ($request->isMethod('POST')){
            try{
                $email_url = $codigo;
                $email = $request->get('email');
                if(password_verify($email, $email_url))
                {
                    $em = $this->getDoctrine()->getManager();
                    if($user = $em->getRepository('PAGEDemoBundle:User')->findOneByEmail($email))
                    {
                        $user->setPassword($request->get('password'));
                        $em->flush();
                        //Se envia correo Informando del cambio de Contraseña
                        $this->sendEmail($email,$email);

                        $flag = 21;
                    }else{
                        $flag = 22;
                    }
                }else{
                    $flag = 22;
                }
            }catch(Exception $e){
                $flag = 0;
            }

            return $this->render('PAGEDemoBundle:Default:message.html.twig',array('flag'=>$flag,'type'=>2,'titulo'=>'Restablecer'));
        }

    	return array('flag'=>$flag, 'url'=>$codigo);
    }

/* POST */
    /**
    * @Route("/profile/account", name="_profile_secured_account_post")
    * @Template()
    * @Method("POST")
    */
    public function editAccountAction(Request $request){
        try{
            $id = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:User')->find($id))
            {
                $user->setUsername($request->get('username'));
                $user->setEmail($request->get('email'));
                $user->setFono($request->get('fono'));

                $em->flush();
                $request->getSession()->set('flag',1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }

        return new RedirectResponse($this->generateUrl('_profile_secured_account'));
    }

    /**
    * @Route("/profile/password", name="_profile_secured_password_post")
    * @Template()
    * @Method("POST")
    */
    public function editPasswordAction(Request $request){
        try{
            $id = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:User')->find($id))
            {
                $passwordActual = $request->get('password-actual');

                if(password_verify($passwordActual, $user->getPassword()))
                {
                    $user->setPassword($request->get('password'));
                    $em->flush();

                    //Se envia correo Informando del cambio de Contraseña
                    $this->sendEmail($this->getUser()->getUsername(),$this->getUser()->getEmail());

                    $request->getSession()->set('flag',1);
                }else{
                   $request->getSession()->set('flag',3);
                }
            }else{
               $request->getSession()->set('flag',0); 
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }

        return new RedirectResponse($this->generateUrl('_profile_secured_password'));
    }

    /**
    * @Route("/profile/resend", name="_profile_secured_resend_post")
    * @Template()
    * @Method("POST")
    */
    public function editResendAction(Request $request){
        try{
            $id = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:User')->find($id))
            {
                $email = $request->get('email');
                if($email == $user->getEmail()){
                    //generar codigo
                    $emailSecured =  password_hash( $user->getEmail(),PASSWORD_BCRYPT);
                    if(strpos($emailSecured,'/') !== false){
                        $exist= true;
                        while($exist){
                            $emailSecured =  password_hash( $email, PASSWORD_BCRYPT);
                            if(strpos($emailSecured,'/') === false){
                                //ya no se ecuentra
                                $exist =false;
                            }
                        }
                    }

                    //enviar codigo de activacion
                    $this->sendEmailResend($email,$emailSecured);
                    $request->getSession()->set('flag',11);
                }else{
                    $request->getSession()->set('flag',12);
                }
            }else{
                $request->getSession()->set('flag',12);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }

        return new RedirectResponse($this->generateUrl('_profile_secured_resend'));
    }

    /**
    * @Route("/resend", name="_secured_resend_post")
    * @Template()
    * @Method("POST")
    */
    public function editResendPublicAction(Request $request){
        $flag = -1;
        try{
            $email = $request->get('email');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:User')->findOneByEmail($email))
            {
                if($email == $user->getEmail()){
                    //generar codigo
                    $emailSecured =  password_hash( $user->getEmail(), PASSWORD_BCRYPT);
                    if(strpos($emailSecured,'/') !== false){
                        $exist= true;
                        while($exist){
                            $emailSecured =  password_hash( $email, PASSWORD_BCRYPT);
                            if(strpos($emailSecured,'/') === false){
                                //ya no se ecuentra
                                $exist =false;
                            }
                        }
                    }
                    //enviar codigo de activacion
                    $this->sendEmailResend($email,$emailSecured);

                    $flag = 11;
                }else{
                    $flag = 12;
                }
            }else{
                 $flag = 12;
            }
        }catch(Exception $e){
            $flag = 0;
        }
        return $this->render('PAGEDemoBundle:Default:message.html.twig',
                array('flag'=>$flag,'type'=>1,'titulo'=>'Solicitar')
        );
    }


    private function sendEmail($name, $email){
        $message = \Swift_Message::newInstance()
        ->setSubject('Pagescolar - Contraseña')
        ->setFrom('contacto@pagescolar.cl')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                'PAGEDemoBundle:Email:email_password.html.twig',
                array('name'=> $name,'email'=>$email)
            ),'text/html'
        );
        $this->get('mailer')->send($message);
    }

    private function sendEmailResend($email, $codigo){
        $message = \Swift_Message::newInstance()
        ->setSubject('Pagescolar - Restablecer Contraseña')
        ->setFrom('contacto@pagescolar.cl')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                'PAGEDemoBundle:Email:email_resend.html.twig',
                array('email'=>$email,'codigo'=>$codigo)
            ),'text/html'
        );
        $this->get('mailer')->send($message);
    }

}