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
     * @Route("/", name="profile")
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
            #return $this->redirect($this->generateUrl('admin_index'));
            return new Response("User Super Admin");

        else if($this->get('security.context')->isgranted('ROLE_ADMIN'))
            return $this->redirect($this->generateUrl('user'));
            #return array();
            #return new Response("User Admin");

    }
}
