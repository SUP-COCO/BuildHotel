<?php

namespace Build\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Build\UserBundle\Entity\Users;
use Build\UserBundle\Entity\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function RegisterAction(Request $request)
    {
        $user = new Users();

        $form = $this->createFormBuilder($user)
        ->add('username', 'text', array("label" => "Nom d'utilisateur :"))
        ->add('password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Les mots de passe doivent correspondre',
            'options' => array('required' => true),
            'first_options'  => array('label' => 'Mot de passe :'),
            'second_options' => array('label' => 'Mot de passe (validation) :'),
            ))

        ->add('gender', 'choice', array(
            'choices' => array('M' => 'Homme', 'F' => 'Femme'),
            'required' => true,
            "label" => "Sexe :"
            ))
        ->add('mail', 'email', array("label" => "Adresse e-mail :"))
        ->add('Enregistrer', 'submit')
        ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setAuthTicket($this->generateAutkTicket());
            $user->setAccountCreated(date('H:i:s'));
            $user->setPassword(sha1($user->getPassword()));
            $user->setLastOnline(date('H:i:s'));
            $user->setIpLast($_SERVER["REMOTE_ADDR"]);
            $user->setIpReg($_SERVER["REMOTE_ADDR"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('register_ok'));
        }
        return $this->render('BuildUserBundle:Default:register.html.twig', array('form' => $form->createView()));
    }


        /**
         * Action pour recevoir les informations envoyées
         * @Route("/login_check/", name="login_check")
         * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse
         */

        public function checkAction() {
            return new Response();
        }

        /**
         * Deconnexion d'un utilisateur
         * @Route("/logout/", name="logout")
         * @author hazem
         * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse
         */

        public function logoutAction() {
            $session = $this->getRequest()->getSession();
            $token = $session->get('token');
            $this->get("request")->getSession()->invalidate();
            $this->get("security.context")->setToken(null);
            $this->getRequest()->getSession()->remove('token');

            return $this->redirect($this->generateUrl('login'));
        }
    

        // /**
        //  * redirection (selon le rôle) après une authentification avec succès
        //  * @Route("/redirection/", name="redirection")
        //  * @author hazem
        //  * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse
        //  */

        // public function redirectionAction() {
        //     if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        //             return $this->redirect($this->generateUrl('admin_acceuil'));
        //     elseif ($this->get('security.context')->isGranted('ROLE_CLIENT'))
        //             return $this->redirect($this->generateUrl('client_acceuil'));
        // }























    private function generateAutkTicket(){
        $AuthTicket = "BUILD-";
        $AuthTicket .= rand(1000, 9999) . "-";
        $AuthTicket .= rand(1000, 9999) . "-";
        $AuthTicket .= rand(1000, 9999) . "-";
        $AuthTicket .= rand(1000, 9999) . "-";
        $AuthTicket .= rand(1000, 9999);

        return $AuthTicket;
    }

    private function encrypt($password){
        $newpass = substr($password, 1, 3);
        $newpass = sha1($newpass);

        return $newpass;
    }
}
