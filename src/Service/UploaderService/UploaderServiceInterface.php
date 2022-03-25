<?php

namespace App\Service\UploaderService;

/**
 * Interface UploaderServiceInterface
 */
interface UploaderServiceInterface
{
    /**
     * @param $entity
     *
     * @param array $filesArray
     *
     * @return mixed
     */
    public function uploadSeveral($entity, array $filesArray);

    /**
     * @param $entity
     *
     * @param string $file
     *
     * @return string
     */
    public function uploadOne($entity, string $file): string;
}
