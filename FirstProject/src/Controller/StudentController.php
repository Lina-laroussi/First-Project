<?php

namespace App\Controller;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        echo 'Bonjour mes étudiants';
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }


    #[Route('/addstudent', name: 'add_student')]
    public function add_student(ManagerRegistry $rg ,Request $req, StudentRepository $repo ): Response
    {
        $st = new Student();//instance produit vide
        $form = $this ->createForm(StudentType::class, $st);//creation formulaire
        $form ->handleRequest($req);//analyse requete
        if ($form -> isSubmitted()){
            $name=$st->getName();
            $surname=$st->getSurname();
            $email=$st->getEmail();
            
        if($st !=null){//verfier que le form n'est pas vide
            $em = $rg->getManager();
            $em ->persist($st);
            $em ->flush();
        }
    }
        return $this->render('student/addstudent.html.twig', [
            'f' => $form ->createView(),
        ]);
    }

    #[Route('/updatestudent/{nsc}', name: 'updatestudent')]
    public function update_student($nsc ,ManagerRegistry $rg ,Request $req, StudentRepository $repo ): Response
    {
        $st = $repo->find($nsc);
        $form = $this ->createForm(StudentType::class, $p);//creation formulaire
        $form ->handleRequest($req);//analyse requete
        if ($form -> isSubmitted()){
            $nsc=$p->getId();
            $name=$p->getName();
            $surname=$p->getSurname();
            $email=$p->getEmail();
            $em = $rg->getManager();
            //$em ->persist($p); n'est pas obligatoire en update
            $em ->flush();

        }
        return $this->render('student/addstudent.html.twig', [
            'f' => $form ,
        ]);
    }




    #[Route('/getstudents', name: 'app_student')]
    public function get_students(ManagerRegistry $em): Response
    {
        $repo = $em -> getRepository(Student::class);
        $result = $repo -> findAll();

        return $this->render('student/show.html.twig', [
            'students' => $result,
        ]);
    }

/*methode 2*/
    #[Route('/getstudents2', name: 'app_student_m2')]
    public function get_students_m2(StudentRepository $repo): Response
    {
        $result = $repo -> findAll();

        return $this->render('student/show.html.twig', [
            'students' => $result,
        ]);
    }


    #[Route('/remove/{nsc}', name: 'remove')]
    public function remove_student( $nsc , ManagerRegistry $mr , StudentRepository $repo): Response
    {   
        $st = $repo->find($nsc);
        $em = $mr -> getManager();
        $em ->remove($st);
        $em ->flush();

        return $this -> redirectToRoute('get_students_m2');
    }


    #[Route('/detail/{nsc}', name: 'detail')]
    public function detail(Student $student , ManagerRegistry $mr , StudentRepository $repo): Response
    {   
          return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }




}
