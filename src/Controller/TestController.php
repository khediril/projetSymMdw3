<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/mdw3/test", name="test")
     */
    public function index(): Response
    {
        return $this->render('test/test.html.twig', [
            'controller_name' => 'TestController1111111',
        ]);
    }
    /**
     * @Route("/mdw3/test2", name="test2")
     */
    public function test2(): Response
    {
        return $this->render('test/test2.html.twig', [
            'controller_name' => 'TestController2222222',
        ]);
    }
    /**
     * @Route("/mdw3/test3", name="test3")
     */
    public function test3(): Response
    {
        $etudiants = ["ali","salah","hedi","mohamed","Louay"];
        $nom = "KHEDHIRI";
        return $this->render('test/test3.html.twig', ["nom" => $nom,"etudiants"=>$etudiants  ]);
    }
    /**
     * @Route("/mdw3/test4/{nom}", name="test4")
     */
    public function test4($nom): Response
    {
        
        $msg = "Bonjour ".$nom;
       
        return $this->render('test/test4.html.twig', ["msg" => $msg  ]);
    }
}

