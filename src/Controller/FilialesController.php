<?php

namespace App\Controller;

use App\Entity\Filiales;
use App\Form\FilialesType;
use App\Repository\FilialesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/filiales')]
class FilialesController extends AbstractController
{
    #[Route('/', name: 'app_filiales_index', methods: ['GET'])]
    public function index(FilialesRepository $filialesRepository): Response
    {
        return $this->render('filiales/index.html.twig', [
            'filiales' => $filialesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_filiales_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filiale = new Filiales();
        $form = $this->createForm(FilialesType::class, $filiale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($filiale);
            $entityManager->flush();

            return $this->redirectToRoute('app_filiales_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filiales/new.html.twig', [
            'filiale' => $filiale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filiales_show', methods: ['GET'])]
    public function show(Filiales $filiale): Response
    {
        return $this->render('filiales/show.html.twig', [
            'filiale' => $filiale,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filiales_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Filiales $filiale, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilialesType::class, $filiale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_filiales_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filiales/edit.html.twig', [
            'filiale' => $filiale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filiales_delete', methods: ['POST'])]
    public function delete(Request $request, Filiales $filiale, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filiale->getId(), $request->request->get('_token'))) {
            $entityManager->remove($filiale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_filiales_index', [], Response::HTTP_SEE_OTHER);
    }
}
