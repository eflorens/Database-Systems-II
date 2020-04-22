<?php

namespace App\Repository;

use App\Entity\PropertyEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertyEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyEntity[]    findAll()
 * @method PropertyEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyEntity::class);
    }

    /**
     * @return QueryBuilder
     */
    private function findVisibleQuery(): QueryBuilder {
        return $this->createQueryBuilder('property')
            ->where('property.sold = false');
    }

    /**
     * @return PropertyEntity[]
     */
    public function findAllVisible(): array {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return PropertyEntity[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }
}
