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

use PAGE\DemoBundle\Entity\User;
use PAGE\DemoBundle\Entity\BaseCurricular;
use PAGE\DemoBundle\Entity\DatosInstitucion;


class DefaultController extends Controller
{

    /**
     * @Route("/", name="_demo_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/signin", name="_demo_signin")
     * @Template()
     */
    public function signinAction(Request $request)
    {
        //return $this->redirect($this->generateUrl('_demo_index'));
    
        if($request->getSession()->get('username'))
        {return new RedirectResponse($this->generateUrl('_demo_profile'));}

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
     * @Route("/signup", name="_demo_signup")
     * @Method("GET")
     * @Template()
     */
    public function signupAction(Request $request)
    {
        if($request->getSession()->get('username'))
        {return new RedirectResponse($this->generateUrl('_demo_profile'));}
    
        return array();
    }


/* POST */
    /**
     * @Route("/signup", name="_demo_new_acount")
     * @Method("POST")
     */
    public function newAcount(Request $request){
        $flag = 0;
        try{
            $email = $request->get('email');
            $em = $this->getDoctrine()->getManager();
            if(! $data = $em->getRepository('PAGEDemoBundle:User')->findBy(array('email'=>$email))){
                $user = new User();
                $id = $this->newId();

                $username = $request->get('username');
                $fono = $request->get('fono');

                $user->setId($id);
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setFono($fono);
                $user->setPassword($request->get('password'));

                $user->setCreateAt(new \DateTime('now'));
                $user->setIsActive(0);
                $user->setRole("ROLE_ADMIN");
                $user->setParent($id);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->sendEmail($username,$email);//enviar email usuario
                $this->sendEmailAdmin($username,$email,$fono);//enviar email admin
                if($this->createTables($id) && $this->createFolder($id)){
                    $flag = 1;
                }else{
                    $flag = 0;
                }
            }else{
                $flag = 0;
            }
        }catch(Exception $e){
            $flag = 0;
        }
        return $this->render('PAGEDemoBundle:Default:message.html.twig',array('flag'=>$flag,'type'=>0,'titulo'=>'Regístro'));
    }

    private function newId(){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $id = '';
        for($i=0; $i<15; $i++){
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PAGEDemoBundle:User')->find($id);

        if ($user){
           $exit = true;
           while($exit){
                $id = '';
                for($i=0; $i<15; $i++){
                    $id .= $caracteres[rand(0, strlen($caracteres)-1)];
                }
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('PAGEDemoBundle:User')->find($id);

                if (!$user)
                    $exit = false;
           }
        }
        return $id;
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
            mkdir($ruta.'/grades',0755);
            mkdir($ruta.'/callroll',0755);
            mkdir($ruta.'/images',0755);
            mkdir($ruta.'/planning',0755);
            return true;
        }
        return false;
    }

    private function sendEmail($name, $email){
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

    private function sendEmailAdmin($name,$email,$fono){
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
     * @Route("/profile/login_check", name="_demo_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/profile/logout", name="_demo_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/load", name="load")
     */
    /*  
    public function loadAction()
    {
        $base = array();
        $n = 8;

        $text = file_get_contents("bundles/pagedemo/".$n."base.txt");
        $text = explode('<tr>', $text);

        for ($i=2; $i < count($text); $i++) { 
            $obj = str_replace('</tr>', '', $text[$i]);
            $obj = explode('<td>', $obj);

            for ($j=0; $j < count($obj); $j++) { 
                $unidad = str_replace('</td>', '', $obj[$j]);
                $unidad = explode('<div', $unidad);

                for ($k=2; $k < count($unidad); $k++) {
                    if($k % 2 == 0){
                        $data = explode('<li', $unidad[$k]);
                        $temp = array();

                        for ($u=1; $u < count($data); $u++) { 
                            //get Id
                            if($u == 1){
                                $pos1 = stripos($data[$u], 'html">')+6;
                                $pos2 = stripos($data[$u], '</a>');
                                $id = substr($data[$u], $pos1, $pos2 - $pos1);
                                $temp[] = trim($id);
                            }

                            //get Detalle
                            if($u == 2){
                                $pos1 = stripos($data[$u], '">')+2;
                                $pos2 = stripos($data[$u], '</li>');
                                $detalle = substr($data[$u], $pos1, $pos2 - $pos1);
                                $temp[] = trim($detalle);
                            }
                            //get asignatura-curso-objetivo
                            if($u == 3){
                                $pos1 = stripos($data[$u], '">')+2;
                                $pos2 = stripos($data[$u], '</li>');
                                $items = substr($data[$u], $pos1, $pos2 - $pos1);
                                $items = explode('-', $items);
                                //asignatura 0
                                $temp[] = trim($items[0]);
                                //curso 1
                                $temp[] = trim($items[1]);
                                //objetivo 2
                                $temp[] = trim($items[2]);
                            }

                            //get url
                            if($u == 4){
                                $pos1 = stripos($data[$u], 'href')+6;
                                $pos2 = stripos($data[$u], 'html')+4;
                                $url = substr($data[$u], $pos1, $pos2 - $pos1);
                                $temp[] = trim($url);
                            }
                        }
                        //get Unidad
                        $temp[] = trim('Unidad '.$j);
                        $base[] = $temp;
                    }

                }
            }
        }

        $this->insertar($base);
        return new Response('Finalizado!'.count($base));
    }

    private function insertar($lista)
    {
        
        foreach ($lista as $key => $value) {
            $item = new BaseCurricular();
            $item->setIdObj($value[0]);
            $item->setCurso($value[3]);
            $item->setAsignatura($value[2]);
            $item->setUnidad($value[6]);
            $item->setObjetivo($value[4]);
            $item->setDetalle($value[1]);
            $item->setUrl($value[5]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
        }
    }
    */

}