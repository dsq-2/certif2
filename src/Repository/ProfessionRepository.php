<?php

namespace App\Repository;

use App\Entity\Profession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Profession>
 *
 * @method Profession|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profession|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profession[]    findAll()
 * @method Profession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profession::class);
    }

    public function save(Profession $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Profession $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllUsers($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT user.id, user.nom , user.description, profession.metier,user.created_at FROM user 
        JOIN user_profession on user.id = user_profession.user_id
        JOIN profession on profession.id = user_profession.profession_id WHERE profession_id='.$id;
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    // public function findAllUsers($id)
    // {
    //     return    $this->getEntityManager()
    //     ->createQueryBuilder('s')
    //     ->select('cst.custName, ce.ceContactName,ce.ceExternContactId, 
    //     cst.custAdress1,  cst.custZipcode, cst.custCity, cst.szidcountry, ce.ceCustomerIdFk')
    //     ->from('App\Entity\Traitement:ContactExchange', 'ce')
    //     ->leftJoin('App\Entity\Bdf:Customer', 'cst', 'WITH', 'cst.idCustomer = ce.ceCustomerIdFk')
    //     ->getQuery()
    //     ->getArrayResult();
    // }
    

//    /**
//     * @return Profession[] Returns an array of Profession objects
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

//    public function findOneBySomeField($value): ?Profession
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
