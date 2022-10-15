<?php

namespace App\Controller;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/class/show', name: 'class_show')]
    public function show(ManagerRegistry $em): Response
    {
        $repo = $em -> getRepository(Classroom::class);
        $result = $repo -> findAll();

        return $this->render('classroom/show.html.twig', [
            'classes' => $result,
        ]);
    }


    #[Route('/class/remove/{id}', name: 'class_remove')]
    public function remove($id , ManagerRegistry $mr , ClassroomRepository $repo): Response
    {
        $cl = $repo->find($id);
        $em = $mr -> getManager();
        $em ->remove($cl);
        $em ->flush();

        return $this -> redirectToRoute('class_show');
    }


    #[Route('/class/detail/{id}', name: 'class_detail')]
    public function detail(Classroom $classroom , ManagerRegistry $mr , ClassroomRepository $repo): Response
    {
        return $this->render('classroom/detail.html.twig', [
                    'class' => $classroom
                ]);  
        }
}
