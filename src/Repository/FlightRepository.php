<?php

namespace App\Repository;

use App\Entity\Flight;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flight>
 *
 * @method Flight|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flight|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flight[]    findAll()
 * @method Flight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flight::class);
    }

    public function save(Flight $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Flight $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search($departure_airport, $arrival_airport, $departure_datetime = null)
    {
        $queryBuilder = $this->createQueryBuilder('flight')
            ->join('flight.departure_airport', 'departure')
            ->join('flight.arrival_airport', 'arrival');

        if ($departure_datetime == null) {
            $queryBuilder->where('flight.departure_datetime >= :now')
                ->setParameter('now', new \DateTime(), \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE);
        }
        if ($departure_airport !== null) {
            $queryBuilder->andWhere('departure.id = :departure_airport')
                ->setParameter('departure_airport', $departure_airport->getId());
        }
        if ($arrival_airport !== null) {
            $queryBuilder->andWhere('arrival.id = :arrival_airport')
                ->setParameter('arrival_airport', $arrival_airport->getId());
        }
        if ($departure_datetime !== null) {
            if (is_string($departure_datetime)) {
                $departure_datetime = \DateTime::createFromFormat('Y-m-d', $departure_datetime);
            }

            $queryBuilder->andWhere('flight.departure_datetime >= :departure_datetime')
                ->setParameter('departure_datetime', $departure_datetime, \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE);
        }
        return $queryBuilder->getQuery()->getResult();
    }

    public function findUpcomingFlightsByUser(User $user): array
    {
        $queryBuilder = $this->createQueryBuilder('flight');

        $queryBuilder->innerJoin('flight.bookings', 'booking')
            ->innerJoin('booking.account_id', 'user')
            ->where('user.id = :userId')
            ->andWhere('flight.departure_datetime > :now')
            ->setParameter('userId', $user->getId())
            ->setParameter('now', new \DateTime(), \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE);

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }


    public function findHistoryFlightsByUser(User $user)
    {
        $qb = $this->createQueryBuilder("flight");
        $qb->innerJoin("flight.bookings", "booking")
            ->innerJoin("booking.account_id", "user")
            ->where('user.id = :userId')
            ->andWhere('flight.departure_datetime < :now')
            ->setParameter('userId', $user->getId())
            ->setParameter('now', new \DateTime(), \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE);
        $query = $qb->getQuery();
        return $query->getResult();
    }
}

//    /**
//     * @return Flight[] Returns an array of Flight objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Flight
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
