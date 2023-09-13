<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\FilialesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;




#[AllowDynamicProperties] #[Route('/contact')]
class ContactController extends AbstractController
{
    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }


    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setDateUpdate(new \DateTime());
            $entityManager->flush();
            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/filiale/{id}', name: 'app_contact_filiale', methods: ['GET'])]
    public function findContactsByFiliale($id, ContactRepository $contactRepository, FilialesRepository $filialesRepository): Response
    {
        $filiale = $id;
        $nomFiliale = $filialesRepository->find($id);
        dump($nomFiliale);
        $contacts = $contactRepository->findBy(['Filiale' => $filiale]);
//        print_r($contacts);
        return $this->render('filiales/contacts.html.twig', [
            'contacts' => $contacts,
            'nomFiliale' => $nomFiliale,
            'statuts' => $contactRepository->getStatus(),
            'origines' => $contactRepository->getOrigins(),

        ]);
    }


    public function getIdCompany()
    {
        $token = $this->getToken();
        $uri = 'https://aeb.a26.fr/dossier/restapi/v1/Compagnies';
        $request = $this->client->request('GET', $uri, ['auth_bearer'=>$token ,'headers' =>  ['X-Avensys-API-Key' => 'puKukTaOh0zDxnMg0zD4DAeWoKnTIKlz'] ]);
        $restult = json_decode($request->getContent(), true);
        dump($restult);
    }


    /**
     * Récupération du refresh_Token
     * @throws TransportExceptionInterface
     */
    public function getToken(): array|string
    {
        $token = [];
        $user = 'admin';
        $password = 'fjLfiJ#bi9QLQ96M';
        $uri = 'https://aeb.a26.fr/dossier/restapi/v1/Utilisateurs/Login';
        $request = $this->client->request('POST', $uri, ['body' => ['username'=> $user, 'password' => $password], 'headers' =>  ['X-Avensys-API-Key' => 'puKukTaOh0zDxnMg0zD4DAeWoKnTIKlz'] ]);
        try {
            $token = $request->getContent();
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            dump('L\'erreur suivante a été relevée : ' . $e->getMessage());
        }
        $rToken2 = json_decode($token, true);
        $rToken = $rToken2['refresh_token'];
        return $rToken;
    }


    /**
     * @throws TransportExceptionInterface
     */
    #[Route('creerClient/{id}', name: 'creerClient', methods: ['GET', 'POST'])]
    public function creerClient(ContactRepository $contactRepository, $id)
    {

        $token = $this->getToken();


        /**
         * Création client
         */
        $compagnie = 'https://aeb.a26.fr/dossier/restapi/v1/Compagnies';
        $contact = $contactRepository->find($id);

        $nouveauClient = $this->client->request(
            'POST',
            $compagnie,
            [
                'auth_bearer'=>$token ,
                'headers' =>
                ['X-Avensys-API-Key' => 'puKukTaOh0zDxnMg0zD4DAeWoKnTIKlz'],
                'body' =>
                    [
                        'Libelle'=> $contact->getNom(),
                        'Adresse'=> [
                          'Nom' => $contact->getNom(),
                          'Adr1' => $contact->getAdresse(),
                          'CPVille' => $contact->getCodePostal() . ' ' . $contact->getVille(),
                        ],
                    ]
            ]);

        /**
         * Récupération de l'id du client pour créer le dossier
         */
        $trouverIdClient = $this->client->request(
            'GET',
            $compagnie,
            ['auth_bearer'=>$token, 'headers' =>  ['X-Avensys-API-Key' => 'puKukTaOh0zDxnMg0zD4DAeWoKnTIKlz'] ]
        );

        try {
            $listeClients = json_decode($trouverIdClient->getContent(), true);
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            dump('L\'erreur suivante a été relevée : ' . $e->getMessage());
        }

        foreach ($listeClients as $listeClient) {
            if ($listeClient['Libelle'] === $contact->getNom()) {
                $idClient = $listeClient['Id'];
            }
        }
        dump($idClient);
        return $this->render('contact/index.html.twig');
    }


//    public function creerDossier($id, ContactRepository $contactRepository, FilialesRepository $filialesRepository): string
//    {
//        $rToken = $this->getToken();
//        $uri = 'https://aeb.a26.fr/dossier/restapi/v1/Bureaux';
//        $request = $this->client->request('GET', $uri, ['auth_bearer'=>$rToken ,'headers' =>  ['X-Avensys-API-Key' => 'puKukTaOh0zDxnMg0zD4DAeWoKnTIKlz'] ]);
//        $filiale = $id;
//        $contact = $contactRepository->find($id);
//        $restult = json_decode($request->getContent(), true);
//        dump($restult);
//        $contacts = $contactRepository->findBy(['Filiale' => $filiale]);
//
//        return  $request->getContent();
//
//    }

}