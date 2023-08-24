<?php

namespace App\Controller;

use App\Repository\FilialesRepository;
use Symfony\Component\Routing\Annotation\Route;

class NavController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    #[Route('/nav', name:'nav')]
    static function nav(FilialesRepository $repository): array
    {

        return  $filiales = $repository->findAll();

    }

}