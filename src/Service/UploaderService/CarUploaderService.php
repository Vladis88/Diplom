<?php

namespace App\Service\UploaderService;

/**
 * Class CarUploaderService
 */
class CarUploaderService extends UploaderService
{
    /**
     * @inheritDoc
     */
    public function uploadOne($entity, string $file): string
    {
        $uploadedDir = $this->pathResolver->getUploadFolderPath($entity);

        if (!is_dir($uploadedDir)) {
            mkdir($uploadedDir, 0777, true);
        }

        $path = $this->pathResolver->getUploadedPath(
                $entity,
                $filename = $this->uploaderImageHelper->generateFilename($entity)
            )
            . '.' .
            $ext = $this->uploaderImageHelper->getImageExtension($file);

        file_put_contents($path, $file);

        return $this->pathResolver->getWebPath($entity, $filename) . '.' . $ext;
    }

    /**
     * @inheritDoc
     */
    public function uploadSeveral($entity, array $filesArray)
    {

    }
}
