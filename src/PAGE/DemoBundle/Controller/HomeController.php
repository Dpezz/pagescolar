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
use Ps\PdfBundle\Annotation\Pdf;
use PAGE\DemoBundle\Form\Type\Signup;
use PAGE\DemoBundle\Entity\User;


class HomeController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        if($request->getSession()->get('username'))
        {return new RedirectResponse($this->generateUrl('profile'));}
        return array();
    }

    /**
     * @Route("/signin", name="signin")
     * @Template()
     */
    public function signinAction(Request $request)
    {
        if($request->getSession()->get('username'))
        {return new RedirectResponse($this->generateUrl('profile'));}

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        return array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }

    /**
     * @Route("/signup", name="signup")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function signupAction(Request $request)
    {
        if($request->getSession()->get('username'))
        {return new RedirectResponse($this->generateUrl('profile'));}

        $user = new User();
        $form = $this->createForm(new Signup(), $user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user -> setCreateAt(new \DateTime('now'));
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('index'));
        }
        return array('form' => $form->createView() );
    }

    private function createTables($id){
        try{
            $dataI = new DatosInstitucion();
            $dataI->setId($id);

            $em = $this->getDoctrine()->getManager();
            $em->persist($dataI);
            $em->flush();

            return true;
        }catch(Exception $e){
            return false;
        }
    }

    private function createFolder($id){
        $ruta = 'users/'.$id;
        if(!file_exists($ruta)){
            mkdir($ruta,0755);
            mkdir($ruta.'/documents',0755);
            mkdir($ruta.'/images',0755);
            return true;
        }
        return false;
    }

    private function emailUser($name, $email){
        $message = \Swift_Message::newInstance()
        ->setSubject('Pagescolar - Registrado Exitosamente')
        ->setFrom('contacto@pagescolar.cl')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                'PAGEDemoBundle:Email:email_signup.html.twig',
                array('name'=> $name)
            ),'text/html'
        );
        $this->get('mailer')->send($message);
    }

    private function emailAdmin($name,$email,$fono){
        $message = \Swift_Message::newInstance()
        ->setSubject('Pagescolar - Notificación')
        ->setFrom('contacto@pagescolar.cl')
        ->setTo('contacto@pagescolar.cl')
        ->setBody(
            $this->renderView(
                'PAGEDemoBundle:Email:email_admin.html.twig',
                array('name'=> $name,'email'=>$email,'fono'=>$fono)
            ),'text/html'
        );
        $this->get('mailer')->send($message);
    }

    /**
     * @Route("/profile/login_check", name="security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/profile/logout", name="logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }

}
