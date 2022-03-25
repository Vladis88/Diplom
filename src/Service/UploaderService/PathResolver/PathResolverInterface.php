<?php

namespace App\Service\UploaderService\PathResolver;

/**
 * Interface PathResolverInterface
 */
interface PathResolverInterface
{
    /**
     * @param $entity
     *
     * @return string
     */
    public function getUploadFolderPath($entity): string;

    /**
     * @param $entity
     *
     * @param string $filename
     *
     * @return string
     */
    public function getUploadedPath($entity, string $filename): string;

    /**
     * @param $entity
     *
     * @param string $filename
     *
     * @return string
     */
    public function getWebPath($entity, string $filename): string;
}
