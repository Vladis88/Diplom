<?php

namespace App\Repository;

use App\Entity\CarMark;
use App\Entity\CarShape;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class CarMarkRepository
 * @package App\Repository
 */
class CarMarkRepository extends ServiceEntityRepository
{
    /**
     * CarBodyTypeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarMark::class);
    }

    /**
     * @param string $linkPart
     * @return mixed
     */
    public function findMarkByLinkPart(string $linkPart)
    {
        $mark = null;

        try {
            $mark = $this->createQueryBuilder('m')
                ->where('m.name LIKE :linkPart')
                ->setParameter('linkPart', $linkPart)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

        return $mark;
    }
}
