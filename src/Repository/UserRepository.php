<?php

namespace App\Repository;

use App\Entity\SearchFilter;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }



    // public function userByProfession($metier, $codePostal='69000'): array
    // {
    //     $conn = $this->getEntityManager()->getConnection();
    //     if($metier){
    //     $sql = "SELECT nom, metier FROM `user` 
    //     join user_profession on user_profession.user_id = user.id 
    //     join profession on user_profession.profession_id = profession.id
    //     WHERE is_pro = 1 AND   metier = :metier";
    //     }elseif($codePostal){

    //     }
    //     $stmt = $conn->prepare($sql);
    //     $resultSet = $stmt->executeQuery(['metier' => $metier]);

    //     // returns an array of arrays (i.e. a raw data set)
    //     return $resultSet->fetchAllAssociative();
    // }


    // public function art(){
    //     return    $this->getEnti"SELECT nom, metier FROM `user` 
    //     join user_profession on user_profession.user_id = user.id 
    //     join profession on user_profession.profession_id = profession.id
    //     WHERE is_pro = 1 AND metier = 'vitrier'";
        
    // }


   

    public function findAllArtisans(SearchFilter $search):array 
    {
        //allvisibleQuery
        // return $this->findArtisans();
                
         

        $query = $this->findArtisans();
        // if($search->getMetier()){
        //     $query = $query->andWhere('u.metier = :metier')
        //     ;
        //     $query->setParameter('metier', $search->getMetier());
        // }
            if ($search->getMetier()){
                $metier = $search->getMetier();
                $conn = $this->getEntityManager()->getConnection();
                $sql = "SELECT user.nom,profession.metier,user.description FROM `user` 
        join user_profession on user_profession.user_id = user.id 
        join profession on user_profession.profession_id = profession.id
        WHERE is_pro = 1 AND   metier = :metier";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['metier' => $metier]);
        return $resultSet->fetchAllAssociative();

            }

            

        if($search->getCodePostal()){
            $query = $query->andWhere( 'u.codePostal = :codePostal');
            $query->setParameter('codePostal', $search->getCodePostal());
        }
        return $query->getQuery()->getResult();
            
    }

    public function findArtisans():QueryBuilder
    {
        $value = null;
        return $this->createQueryBuilder('u')
                ->where('u.isPro = 1 ');
    }


    // public function findProjet()
    // {
    //     $query = $this->createQueryBuilder('SELECT nom,titre, projet.description FROM `projet` join user on projet.user_id = user.id');
    //     return $query->getQuery()->getResult();
    // }
    // public function findProjet($user)
    // {
    //     $conn = $this->getEntityManager()->getConnection();
    //     $sql="SELECT nom,titre, projet.description FROM `projet` join user on projet.user_id = user.id";
    //     $stmt = $conn->prepare($sql);
    //     $resultSet = $stmt->executeQuery();
    //     return $resultSet->fetchAllAssociative();
    // }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
