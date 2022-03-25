<?php

namespace App\Service\UploaderService\PathResolver;

use App\Entity\CarPost;

/**
 * Class CarPathResolver
 */
class CarPathResolver extends PathResolver
{
    /**
     * @var string
     */
    public const DOWNLOAD_DIRECTORY = 'downloads/structured';

    /**
     * @var string
     */
    public const MODEL_DEFAULT_DIR = 'UNNAMED_MODELS';

    /**
     * @var string
     */
    public const GENERATION_DEFAULT_DIR = 'UNNAMED_GENERATIONS';

    /**
     * @inheritDoc
     */
    public function getUploadFolderPath($entity): string
    {
        /** @var CarPost $entity */
        return sprintf(
            '%s/%s/%s/%s/%s/%s/%s',
            $this->projectDir,
            self::DOWNLOAD_DIRECTORY,
            $this->resolveShortClassName($entity),
            $this->resolveCarMark($entity),
            $this->resolveCarModel($entity),
            $this->resolveCarGeneration($entity),
            $entity->getId()
        );
    }

    /**
     * @inheritDoc
     */
    public function getUploadedPath($entity, string $filename): string
    {
        return \sprintf(
            '%s/%s',
            $this->getUploadFolderPath($entity),
            $filename
        );
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function getWebPath($entity, string $filename): string
    {
        /** @var CarPost $entity */
        return \sprintf(
            '%s/%s/%s/%s/%s/%s/%s',
            self::DOWNLOAD_DIRECTORY,
            $this->resolveShortClassName($entity),
            $this->resolveCarMark($entity),
            $this->resolveCarModel($entity),
            $this->resolveCarGeneration($entity),
            $entity->getId(),
            $filename
        );
    }

    /**
     * @param CarPost $carPost
     *
     * @return string
     */
    private function resolveCarMark(CarPost $carPost): string
    {
        return $carPost->getCarInfo()->getMark()->getName();
    }

    /**
     * @param CarPost $carPost
     *
     * @return string
     */
    private function resolveCarModel(CarPost $carPost): string
    {
        $carModel = $carPost->getCarInfo()->getModel();

        return $carModel ? $carModel->getName() : self::MODEL_DEFAULT_DIR;
    }

    /**
     * @param CarPost $carPost
     *
     * @return string
     */
    private function resolveCarGeneration(CarPost $carPost): string
    {
        $carGeneration = $carPost->getCarInfo()->getGeneration();

        return $carGeneration ? $carGeneration->getName() : self::GENERATION_DEFAULT_DIR;
    }
}
