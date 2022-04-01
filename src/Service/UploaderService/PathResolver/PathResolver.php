<?php

namespace App\Service\UploaderService\PathResolver;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PathResolver
 */
class PathResolver implements PathResolverInterface
{
    /**
     * @var string
     */
    protected const DOWNLOAD_DIRECTORY = 'downloads';

    /**
     * @var string
     */
    protected string $projectDir;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * PathResolver constructor.
     *
     * @param string $projectDir
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(string $projectDir, EntityManagerInterface $entityManager)
    {
        $this->projectDir = $projectDir;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function getUploadFolderPath($entity): string
    {
        return \sprintf(
            '%s/%s/%s/%s',
            $this->projectDir,
            self::DOWNLOAD_DIRECTORY,
            $this->resolveShortClassName($entity),
            $entity->getId()
        );
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function getUploadedPath($entity, string $filename): string
    {
        return \sprintf(
            '%s/%s/%s/%s/%s',
            $this->projectDir,
            self::DOWNLOAD_DIRECTORY,
            $this->resolveShortClassName($entity),
            $entity->getId(),
            $filename
        );
    }

    /**
     * @param $entity
     *
     * @return string
     *
     */
    protected function resolveShortClassName($entity): string
    {
        $reflectionClass = new \ReflectionClass($entity);
        return \strtolower($reflectionClass->getShortName());
    }

    /**
     * @inheritDoc
     */
    public function getWebPath($entity, string $filename): string
    {
        return "";
    }
}
