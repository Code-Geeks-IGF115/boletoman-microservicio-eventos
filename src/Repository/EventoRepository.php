<?php

namespace App\Repository;

use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
/**
 * @extends ServiceEntityRepository<Evento>
 *
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evento::class);
    }

    public function save(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByUsuario($idUsuario): array
   {
       return $this->createQueryBuilder('e')
                   ->select('e.id, e.nombre, e.fechaInicio, e.horaInicio, e.horaFin')
                   ->where('e.idUsuario = :id_usuario')
                   ->setParameter('id_usuario', $idUsuario)
                   ->orderBy('e.id', 'ASC')
                   ->getQuery()
                   ->getResult()
                   ; 
   }
//    /**
//     * @return Evento[] Returns an array of Evento objects
//     */
   public function findEventosByids($idEventos): array
   {
       return $this->createQueryBuilder('e')
           ->andWhere('e.id IN (:idEventos)')
           ->setParameter('idEventos', $idEventos, \Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
           ->orderBy('e.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Evento
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
