<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Footer;
use App\Entity\Images;
use App\Entity\Videos;
use App\Entity\MenuNavigation;
use App\Entity\ReseauxSociaux;
use App\Repository\UserRepository;
use App\Repository\FooterRepository;
use App\Repository\ImagesRepository;
use App\Repository\VideosRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InfoGeneraleRepository;
use App\Repository\MenuNavigationRepository;
use App\Repository\ReseauxSociauxRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArrierePlanAcceuilRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(MenuNavigationRepository $menuRepo): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            "menu"   => $menuRepo->findAll(),
        ]);
    }

    // RESEAUX SOCIAUX
    /**
     * @Route("/network", name="networks")
     */
    public function networks(ReseauxSociauxRepository $reseauRepo, Request $request, EntityManagerInterface $manager, MenuNavigationRepository $menuRepo): Response{


        return $this->render('admin/network.html.twig', [
            "reseaux" => $reseauRepo->findAll(),
            "menu"    => $menuRepo->findAll(),
        ]);

    }

    // RESEAUX SOCIAUX
    /**
     * @Route("/network/{id}", name="network")
     */
    public function network(ReseauxSociauxRepository $reseauRepo, Request $request, EntityManagerInterface $manager, MenuNavigationRepository $menuRepo, ReseauxSociaux $reseau): Response{


        // $reseau = new ReseauxSociaux; 
        
        if($request->request->count()){

            // dump($request->request->get("nom"), $request->request->get("lien"), $request->request->get("icon"));
            // die();

            $reseau->setReseauSocial($request->request->get("nom"))
                    ->setLien($request->request->get("lien"))
                    ->setIcon($request->request->get("icon"));

            $manager->persist($reseau);
            $manager->flush();

            $this->addFlash("success_net", "Modification effectuée avec succès !");
            return $this->redirectToRoute("networks");

        }

        return $this->render('admin/network.html.twig', [
            "reseaux" => $reseauRepo->findAll(),
            "menu"    => $menuRepo->findAll(),
            "reseau"  => $reseau,
        ]);

    }
    // FIN RESEAUX SOCIAUX

    // HAUT DE PAGE
    /**
     * @Route("/haut_page", name="haut")
     */

    public function haut_page_info(InfoGeneraleRepository $infoRepo, Request $request, EntityManagerInterface $manager, MenuNavigationRepository $menuRepo): Response
    {
        // Info generale du site: nom, description,...
        $info = $infoRepo->find(1);

        $formInfo = $this->createFormBuilder($info)
                    ->add('nom_du_site', TextType::class)
                    ->add('description_1', TextType::class,[
                        'required'   => false,
                    ])
                    ->add('description_2', TextType::class,[
                        'required'   => false,
                    ])
                    ->add('description_3', TextType::class,[
                        'required'   => false,
                    ])
                    ->add('description_4', TextType::class,[
                        'required'   => false,
                    ])
                    ->add('sous_titre_site', TextType::class,[
                        'required'   => false,
                    ])
                    ->add('save', SubmitType::class, ['label' => 'Mettre à jour'])
                    ->getForm();

        $formInfo->handleRequest($request);

        if ($formInfo->isSubmitted() && $formInfo->isValid()) {


            $info->setNomDuSite($formInfo->get('nom_du_site')->getData())
                ->setDescription1($formInfo->get('description_1')->getData())
                ->setDescription2($formInfo->get('description_2')->getData())
                ->setDescription3($formInfo->get('description_3')->getData())
                ->setDescription4($formInfo->get('description_4')->getData())
                ->setSousTitreSite($formInfo->get('sous_titre_site')->getData());

            $manager->persist($info);
            $manager->flush();

            $this->addFlash('success_info', 'La modification a été effectuée avec succès !');

            return $this->redirectToRoute("haut");
        }

        return $this->render('admin/haut_page.html.twig',[
            'formInfo'  => $formInfo->createView(),
            'info'      => $infoRepo->findAll(),
            "menu"   => $menuRepo->findAll(),
        ]);
    }

    // HAUT DE LA PAGE BACKGROUND
    /**
     * @Route("/haut_page/background", name="bg")
     */
    public function haut_page_bg(ArrierePlanAcceuilRepository $bgRepo, Request $request, EntityManagerInterface $manager, MenuNavigationRepository $menuRepo, ImagesRepository $imageRep, SluggerInterface $slugger): Response
    {

        // Arriere plan page acceuil
        $bg = $bgRepo->find(1);
        $forms = $this->createFormBuilder($bg)
                    ->add('background', FileType::class,[
                        'required'    => false,
                        'mapped'        => false,
                        'constraints' =>[
                            new File([
                                'mimeTypes' => [
                                    'image/png',
                                    'image/jpeg',
                                ],
                                'mimeTypesMessage' => 'Seules les images de format png & jpeg sont autorisés !',
                            ])
                        ]
                    ])
                    ->add('save', SubmitType::class, ['label' => 'Mettre à jour'])
                    ->getForm();

        $forms->handleRequest($request);

        if ($forms->isSubmitted() && $forms->isValid()) {

            $img_media = $request->request->get("image-media");

            // On repure fichier renseigné dans le form
            $img = $forms->get('background')->getData();

            if($img_media != "" || $img_media != null){
                $bg->setBackground($img_media);
            }
            else{

                if ($img)
                {
                   $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                   // ceci est nécessaire pour inclure en toute sécurité le nom du fichier dans l'URL
                   $safeFilename = $slugger->slug($originalFilename);
                   $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();
   
                   // Déplacer le fichier dans le répertoire où sont stockées les images
                   try {
                       $img->move(
                           $this->getParameter('upload_slider_img'),
                           $newFilename
                       );
                       // dd($this->getParameter('upload_slider_img') . "/lol" );
                       
                   } catch (FileException $e) {
                       // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                   }
   
                   // met à jour la propriété 'newFilename' pour stocker le nom du fichier PDF
                   // au lieu de son contenu
                   $bg->setBackground($newFilename);

                   $image = new Images();

                   $image->setLien($newFilename);
                   $manager->persist($image);
                   $manager->flush();
               
                }


               
            }
        
            // cette condition est nécessaire car le champ 'photo' n'est pas obligatoire
            // donc le fichier PDF doit être traité uniquement lorsqu'un fichier est téléchargé

            $manager->persist($bg);
            $manager->flush();


            // Supprimer l'ancienne image

            // if($photoDelete != $slider->getPhoto()){
            //     unlink($this->getParameter('upload_slider_img') . '/' . $photoDelete);
            // }

            $this->addFlash('success_bg', 'Votre arrière plan vient d\'être mis à jour avec succès !');
            return $this->redirectToRoute("bg");
        }


        return $this->render('admin/haut_page.html.twig',[
            'bg'    => $bg,
            "menu"  => $menuRepo->findAll(),
            'forms'     => $forms->createView(),
            'images'    => $imageRep->findBy(array(), array("id" => "DESC")),

        ]);
    }

    // HAUT DE LA PAGE MENU
    /**
     * @Route("/haut_page/menu", name="menu")
     */
    public function haut_page_menu(MenuNavigationRepository $menuRepo, Request $request, EntityManagerInterface $manager): Response
    {
        // Menu de navigation
        $menu = $menuRepo->findAll();

        if($request->request->count()){
            
            $array_menu  = $request->request->all();
            // dd($array_menu);
            // dump($request->request->get(30));
            $lengthArray = count($array_menu)/2;

            // les "i" correspondent au nom chaque item du menu
            // les "i*10" --------------------------------active
            for($i = 1; $i <= $lengthArray; $i++){

                $menu = $menuRepo->find($i);
                $menu->setTitre($request->request->get($i))
                     ->setActive($request->request->get($i*10));
                
                $manager->persist($menu);
                $manager->flush();

            }

            $this->addFlash('success_menu', 'Votre menu de navigation vient d\'être mis à jour avec succès !');

            return $this->redirectToRoute("menu");
        }

        return $this->render('admin/haut_page.html.twig',[
            'menu'      => $menu,
            // 'pres' => $presRepo->findBy(array(), array("id" => "DESC"), 1),
        ]);
    }
    // FIN HAUT DE PAGES

     /**
     * @Route("/media", name="media")
     * @Route("/media/new", name="media_new")
     */

    public function media (ImagesRepository $imgRepo, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, MenuNavigationRepository $menuRepo) : Response{

        // $photoDelete = $image->getPhoto();
        $image = new Images();

        $forms = $this->createFormBuilder($image)
                    ->add('lien', FileType::class,[
                        'required'    => true,
                        'mapped'        => false,
                        'constraints' =>[
                            new File([
                                'mimeTypes' => [
                                    'image/png',
                                    'image/jpeg',
                                ],
                                'mimeTypesMessage' => 'Seules les images de format png & jpeg sont autorisés !',
                            ])
                        ]
                    ])
                    ->add('save', SubmitType::class, ['label' => 'Ajouter'])
                    ->getForm();

        $forms->handleRequest($request);

        if ($forms->isSubmitted() && $forms->isValid()) {


            // On repure fichier renseigné dans le form
            $img = $forms->get('lien')->getData();
        

            // cette condition est nécessaire car le champ 'photo' n'est pas obligatoire
            // donc le fichier PDF doit être traité uniquement lorsqu'un fichier est téléchargé
            if ($img)
             {
                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom du fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();

                // Déplacer le fichier dans le répertoire où sont stockées les images
                try {
                    $img->move(
                        $this->getParameter('upload_slider_img'),
                        $newFilename
                    );
                    // dd($this->getParameter('upload_slider_img') . "/lol" );
                    
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }

                // met à jour la propriété 'newFilename' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $image->setLien($newFilename);
            }

            $manager->persist($image);
            $manager->flush();


            $this->addFlash('success_slider_edit', 'L\'image a été ajouté avec succès');

            return $this->redirectToRoute("media");
        }

        return $this->render("admin/images.html.twig",[
            'images'    => $imgRepo->findBy(array(), array("id" => "DESC")),
            'forms'     => $forms->createView(),
            "menu"   => $menuRepo->findAll(),
            // 'path'      => $pathImg,
        ]);
    }

     // MEDIA IMAGES
     /**
     * @Route("/media/delete/{id}", name="media_delete")
     */

    public function media_delete(Images $img, EntityManagerInterface $manager, MenuNavigationRepository $menuRepo) : Response {

        if(file_exists($this->getParameter('upload_slider_img') . '/' . $img->getLien())){
            unlink($this->getParameter('upload_slider_img') . '/' . $img->getLien());
        }

        $manager->remove($img);
        $manager->flush();

        $this->addFlash('Success_img_media', "L'image a été supprimée avec succès !");

        return $this->redirectToRoute("media");
    }
    // FIN MEDIA

    // LES UTILISATEURS
    /**
     * @Route("/users", name="users")
     */
    public function users(UserRepository $userRepo, Request $request, EntityManagerInterface $manager, MenuNavigationRepository $menuRepo){

        return $this->render('admin/user.html.twig',[
            'users'=> $userRepo->findAll(),
            "menu"   => $menuRepo->findAll(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="user")
     */
    public function user(UserRepository $userRepo, User $user, Request $request, EntityManagerInterface $manager, MenuNavigationRepository $menuRepo){

        if ($request->request->count()){
            // dd($request->request->get("role"));
            $user->setRoles([$request->request->get("role")]);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('succes_user', 'Modification effectuée avec succès !');

            return $this->redirectToRoute("users");
        }
        return $this->render('admin/user.html.twig',[
            'users'=> $userRepo->findAll(),
            'user'=> $user,
            "menu"   => $menuRepo->findAll(),

        ]);
    }
    /**
     * @Route("/user/remove/{id}", name="user_remove")
     */
    public function userRemove(UserRepository $userRepo, User $user, Request $request, EntityManagerInterface $manager, MenuNavigationRepository $menuRepo){

        $manager->remove($user);
        $manager->flush();

        $this->addFlash('succes_user_delete', 'Suppression effectuée avec succès !');

        return $this->redirectToRoute("users");
    }
    // FIN UTILISATEURS

    // FOOTER
    /**
     * @Route("/footer/{id}", name="footer")
     */
    public function footer(FooterRepository $footerRepo, Footer $footer,  Request $request, EntityManagerInterface $manager, MenuNavigationRepository $menuRepo){

        $forms = $this->createFormBuilder($footer)
                    ->add('text1', TextType::class)
                    ->add('text2', TextType::class)
                    ->add('save', SubmitType::class, ['label' => 'Mettre à jour'])
                    ->getForm();

        $forms->handleRequest($request);

        if ($forms->isSubmitted() && $forms->isValid()) {

            $footer->setText1($forms->get('text1')->getData())
                    ->setText2($forms->get('text2')->getData());

            $manager->persist($footer);
            $manager->flush();

            // $this->addFlash('succes_user', 'Modification effectuée avec succès !');

            // return $this->redirectToRoute("users");

        }

        return $this->render("admin/footer.html.twig",[
            'forms'     => $forms->createView(),
            "menu"   => $menuRepo->findAll(),
    ]);
    }
    // FIN FOOTER

    // TABLE DE VIDEOS
     /**
     * @Route("/videos", name="videos")
     */
    public function zone_3_slider (VideosRepository $videoRepo, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, MenuNavigationRepository $menuRepo) : Response{

        return $this->render('admin/videos.html.twig',[
            'videos' => $videoRepo->findBy([], ["id" => "DESC"]),
            'menu'   => $menuRepo->findAll(),

        ]);
    }
    

    // NOUVELLE VIDEO
    /**
    * @Route("/video/new", name="video_new")
    */
    public function new_video (Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, ImagesRepository $imageRep, MenuNavigationRepository $menuRepo) : Response{

        $video = new Videos();

        $pathImg ;
       
        $forms = $this->createFormBuilder($video)
                   ->add('image', FileType::class,[
                       'required'    => true,
                       'mapped'        => false,
                       'constraints' =>[
                           new File([
                               'mimeTypes' => [
                                   'image/png',
                                   'image/jpeg',
                               ],
                               'mimeTypesMessage' => 'Seules les images de format png & jpeg sont autorisés !',
                           ])
                       ]
                   ])

                   ->add('lien', TextType::class,[
                       'required' => true,
                   ])
                   ->add('save', SubmitType::class, ['label' => 'Enregister'])
                   ->getForm();

        $forms->handleRequest($request);


        if ($forms->isSubmitted() && $forms->isValid()) {

            $img_media = $request->request->get("image-media");

            // On repure fichier renseigné dans le form
            $img = $forms->get('image')->getData();

            if($img_media != "" || $img_media != null){
                $video->setImage($img_media);
            }
            else{

                if ($img)
                {
                    $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                    // ceci est nécessaire pour inclure en toute sécurité le nom du fichier dans l'URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();

                    // Déplacer le fichier dans le répertoire où sont stockées les images
                    try {
                        $img->move(
                            $this->getParameter('upload_slider_img'),
                            $newFilename
                        );
                        // dd($this->getParameter('upload_slider_img') . "/lol" );
                        
                    } catch (FileException $e) {
                        // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                    }

                    // met à jour la propriété 'newFilename' pour stocker le nom du fichier PDF
                    // au lieu de son contenu
                    $video->setImage($newFilename);

                    $image = new Images();

                    $image->setLien($newFilename);
                    $manager->persist($image);
                    $manager->flush();
                
                }

            }


            $video->setLien($forms->get('lien')->getData());

            $manager->persist($video);
            $manager->flush();

            $this->addFlash('success_video_new', 'La video a été ajoutée avec succès !');

            return $this->redirectToRoute("videos");
        }

        return $this->render('admin/new_video.html.twig',[
            'forms'     => $forms->createView(),
            'video'    => $video,
            'images'    => $imageRep->findBy(array(), array("id" => "DESC")),
            "menu"   => $menuRepo->findAll(),
        ]);
    }
    // NOUVELLE VIDEO
    /**
    * @Route("/video/edit/{id}", name="video_edit")
    */
    public function edit_video (Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, ImagesRepository $imageRep, MenuNavigationRepository $menuRepo, Videos $video) : Response{


        $pathImg ;
       
        $forms = $this->createFormBuilder($video)
                   ->add('image', FileType::class,[
                       'required'    => true,
                       'mapped'        => false,
                       'constraints' =>[
                           new File([
                               'mimeTypes' => [
                                   'image/png',
                                   'image/jpeg',
                               ],
                               'mimeTypesMessage' => 'Seules les images de format png & jpeg sont autorisés !',
                           ])
                       ]
                   ])

                   ->add('lien', TextType::class,[
                       'required' => true,
                   ])
                   ->add('save', SubmitType::class, ['label' => 'Enregister'])
                   ->getForm();

        $forms->handleRequest($request);


        if ($forms->isSubmitted() && $forms->isValid()) {

            $img_media = $request->request->get("image-media");

            // On repure fichier renseigné dans le form
            $img = $forms->get('image')->getData();

            if($img_media != "" || $img_media != null){
                $video->setImage($img_media);
            }
            else{

                if ($img)
                {
                    $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                    // ceci est nécessaire pour inclure en toute sécurité le nom du fichier dans l'URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();

                    // Déplacer le fichier dans le répertoire où sont stockées les images
                    try {
                        $img->move(
                            $this->getParameter('upload_slider_img'),
                            $newFilename
                        );
                        // dd($this->getParameter('upload_slider_img') . "/lol" );
                        
                    } catch (FileException $e) {
                        // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                    }

                    // met à jour la propriété 'newFilename' pour stocker le nom du fichier PDF
                    // au lieu de son contenu
                    $video->setImage($newFilename);

                    $image = new Images();

                    $image->setLien($newFilename);
                    $manager->persist($image);
                    $manager->flush();
                
                }

            }


            $video->setLien($forms->get('lien')->getData());

            $manager->persist($video);
            $manager->flush();

            $this->addFlash('success_video_edit', 'La video a été ajoutée avec succès !');

            return $this->redirectToRoute("videos");
        }

        return $this->render('admin/edit_video.html.twig',[
            'forms'     => $forms->createView(),
            'video'    => $video,
            'images'    => $imageRep->findBy(array(), array("id" => "DESC")),
            "menu"   => $menuRepo->findAll(),
        ]);
    }

    // SUPPRIMER UNE VIDEO
    /**
    * @Route("/video/delete/{id}", name="delete_video")
    */

    public function delete_video(EntityManagerInterface $manager, Videos $video, MenuNavigationRepository $menuRepo) : Response{

        $manager->remove($video);
        $manager->flush();

        $this->addFlash('video_delete', "La video a été supprimée avec succès !");

        return $this->redirectToRoute('videos');

    }

}
