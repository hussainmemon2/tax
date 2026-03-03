<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class DocumentUploadService
{
    protected $maxSize = 6 * 1024 * 1024;

    public function upload($file, $folderPath)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $fileSize  = $file->getSize();
        $fileName  = time() . '_' . uniqid() . '.' . $extension;

        if ($fileSize <= $this->maxSize) {
            return $file->storeAs($folderPath, $fileName, 'public');
        }

        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return $this->compressImage($file, $folderPath, $fileName);
        }

        throw new \Exception("File exceeds 6MB and cannot be compressed.");
    }

    protected function compressImage($file, $folderPath, $fileName)
    {
        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        $image = $manager->read($file->getPathname())->orient();

        // Resize large images first
        if ($image->width() > 2000) {
            $image = $image->scaleDown(width: 2000);
        }

        $quality = 85;

        do {
            $encoded = $image->toJpeg($quality);
            $quality -= 5;
        } while (strlen($encoded) > $this->maxSize && $quality > 30);

        if (strlen($encoded) > $this->maxSize) {
            throw new \Exception("Image resolution too large to compress under 2MB.");
        }

        Storage::disk('public')->put($folderPath . '/' . $fileName, $encoded);

        return $folderPath . '/' . $fileName;
    }
}