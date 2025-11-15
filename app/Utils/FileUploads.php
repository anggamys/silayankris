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

  public static function upload(UploadedFile $file, string $path, ?string $prefix = '', string $ownerName = '')
  {
    $fileExt = $file->getClientOriginalExtension();

    if ($prefix  !== '' && $ownerName !== '') {
      $fileName = self::generateFileName($prefix, $ownerName);
    } else {
      $fileName = $ownerName;
    }

    $filePath = "{$path}/{$fileName}.{$fileExt}";

    $fileStream = fopen($file->getRealPath(), 'r+');

    Gdrive::putStream($filePath, $fileStream);

    return $filePath;
  }

  public static function delete(string $path)
  {
    if ($path && Gdrive::exists($path)) {
      Gdrive::delete($path);
    }
  }
}
