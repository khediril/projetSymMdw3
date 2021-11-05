<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit/add/{nom}/{prix}", name="produit_add")
     */
    public function add($nom, $prix,ValidatorInterface $validator): Response
    {
        //création de l'objet : une instance
        $produit = new Produit();

        //Remplissage de l'objet
        $produit->setNom($nom);
        $produit->setPrix($prix);
        $produit->setDescription("c'est une bonne" . $nom);
        $errors = $validator->validate($produit);
        
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        // demande d'un entity manager
        $em = $this->getDoctrine()->getManager();

        // Demander son enregistrement dans la base
        $em->persist($produit);

        $em->flush();
        // return $this->redirectToRoute('produit_list');
        return $this->render('produit/index.html.twig', [
            "produit" => $produit

        ]);
    }
    /**
     * @Route("/produit/list", name="produit_list")
     */
    public function list(): Response
    {

        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();



        return $this->render('produit/list.html.twig', [
            "produits" => $produits

        ]);
    }
    /**
     * @Route("/produit/listparprix/{prix}", name="produit_listparprix")
     */
    public function listparprix($prix,ProduitRepository $rep): Response
    {

        $produits = $rep->findAllGreaterThanPrice($prix);



        return $this->render('produit/list.html.twig', [
            "produits" => $produits

        ]);
    }
    /**
     * @Route("/produit/{id}", name="produit_detail")
     */
    public function detail($id, ProduitRepository $rep): Response
    {

        $produit = $rep->find($id);
        if ($produit) {
            return $this->render('produit/detail.html.twig', [
                "produit" => $produit

            ]);
        }
        return $this->render('produit/erreur.html.twig', ['msg' => 'Aucun produit ayant id :' . $id]);
    }
    /**
     * @Route("/produit/delete/{id}", name="produit_delete")
     */
    public function delete($id, ProduitRepository $rep): Response
    {


        $produit = $rep->find($id);
        if ($produit) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();

            return $this->redirectToRoute('produit_list');
        }
        return $this->render('produit/erreur.html.twig', ['msg' => 'Suppression impossible, aucun produit ayant id :' . $id]);
    }
    /**
     * @Route("/produit/update/{id}/{prix}", name="produit_update")
     */
    public function update($id, $prix, ProduitRepository $rep): Response
    {

        $produit = $rep->find($id);
        if ($produit) {
            $produit->setPrix($prix);
            $em = $this->getDoctrine()->getManager();
            //$em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_list');
        }
        return $this->render('produit/erreur.html.twig', ['msg' => 'Aucun produit ayant id :' . $id]);
    }
}
