<?php

namespace App\Repository;

use App\Entity\Incidents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Incidents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incidents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incidents[]    findAll()
 * @method Incidents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidentsRepository extends ServiceEntityRepository
{
   /*   public function send(int $num,array $filters): void
    {
        if(key_exists('chkbxtel',$filters) && $filters['chkbxtel'] !=='')
        {

            $IPXapikey = "AZERTY";
            $IPX_host = "10.8.1.102";
            $message = "Votre demande à bien était envoyée auprès de nos services de la mairie de Maisdon-sur-Sèvre. Bonne journée.";
            if (strlen($num) == 10 && ctype_digit($num) && (substr($num, 0, 2) == '06' || substr($num, 0, 2) == '07')) {
                $ch = curl_init();
                $url = "http://" . $IPX_host . "/api/xdevices.json?key=" . $IPXapikey . "&SetSMS=" . $num . ":" . $message;
    //echo $url.'<br>';
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_exec($ch);
                curl_close($ch);
    //echo '<br>'.$num.'##'.$message.'##'.$url.'<br>';
        }}
    }
*/

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Incidents::class);
    }

    // /**
    //  * @return Incidents[] Returns an array of Incidents objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Incidents
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
