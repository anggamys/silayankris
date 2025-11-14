<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Uraymr\GoogleDrive\Gdrive;

class FileUploads
{
  public static function generateFileName(string $prefix = '', string $ownerName = '')
  {
    $ownerName = str_replace(' ', '_', strtolower($ownerName));

    return $prefix . '_' . $ownerName . '_' . now()->format('Ymd');
  }

  public static function upload(UploadedFile $file, string $path, string $prefix, string $ownerName)
  {
    $fileName = self::generateFileName($prefix, $ownerName);

    $filePath = "{$path}/{$fileName}.pdf";

    $fileStream = fopen($file->getRealPath(), 'r+');

    Gdrive::putStream($filePath, $fileStream);

    return $filePath;
  }
}
