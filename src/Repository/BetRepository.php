<?php

namespace App\Repository;

use App\Entity\Bet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bet[]    findAll()
 * @method Bet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bet::class);
    }

    public function getPlayerBet(): array
    {
        $querybuilder = $this->createQueryBuilder('playerBet')
            ->select('id', 'playerName', 'betCase', 'colorCase', 'money');

        return $querybuilder->getQuery()->getResult();
    }

    // /**
    //  * @return Bet[] Returns an array of Bet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bet
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
