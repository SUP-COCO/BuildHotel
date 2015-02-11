<?php

namespace Build\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Build\UserBundle\Entity\Users;
use Build\UserBundle\Entity\News;
use Build\UserBundle\Entity\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    /**
     * @Template("BuildUserBundle:News:index.html.twig")
     */
    public function indexAction(){
        $user = $this->get('security.context')->getToken()->getUser();
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->findAll();
        foreach ($online as $key => $value) {
            $online = $value;
        }
        $repository = $this->getDoctrine()->getRepository('BuildUserBundle:News');
        $news = $repository->findAll();
        return array('news' => $news, 'user' => $user, 'online'=>$online);
    }

    /**
     * @Template("BuildUserBundle:News:news.html.twig")
     */
    public function newsAction($param){
        $user = $this->get('security.context')->getToken()->getUser();
        $online = $this->getDoctrine()->getRepository('BuildUserBundle:ServerStatus')->find($param);
        foreach ($online as $key => $value) {
            $online = $value;
        }
        $article = $this->getDoctrine()->getRepository('BuildUserBundle:News')->find($param);
        $author = $this->getDoctrine()->getRepository('BuildUserBundle:Users')->find($article->author);
        $repository = $this->getDoctrine()->getRepository('BuildUserBundle:News');
        $news = $repository->findAll();
        return array('news' => $news, 'user' => $user, 'online'=>$online, 'article'=>$article, 'author'=>$author);
    }
}
