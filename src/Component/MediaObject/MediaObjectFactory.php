<?php

declare(strict_types=1);

namespace App\Component\MediaObject;

use App\Entity\MediaObject;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;

class MediaObjectFactory
{
    public function __construct(
        private Filesystem $filesystem,
        private KernelInterface $kernel,
    )
    {
    }

    public function create(string $filename, string $fileType, string $fileLocationPath): MediaObject
    {
        $tempDir = sys_get_temp_dir(); // vaqtinchalik papkani yo'lini oladi

        // faylni to'liq yo'lini oladi
        $originalFilePath = $this->kernel->getProjectDir() . $fileLocationPath . $filename;

        // vaqtinchalik papkani ichidagi faylni to'liq yo'lini oladi
        $tempFilePath = $tempDir . '/' . $filename;

        // faylni vaqtinchalik papkani yo'lidan doimiy yo'lga nusxalab qo'yadi
        $this->filesystem->copy($originalFilePath, $tempFilePath, true);

        $file = new UploadedFile(
            $tempFilePath,
            explode('.', $filename)[0],
            $fileType,
            null,
            true
        );

        $media = new MediaObject();
        $media->file = $file;

        return $media;
    }
}
