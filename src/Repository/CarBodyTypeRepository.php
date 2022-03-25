<?php

namespace App\Repository;

use App\Entity\CarBodyType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class CarBodyTypeRepository
 * @package App\Repository
 */
class CarBodyTypeRepository extends ServiceEntityRepository
{
    /**
     * CarBodyTypeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarBodyType::class);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findOneByName(string $name)
    {
        $result = null;

        try {
            $result = $this->createQueryBuilder('cbt')
                ->where('cbt.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {

        } catch (NonUniqueResultException $e) {

        }

        return $result;
    }
}
