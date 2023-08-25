<?php

namespace App\Controller;

use App\Entity\Filiales;
use App\Repository\ContactRepository;
use App\Repository\FilialesRepository;
use Doctrine\DBAL\Exception;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    /**
     * @throws Exception
     */
    #[Route('/', name:'index')]
    public function index(ContactRepository $contactRepository, FilialesRepository $filialesRepository): \Symfony\Component\HttpFoundation\Response
    {



        return $this->render('home/home.html.twig', [
            'contacts' => $contactRepository->findAll(),
            'statuts' => $contactRepository->getStatus(),
            'origines' => $contactRepository->getOrigins(),
        ]);
    }




}