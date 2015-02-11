<?php

namespace Build\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Build\UserBundle\Form\UsersType;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction()
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect( $this->generateUrl('account') );
        }else{
            $request = $this->getRequest();
            $session = $request->getSession();
            if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
            } else {
                $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                $session->remove(SecurityContext::AUTHENTICATION_ERROR);
            }
            return $this->render('BuildUserBundle:Security:login.html.twig', array(
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            ));
        }
    }

    public function accountAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->findAll();
        foreach ($online as $key => $value) {
            $online = $value;
        }
        $badges = $this->getDoctrine()->getRepository('BuildUserBundle:UserBadges')->findByUserId($user->getId());
        return $this->render('BuildUserBundle:Security:account.html.twig', array('user' => $user, 'online' => $online,'badges'=>$badges));
    }

    public function onlineAction(){
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->findAll();
        foreach ($online as $key => $value) {
            $online = $value;
        }
        return $online;
    }

    public function hotelAction(){
        $user = $this->get('security.context')->getToken()->getUser();
        return $this->render('BuildUserBundle:Security:hotel.html.twig', array('user' => $user));
    }

    public function editAction(Request $request){
        $session = new Session();

        $user = $this->get('security.context')->getToken()->getUser();
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->findAll();
        foreach ($online as $key => $value) {
            $online = $value;
        }
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BuildUserBundle:Users')->find($user->getId());
        $form = $this->createForm(new UsersType(), $user)
                        ->add('username', 'hidden')
                        // ->add('credits', 'text', array("label" => "Credits :"))
                        // ->add('activityPoints', 'text', array("label" => "Pixels :"))
                        ->add('mail', 'email', array("label" => "Adresse email :"))
                        // ->add('vip', 'choice', array('choices' => array('0','1')), array("label" => "VIP :"))
                        ->add('gender', 'text',  array("label" => "Sexe :"))
                        ->add('motto', 'text',  array("label" => "Mission :"))
                        ->add('acceptTrading', 'choice', array(
                            'label' => 'Activé le troc :',
                            'choices' => array('0' => 'Non', '1' => 'Oui'))
                        )
                        ->add('blockNewfriends', 'choice', array(
                            'label' => "Desactiver les demande d'amis :",
                            'choices' => array('0' => 'Non', '1' => 'Oui'))
                        )
                        // ->add('jetons', 'text', array("label" => "Jetons :"))
                        ->add('password', 'hidden')
                        ->add('Modifier', 'submit');

        $form->handleRequest($request);
        if ($form->isValid()) {
                $em->persist($user);
                $em->flush();
                $session->getFlashBag()->add('update', 'Profil mis à jour!');

                foreach ($session->getFlashBag()->get('update', array()) as $message) {
                }
                return $this->render('BuildUserBundle:Security:edit_users.html.twig', array(
                'form' => $form->createView(),
                'user' => $user,
                'online' => $online,
                'session' => $message,
                'title' => 'Edit user',
            ));
        }
        return $this->render('BuildUserBundle:Security:edit_users.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
            'online' => $online,
            'title' => 'Edit user',
        ));
    }
}