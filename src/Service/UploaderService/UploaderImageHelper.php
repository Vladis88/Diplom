<?php

namespace App\Service\UploaderService;

/**
 * Class UploaderImageHelper
 */
class UploaderImageHelper implements UploaderImageHelperInterface
{
    /**
     * @inheritDoc
     */
    public function getImageExtension(string $file): string
    {
        $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
        $fileExtension = $fileInfo->buffer($file);

        $ext = \explode('/', $fileExtension);

        return \end($ext);
    }

    /**
     * @inheritDoc
     */
    public function generateFilename($entity): string
    {
        return \md5($entity->getId()) . \uniqid('', true);
    }
}
