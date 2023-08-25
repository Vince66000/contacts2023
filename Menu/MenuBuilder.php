<?php

namespace App\Menu;

use AllowDynamicProperties;
use App\Entity\Filiales;
use App\Repository\FilialesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\NotSupported;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


#[AllowDynamicProperties] class MenuBuilder
{
    private FactoryInterface $factory;
    private AuthorizationCheckerInterface $security;


    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $security, EntityManagerInterface $entityManager)
    {
        $this->factory = $factory;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function createMainMenu($filiales)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav flex-row justify-content-around w-100');
        $menu->addChild('Global', ['route' => 'index']);
        $filiales = $this->entityManager->getRepository(Filiales::class)->findBy([], ['Nom' => 'ASC']);
        foreach ($filiales as $filiale) {

            $menu->addChild(
                $filiale->getNom(),
                [
                    'route' => 'app_contact_filiale',
                    'routeParameters' => ['id' => $filiale->getId()]
                ]
            );
        }

        return $menu;
    }
}


// access services from the container!
