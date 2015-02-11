<?php

namespace Build\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Build\UserBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ShopController extends Controller
{
    /*
    *@Route("/account/shop/bibz", name="shop_bibz")
    *@Template("BuildUserBundle:Shop:bibz.html.twig")
    */
    public function bibzAction(){
        $user = $this->get('security.context')->getToken()->getUser();
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->findAll();
        foreach ($online as $key => $value) {
            $online = $value;
        }
        return $this->render('BuildUserBundle:Shop:bibz.html.twig', array('user' => $user, 'online'=>$online));
    }

    /*
    *@Route("/account/shop/bibz")
    *@Template("BuildUserBundle:Shop:bibz.html.twig")
    */
    public function validAction(Request $request){
        $user = $this->get('security.context')->getToken()->getUser();
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->findAll();
        foreach ($online as $key => $value) {
            $online = $value;
        }
        // Déclaration des variables
        $ident=$idp=$ids=$idd=$codes=''; 
        $idp = 23001; 
        // $ids n'est plus utilisé, mais il faut conserver la variable pour une question de compatibilité
        $idd = 277505; 
        $ident=$idp.";".$ids.";".$idd;
        // var_dump($ident);
        // On récupère le(s) code(s) sous la forme 'xxxxxxxx;xxxxxxxx'
        if(isset($_POST['code1'])) $codes = $_POST['code1']; 

        $ident=urlencode($ident);
        $codes=urlencode($codes);

        /* Envoi de la requête vers le serveur StarPass
        Dans la variable tab[0] on récupère la réponse du serveur
        Dans la variable tab[1] on récupère l'URL d'accès ou d'erreur suivant la réponse du serveur */
        $get_f=@file( "http://script.starpass.fr/check_php.php?ident=$ident&codes=$codes" ); 
        $valid = explode('|', $get_f[0]);
        $reponse = $valid[0];

        if($reponse === "OUI"){
            $em = $this->getDoctrine()->getManager();

            $user = $this->get('security.context')->getToken()->getUser();
            $user->setJetons($user->getJetons()+ '10');
            $em->persist($user);
            $em->flush();
            return $this->render('BuildUserBundle:Shop:bibz.html.twig', array('message' => "Félicitation",'user'=>$user,'online'=>$online));
        }else{
            return $this->render('BuildUserBundle:Shop:bibz.html.twig', array('message' => 'Mauvais Code STARPASS','user'=>$user,'online'=>$online));
        }
    }

    /*
    *@Route("/account/shop/vip", name="shop_vip")
    *@Template("BuildUserBundle:Shop:vip.html.twig")
    */
    public function vipAction(){
        $user = $this->get('security.context')->getToken()->getUser();
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->findAll();
        foreach ($online as $key => $value) {
            $online = $value;
        }
        return $this->render('BuildUserBundle:Shop:vip.html.twig', array('user' => $user, 'online'=>$online));
    }

    /*
    *@Template("BuildUserBundle:Shop:vip.html.twig")
    */
    public function vipcheckAction(){
        $user = $this->get('security.context')->getToken()->getUser();
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->findAll();
        foreach ($online as $key => $value) {
            $online = $value;
        }
        $nb_jetons = $user->getJetons();
        // $time = time() + (30 * 24 * 60 * 60);

        if($user->getVip() == 1){
            $message = "Tu es déja VIP!";
        }else{
            if($nb_jetons >= 10){
                $em = $this->getDoctrine()->getManager();
                $user->setJetons($user->getJetons() - 10);
                $user->setVip('1');
                $em->persist($user);
                $em->flush();
                $message = "Félicitation, Tu es VIP!";
            }else{
                $message = "Tu n'a pas assez de Bib'z pour rejoindre le VIP Club";
            }
        }
        return $this->render('BuildUserBundle:Shop:vip.html.twig', array('user' => $user, 'message' => $message, 'online'=>$online));
    }
}