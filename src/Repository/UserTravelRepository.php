<?php


namespace App\Repository;

use App\Entity\UserTravel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserTravel|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTravel|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTravel[]    findAll()
 * @method UserTravel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTravelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTravel::class);
    }

    public function findTravelById($travelId)
    {
        return $this->createQueryBuilder("userTravel")
            ->select("userTravel")
            ->join("userTravel.travel", 't', Join::WITH, "userTravel.travel = t.id")
            ->where("userTravel.travel = (:id)")
            ->setParameter("id", $travelId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}