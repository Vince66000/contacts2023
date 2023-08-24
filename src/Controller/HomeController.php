<?php

namespace App\Controller;

use App\Entity\Filiales;
use App\Repository\ContactRepository;
use App\Repository\FilialesRepository;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    #[Route('/', name:'index')]
    public function index(ContactRepository $contactRepository, FilialesRepository $filialesRepository): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('home/home.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }




}