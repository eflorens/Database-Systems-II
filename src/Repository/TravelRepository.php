<?php

namespace App\Repository;

use App\Entity\Travel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Travel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Travel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Travel[]    findAll()
 * @method Travel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Travel::class);
    }

    public function findLatestByUser(UserInterface $user) {
        return $this->createQueryBuilder("travel")
            ->where("travel.user = ?1")
            ->orderBy("travel.created_at", "DESC")
            ->setParameter(1, $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function findLatest()
    {
        return $this->createQueryBuilder("travel")
            ->setMaxResults(12)
            ->orderBy("travel.created_at", "DESC")
            ->getQuery()
            ->getResult();
    }
}
