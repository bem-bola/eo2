<?php

namespace App\Controller;


use App\Twig\AppExtension;
use App\Repository\FooterRepository;
use App\Repository\VideosRepository;
use App\Repository\InfoGeneraleRepository;
use App\Repository\MenuNavigationRepository;
use App\Repository\ReseauxSociauxRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArrierePlanAcceuilRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


// /**
//  * @IsGranted("ROLE_ADMIN")
//  */
class SiteController extends AbstractController
{
    /**
     * @Route("/", name="site")
     */
    public function index(InfoGeneraleRepository $info, MenuNavigationRepository $menu, ArrierePlanAcceuilRepository $bgRepo, FooterRepository $footerRepo, ReseauxSociauxRepository $reseauRepo, VideosRepository $videoRepo): Response
    {

        return $this->render('site/index.html.twig', [
            "info"    => $info->findBy(array(), array("id" => "DESC"), 1),
            "menu"    => $menu->findAll(),
            "bg"      => $bgRepo->findBy(array(), array("id" => "DESC"), 1),
            "footer"  => $footerRepo->findBy(array(), array("id" => "DESC"), 1),
            "videos"  => $videoRepo->findBy(array(), array("id" => "DESC")),
            'reseaux' => $reseauRepo->findAll(),
        ]);
    }
    
}
