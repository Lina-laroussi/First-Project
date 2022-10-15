<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;
use App\Entity\Product;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/addproduct', name: 'addproduct')]
    public function addproduct(ManagerRegistry $rg , Request $req ,ProductRepository $repo): Response
    {
        $p = new Product();//instance produit vide
        $form = $this ->createForm(ProductType::class, $p);//creation formulaire
        $form ->handleRequest($req);//analyse requete
        if ($form -> isSubmitted()){
            $ref=$p->getRef();
            $name=$p->getName();
            $description=$p->getDescription();
            /*$d=$id.' '.$name;
            $p->setDescription($d);*/
        // dd($req);
        //$p ->setName('tv');
        //$p ->setId(12345);
        //$p ->setDescription("tccccccccc");
        if($p !=null){//verfier que le form n'est pas vide
        $em = $rg->getManager();
        $em ->persist($p);
        $em ->flush();
    }}
        return $this->render('product/addp.html.twig', [//quand on utilise la methode render on ajoute la fct createview
            'f' => $form ->createView(),
        ]);
    }


    #[Route('/updateproduct/{ref}', name: 'updateproduct')]
    public function updateproduct($ref,ManagerRegistry $rg , Request $req ,ProductRepository $repo): Response
    {
        $p = $repo->find($ref);
        $form = $this ->createForm(ProductType::class, $p);//creation formulaire
        $form ->handleRequest($req);//analyse requete
        if ($form -> isSubmitted()){

            $id=$p->getRef();
            $name=$p->getName();
           /* $d=$id.' '.$name;
            $p->setDescription($d);*/
        $em = $rg->getManager();
        //$em ->persist($p); n'est pas obligatoire en update
        $em ->flush();
    }
        return $this->renderForm('product/addp.html.twig', [//quand on utilise la methode render on ajoute la fct createview
            'f' => $form,
        ]);
    }


    #[Route('/showproduct', name: 'showproduct')]
    public function showproduct(ManagerRegistry $rg ): Response
    {
         
       $repo =$rg ->getRepository(Product::class);
       $result = $repo ->findAll();
        
        return $this->renderForm('product/show.html.twig', [//quand on utilise la methode render on ajoute la fct createview
            'products' => $result,
        ]);
    }


    #[Route('/removeproduct/{ref}', name: 'removeproduct')]
    public function removeproduct($ref , ManagerRegistry $rg ,ProductRepository $repo ): Response
    {

        $p = $repo->find($ref);
        $em = $rg -> getManager();
        $em ->remove($p);
        $em ->flush();
       
       return $this -> redirectToRoute('showproduct');
    }

    #[Route('/detailproduct/{ref}', name: 'detailproduct')]
    public function detailproduct(Product $product , ManagerRegistry $rg): Response
    {
         
         return $this->renderForm('product/detail.html.twig', [//quand on utilise la methode render on ajoute la fct createview
            'product' => $product,
        ]);
    }

}
