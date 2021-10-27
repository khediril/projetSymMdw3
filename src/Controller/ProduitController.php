<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit/add/{nom}/{prix}", name="produit_add")
     */
    public function add($nom,$prix): Response
    {
        //création de l'objet : une instance
        $produit = new Produit();
        
        //Remplissage de l'objet
        $produit->setNom($nom);
        $produit->setPrix($prix);
        $produit->setDescription("c'est une bonne".$nom);
        // demande d'un entity manager
        $em = $this->getDoctrine()->getManager();
        
        // Demander son enregistrement dans la base
        $em->persist($produit);

        $em->flush();
        // return $this->redirectToRoute('produit_list');
        return $this->render('produit/index.html.twig', ["produit"=>$produit
           
        ]);
    }
     /**
     * @Route("/produit/list", name="produit_list")
     */
    public function list(): Response
    {
        
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        
        
        return $this->render('produit/list.html.twig', ["produits"=>$produits
           
        ]);
    }
}
