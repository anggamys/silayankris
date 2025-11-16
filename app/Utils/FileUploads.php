<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Uraymr\GoogleDrive\Gdrive;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileUploads
{

  public static function generateLocalThumbnail($file, $path)
  {
    $manager = new ImageManager(new Driver());

    $image = $manager->read($file->getRealPath());
    $image = $image->cover(150, 150);

    // change extension to .jpg
    $path = preg_replace('/\.[a-zA-Z0-9]+$/', '.jpg', $path);

    $savePath = storage_path('app/public/' . $path);
    $dir = dirname($savePath);
    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
    }

    $image->toJpeg(85)->save($savePath);

    return $path;
  }

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

  public static function delete(string $path, bool $localDelete = false)
  {
    if ($localDelete) {
      $path = preg_replace('/\.[a-zA-Z0-9]+$/', '.jpg', $path);
      $fullPath = storage_path('app/public/' . $path);
      if (is_file($fullPath)) {
        @unlink($fullPath);
      }
    }

    if ($path && Gdrive::exists($path)) {
      Gdrive::delete($path);
    }
  }
}
