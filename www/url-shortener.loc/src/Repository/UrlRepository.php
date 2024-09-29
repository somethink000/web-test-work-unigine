<?php

namespace App\Repository;

use App\Entity\Url;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Url|null find($id, $lockMode = null, $lockVersion = null)
 * @method Url|null findOneBy(array $criteria, array $orderBy = null)
 * @method Url[]    findAll()
 * @method Url[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Url::class);
    }

    public function findOneByHash(string $value): ?Url
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.hash = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findFirstByUrl(string $value): ?Url
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.url = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)// skill issue
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function findByTimeDifference(string $from, string $to): ?array
    {

        return $this->createQueryBuilder('u')
            ->where('u.createdDate BETWEEN :from AND :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function findByDomain(string $value): ?array
    {
        //SUBSTRING(SUBSTRING(SUBSTRING(SUBSTRING(u.url, '/', 3), '://', :offset), '/', 1), '?', 1)
        
        //only for URL not for URI // doctrine substring works weird maybe try native sql?
        return $this->createQueryBuilder('u')
            ->where("SUBSTRING(u.url, 1, :lenght) = :url")
            ->setParameter('url', $value)
            ->setParameter('lenght', strlen($value))
            ->getQuery()
            ->getArrayResult()
        ;
    }


    

}
