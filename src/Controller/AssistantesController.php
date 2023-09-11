<?php

namespace App\Controller;

use App\Entity\Assistantes;
use App\Form\AssistantesType;
use App\Repository\AssistantesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/assistantes')]
class AssistantesController extends AbstractController
{

//    public function __construct(Assistantes $assistantes)
//    {
//        $assistantes->setIsActive(true);
//    }

    #[Route('/', name: 'app_assistantes_index', methods: ['GET'])]
    public function index(AssistantesRepository $assistantesRepository): Response
    {
        return $this->render('assistantes/index.html.twig', [
            'assistantes' => $assistantesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assistantes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assistante = new Assistantes();
        $form = $this->createForm(AssistantesType::class, $assistante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assistante);
            $entityManager->flush();

            return $this->redirectToRoute('app_assistantes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assistantes/new.html.twig', [
            'assistante' => $assistante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assistantes_show', methods: ['GET'])]
    public function show(Assistantes $assistante): Response
    {
        return $this->render('assistantes/show.html.twig', [
            'assistante' => $assistante,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assistantes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assistantes $assistante, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssistantesType::class, $assistante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assistantes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assistantes/edit.html.twig', [
            'assistante' => $assistante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assistantes_delete', methods: ['POST'])]
    public function delete(Request $request, Assistantes $assistante, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assistante->getId(), $request->request->get('_token'))) {
            $entityManager->remove($assistante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assistantes_index', [], Response::HTTP_SEE_OTHER);
    }
}
