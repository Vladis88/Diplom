<?php

namespace App\Repository;

use App\Entity\CarEngineType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class CarEngineTypeRepository
 * @package App\Repository
 */
class CarEngineTypeRepository extends ServiceEntityRepository
{
    /**
     * CarBodyTypeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarEngineType::class);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findOneByName(string $name)
    {
        try {
            $result = $this->createQueryBuilder('cet')
                ->where('upper(cet.name) = upper(:name)')
                ->setParameter('name', $name)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {

        } catch (NonUniqueResultException $e) {

        }

        return $result;
    }
}
