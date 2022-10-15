<?php

namespace App\Controller;
use App\Entity\Club;
use App\Repository\ClubRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }


    #[Route('/addclub', name: 'addclub')]
    public function add_club(ManagerRegistry $rg , Request $req ,ClubRepository $repo): Response
    {
        $cl = new Student();//instance produit vide
        $form = $this ->createForm(Student::class, $cl);//creation formulaire
        $form ->handleRequest($req);//analyse requete
        if ($form -> isSubmitted()){
            $pv=$repo->find($id);//verification de l'existence de l'id
            $name=$cl->getCreatedAt();
            
        if($pv == null & $st !=null){//verfier que le form n'est pas vide
            $em = $rg->getManager();
            $em ->persist($cl);
            $em ->flush();
        }
    }

        return $this->render('club/addclub.html.twig', [
            'f' => $form -> createView(),
        ]);
    }

    #[Route('/club/get/{name}', name: 'app_detail')]
    public function getName($name): Response
    {
        return $this->render('club/detail.html.twig', [
            'name' => $name,
        ]);
    }



    #[Route('/list', name: 'app_list')]
    public function list(): Response
    {
        $formations = array(
            array('ref' => 'form147', 'Titre' => 'Formation Symfony
            4','Description'=>'formation pratique',
            'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
            'nb_participants'=>19) ,
            array('ref'=>'form177','Titre'=>'Formation SOA' ,
            'Description'=>'formation
            theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
            'nb_participants'=>0),
            array('ref'=>'form178','Titre'=>'Formation Angular' ,
            'Description'=>'formation
            theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
            'nb_participants'=>12));
        return $this->render('club/list.html.twig', [
            'tab' => $formations,
        ]);
    }


    #[Route('/club/show', name: 'club_show')]
    public function show(ManagerRegistry $em): Response
    {
        $repo = $em -> getRepository(Club::class);
        $result = $repo -> findAll();

        return $this->render('club/show.html.twig', [
            'clubs' => $result,
        ]);
    }

    #[Route('/club/remove/{ref}', name: 'club_remove')]
    public function remove($ref , ManagerRegistry $mr , ClubRepository $repo): Response
    {
        $cl = $repo->find($ref);
        $em = $mr -> getManager();
        $em ->remove($cl);
        $em ->flush();
      
        return $this -> redirectToRoute('club_show');
    }

     #[Route('/club/detail/{ref}', name: 'club_detail')]
    public function detail(Club $club ,ManagerRegistry $mr , ClubRepository $repo): Response
        {
            return $this->render('club/detail.html.twig', [
                        'club' => $club,
            ]);  
        }


}
