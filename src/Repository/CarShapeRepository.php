<?php

namespace App\Repository;

use App\Entity\CarShape;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class CarShapeRepository
 * @package App\Repository
 */
class CarShapeRepository extends ServiceEntityRepository
{
    /**
     * CarBodyTypeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarShape::class);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findOneByName(string $name)
    {
        $result = null;

        try {
            $result = $this->createQueryBuilder('csr')
                ->where('upper(csr.name) = upper(:name)')
                ->setParameter('name', $name)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {

        } catch (NonUniqueResultException $e) {

        }

        return $result;
    }}
