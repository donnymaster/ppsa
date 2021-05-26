<?php

namespace App\Services\FileServices;

use App\Contracts\FileStorageServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DefaultFileService implements FileStorageServiceContract
{
    const DEFAULT_IMG_INCLUDE_PATH = 'default/article.png';

    public function saveFiles(string $parentFolder, array $files = null)
    {
    }

    public function saveFile(string $parentFolder, UploadedFile $file = null)
    {
        $path = self::DEFAULT_IMG_INCLUDE_PATH;

        if (isset($file)) {
            $folderPath = $parentFolder . '/' . date('Y-m-d');
            $path = $file->store($folderPath);
        }

        return $path;
    }

    public function deleteFileByName(string $name = null)
    {
        if ($name !== self::DEFAULT_IMG_INCLUDE_PATH && $name) {
            return Storage::delete($name);
        }

        return false;
    }
}
