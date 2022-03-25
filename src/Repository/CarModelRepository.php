<?php

namespace App\Repository;

use App\Entity\CarModel;
use App\Entity\CarShape;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class CarModelRepository
 * @package App\Repository
 */
class CarModelRepository extends ServiceEntityRepository
{
    /**
     * CarBodyTypeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarModel::class);
    }

    /**
     * @param string $linkPart
     * @param int $markId
     * @return mixed
     */
    public function findMarkByLinkPart(string $linkPart, int $markId)
    {
        $mark = null;

        try {
            $mark = $this->createQueryBuilder('m')
                ->where('m.carMark = :markId')
                ->andWhere('m.name LIKE :linkPart')
                ->setParameter('markId', $markId)
                ->setParameter('linkPart', $linkPart)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

        return $mark;
    }
}
