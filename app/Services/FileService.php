<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function storeFile(UploadedFile $file): string|bool
    {
        $filename = uniqid() . '_' . $file->getClientOriginalName();

        return $file->storeAs('upload', $filename, 'public');
    }

    /**
     * @throws FileNotFoundException
     */
    public function getFile(string $filePath): ?string
    {
        if (!Storage::disk('public')->exists($filePath)) {
            throw new FileNotFoundException('File not found.');
        }

        return Storage::disk('public')->get($filePath);
    }
}
