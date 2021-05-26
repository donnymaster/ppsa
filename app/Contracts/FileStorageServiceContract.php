<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface FileStorageServiceContract
{
    /**
     * Save file by object in parent folder using file object
     *
     * @param string $parentFolder
     * @param UploadedFile $file
     *
     * @return string
     */
    public function saveFile(string $parentFolder, UploadedFile $file = null);

    /**
     * Save file by array of file objects in parent folder
     *
     * @param string $parentFolder
     * @param array $files
     *
     * @return string
     */
    public function saveFiles(string $parentFolder, array $files = null);

    /**
     * Removes a file by name
     *
     * @param string $name
     *
     * @return bool
     */
    public function deleteFileByName(string $name);
}
