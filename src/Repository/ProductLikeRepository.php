<?php

namespace App\Repository;

use App\Entity\ProductLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductLike>
 *
 * @method ProductLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductLike[]    findAll()
 * @method ProductLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductLike::class);
    }
    

    public function countByProductAndUser($product,$user)
    {
        $qb = $this->createQueryBuilder('b')
        ->select('COUNT(b)')
        ->where('b.product = :product')
        ->andWhere('b.user = :user')
        ->setParameter("product",$product)
        ->setParameter("user",$user)
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }
    public function save(ProductLike $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProductLike $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProductLike[] Returns an array of ProductLike objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductLike
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
