<?php

namespace Build\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Build\UserBundle\Form\UsersType;
use Build\UserBundle\Form\NewsType;
use Build\UserBundle\Entity\News;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function adminAction(){
        return $this->render('BuildUserBundle:Admin:admin.html.twig');
    }

    public function usersAction(){
        $repository = $this->getDoctrine()->getRepository('BuildUserBundle:Users');
        $users = $repository->findAll();
        return $this->render('BuildUserBundle:Admin:users.html.twig', array('users' => $users));
    }


    public function editUserAction(Request $request, $param) {
        $session = new Session();

        // $user = $this->get('security.context')->getToken()->getUser();
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->findAll();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BuildUserBundle:Users')->find($param);
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
                        ->add('jetons', 'text',  array("label" => "Jetons :"))
                        ->add('activityPoints', 'text',  array("label" => "Pixels :"))
                        ->add('credits', 'text',  array("label" => "Crédits :"))
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
                return $this->render('BuildUserBundle:Admin:edit_users.html.twig', array(
                'form' => $form->createView(),
                'user' => $user,
                'session' => $message,
                'title' => 'Edit user',
            ));
        }
        return $this->render('BuildUserBundle:Admin:edit_users.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
            'title' => 'Edit user',
        ));
    }

    // public function editUserModAction(){
    //     return $this->render('BuildUserBundle:Admin:edit_users.html.twig');
    // }



    public function createNewsAction(Request $request){
        $session = new Session();
        $user = $this->get('security.context')->getToken()->getUser();
        $news = new News();

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new NewsType(), $news)
                        ->add('author', 'hidden', array('data'=>$user->getId()))
                        ->add('date', 'hidden')
                        // ->add('credits', 'text', array("label" => "Credits :"))
                        // ->add('activityPoints', 'text', array("label" => "Pixels :"))
                        // ->add('mail', 'email', array("label" => "Adresse email :"))
                        // // ->add('vip', 'choice', array('choices' => array('0','1')), array("label" => "VIP :"))
                        // ->add('gender', 'text',  array("label" => "Sexe :"))
                        // ->add('motto', 'text',  array("label" => "Mission :"))
                        // // ->add('jetons', 'text', array("label" => "Jetons :"))
                        // ->add('password', 'hidden')
                        ->add('Poster', 'submit');

        $form->handleRequest($request);
        if ($form->isValid()) {
                $news->setDate();
                $em->persist($news);
                $em->flush();
                $session->getFlashBag()->add('update', 'Article posté!');

                foreach ($session->getFlashBag()->get('update', array()) as $message) {
                }
                return $this->render('BuildUserBundle:Admin:createNews.html.twig', array(
                'form' => $form->createView(),
                // 'user' => $user,
                'session' => $message,
                'title' => 'Edit user',
            ));
        }
        return $this->render('BuildUserBundle:Admin:createNews.html.twig', array(
            'form' => $form->createView(),
            // 'user' => $user,
            'title' => 'Edit user',
        ));
    }
}