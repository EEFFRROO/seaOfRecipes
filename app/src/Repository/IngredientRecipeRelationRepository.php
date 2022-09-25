<?php

namespace App\Repository;

use App\Entity\IngredientRecipeRelation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IngredientRecipeRelation>
 *
 * @method IngredientRecipeRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientRecipeRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientRecipeRelation[]    findAll()
 * @method IngredientRecipeRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRecipeRelationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientRecipeRelation::class);
    }

    public function save(IngredientRecipeRelation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(IngredientRecipeRelation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return IngredientRecipeRelation[] Returns an array of IngredientRecipeRelation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IngredientRecipeRelation
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
