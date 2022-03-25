<?php

namespace App\Service\UploaderService;

use App\Service\UploaderService\PathResolver\PathResolverInterface;

/**
 * Class UploaderService
 */
class UploaderService implements UploaderServiceInterface
{
    /**
     * @var PathResolverInterface
     */
    protected $pathResolver;

    /**
     * @var UploaderImageHelperInterface
     */
    protected $uploaderImageHelper;

    /**
     * UploaderService constructor.
     *
     * @param PathResolverInterface $pathResolver
     *
     * @param UploaderImageHelperInterface $imageHelper
     */
    public function __construct(
        PathResolverInterface $pathResolver,
        UploaderImageHelperInterface $imageHelper
    )
    {
        $this->pathResolver = $pathResolver;
        $this->uploaderImageHelper = $imageHelper;
    }

    /**
     * @inheritDoc
     */
    public function uploadSeveral($entity, array $filesArray)
    {

    }

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
}
