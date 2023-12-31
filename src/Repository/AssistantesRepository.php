<?php

namespace App\Repository;

use App\Entity\Assistantes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Assistantes>
 *
 * @method Assistantes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assistantes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assistantes[]    findAll()
 * @method Assistantes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssistantesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assistantes::class);
    }

    public function getActivesAssistantes() {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActive = :val')
            ->setParameter('val', true)
            ->orderBy('a.Nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Assistantes[] Returns an array of Assistantes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


}
