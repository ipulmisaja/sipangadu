<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait GDriveUploadable
{
    private $disk = 'google';

    public function uploadFile(string $folderId, $file)
    {
        if (is_array($file)) {
            $folderName = Str::random(5);

            // Create Sub Directory By Given Date
            Storage::disk($this->disk)->makeDirectory($folderId . '/' . $folderName);

            $folderId = collect(Storage::disk($this->disk)->listContents($folderId, false))->where('name', $folderName)->first();

            foreach ($file as $item) $item['url']->storeAs($folderId['basename'], $item['url']->getFilename(), $this->disk);

            $contents = collect(Storage::disk($this->disk)->listContents($folderId['basename'], false));

            return $contents->pluck('basename');
        } else {
            $filename = $file->getFilename();

            if (!is_null($file)) $file->storeAs($folderId, $filename, $this->disk);

            $contents = collect(Storage::disk($this->disk)->listContents($folderId, false));

            $file = $contents->where('name', $filename)->first();

            return $file;
        }
    }

    # FIXME: return functionnya perlu diperbaiki
    public function createDirectory($model) : array
    {
        Storage::disk('google')->makeDirectory(env('GOOGLE_DRIVE_FOLDER_GALERI') . '/' . Str::random(8));

        $arrCompare = $model::where('gallery_id', 1)->pluck('file')->toArray();

        return array_values(array_diff(Storage::disk($this->disk)->directories(env('GOOGLE_DRIVE_FOLDER_GALERI')), $arrCompare));
    }

    public function deleteDirectory(string $directoryId) : void
    {
        Storage::disk($this->disk)->deleteDirectory($directoryId);
    }

    public function deleteFile(string $fileId) : void
    {
        Storage::disk($this->disk)->delete($fileId);
    }
}
