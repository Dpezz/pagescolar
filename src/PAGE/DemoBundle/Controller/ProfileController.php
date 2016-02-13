<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="_demo_profile")
     * @Template()
     */
    public function indexAction(Request $request)
    {    
        if(!$request->getSession()->get('username'))
        {$request->getSession()->set('username',$this->getUser()->getUsername());}

        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}


        if($this->get('security.context')->isgranted('ROLE_SUPER_ADMIN'))
            return $this->redirect($this->generateUrl('admin_index'));

        else if($this->get('security.context')->isgranted('ROLE_ADMIN'))
            return $this->redirect($this->generateUrl('institucion_perfil'));

        else if($this->get('security.context')->isgranted('ROLE_DOCENTE'))
            return $this->redirect($this->generateUrl('docente_perfil_show',array('id'=>$this->getUser()->getId())));

        else if($this->get('security.context')->isgranted('ROLE_ALUMNO'))
            return $this->redirect($this->generateUrl('alumno_perfil_show',array('id'=>$this->getUser()->getId())));
	
        else 
			//return $this->redirect($this->generateUrl('_demo_signin'));
            return new Response("EN ESPERA");
    }
}
