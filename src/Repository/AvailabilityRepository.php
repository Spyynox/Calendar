<?php

namespace App\Repository;

use App\Entity\Availability;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Availability|null find($id, $lockMode = null, $lockVersion = null)
 * @method Availability|null findOneBy(array $criteria, array $orderBy = null)
 * @method Availability[]    findAll()
 * @method Availability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailabilityRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Availability::class);
        $this->manager = $manager;
    }

    public function saveAvailability($doctor, $date)
    {
        $newAvailability = new Availability();

        $newAvailability
            ->setDoctor($doctor)
            ->setDate($date);

        $this->manager->persist($newAvailability);
        $this->manager->flush();
    }

    public function updatedAvailability(Availability $availability): Availability
    {
        $this->manager->persist($availability);
        $this->manager->flush();

        return $availability;
    }
    
    // public function toArray()
    // {
    //     return [
    //         'id' => $this->getId(),
    //         'date' => $this->date,
    //         'doctor' => $this->doctor->toArray()
    //     ];
    // }

    public function removeAvailability(Availability $availability)
    {
        $this->manager->remove($availability);
        $this->manager->flush();
    }


    // /**
    //  * @return Availability[] Returns an array of Availability objects
    //  */
    
    public function findOneByIdJoinedToCategory()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p, u.fullname
            FROM App\Entity\Availability p
            INNER JOIN p.doctor u
            WHERE p.doctor = u.id'
            
        );

        return $query->getResult();
    }
    

    /*
    public function findOneBySomeField($value): ?Availability
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
