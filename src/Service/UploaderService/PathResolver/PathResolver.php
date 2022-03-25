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
    protected $projectDir;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * PathResolver constructor.
     *
     * @param string $projectDir
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(string $projectDir, EntityManagerInterface $em)
    {
        $this->projectDir = $projectDir;
        $this->em = $em;
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
     * @throws \ReflectionException
     */
    protected function resolveShortClassName($entity)
    {
        $reflectionClass = new \ReflectionClass($entity);
        return \strtolower($reflectionClass->getShortName());
    }

    /**
     * @inheritDoc
     */
    public function getWebPath($entity, string $filename): string
    {

    }
}
