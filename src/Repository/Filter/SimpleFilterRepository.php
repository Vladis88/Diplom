<?php

namespace App\Repository\Filter;

use App\Entity\CarPost;
use App\Model\Filter\SimpleFilterModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class SimpleFilterRepository
 */
class SimpleFilterRepository extends ServiceEntityRepository
{
    /**
     * SimpleFilterRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarPost::class);
    }

    /**
     * @param SimpleFilterModel $filterModel
     * @param bool $count
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function filter(SimpleFilterModel $filterModel, bool $count = false)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->join('p.carInfo', 'ci');

        if ($count) {
            $queryBuilder->select('count(p)');
        }

        foreach ($filterModel->getConditions() as $key => $value) {
            if ($value) {
                $queryBuilder
                    ->join('ci.' . $key, $key)
                    ->andWhere($key . '.id = ' . $value);
            }
        }

        $queryBuilder->setMaxResults(10);
        return $count ? $queryBuilder
            ->getQuery()
            ->getSingleScalarResult() : $queryBuilder->getQuery()->getResult();
    }
}
