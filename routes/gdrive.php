<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Uraymr\GoogleDrive\Gdrive;


Route::prefix('gdrive')->group(function () {
  // Health check for Google Drive connection
  Route::get('/health', function () {
    Gdrive::healthCheck();

    return response()->json([
      'status' => 'ok',
      'message' => 'Google Drive is connected successfully.',
    ]);
  });

  // List files and directories in the root folder
  Route::get('/list-files', function () {

    // List files in root directory
    $files = Gdrive::list('/');

    return response()->json([
      'status' => 'ok',
      'message' => 'Files listed successfully.',
      'data' => $files,
    ]);
  });

  // Upload a file (commonly used for small files)
  Route::get('/upload-file', function (Request $request) {
    $filePath = $request->query('path', 'test.txt');

    Gdrive::put($filePath, 'Hello, World!');

    $fileInfo = Gdrive::info($filePath);

    return response()->json([
      'status' => 'ok',
      'message' => 'File uploaded successfully.',
      'data' => $fileInfo,
    ]);
  });

  // Upload a file using stream (suitable for large files)
  Route::get('/upload-file-stream', function (Request $request) {
    $filePath = $request->query('path', 'test.pdf');

    Gdrive::putStream($filePath, fopen(storage_path('app/public/sample.pdf'), 'r'));

    $fileInfo = Gdrive::info($filePath);

    return response()->json([
      'status' => 'ok',
      'message' => 'File uploaded successfully.',
      'data' => $fileInfo,
    ]);
  });

  // Read file content (commonly used for small files)
  Route::get('/read-file-content', function (Request $request) {
    $filePath = $request->query('path', 'test.txt');

    $content = Gdrive::get($filePath);

    return response()->json([
      'status' => 'ok',
      'message' => 'File content read successfully.',
      'data' => $content,
    ]);
  });

  // Read file content using stream (suitable for large files)
  Route::get('/read-file-content-stream', function (Request $request) {
    $filePath = $request->query('path', 'test.pdf');

    $stream = Gdrive::readStream($filePath);

    $content = stream_get_contents($stream);

    return response()->json([
      'status' => 'ok',
      'message' => 'File content read successfully via stream.',
      'data' => $content,
    ]);
  });

  // Delete a file
  Route::get('/delete-file', function (Request $request) {
    $filePath = $request->query('path', 'test.txt');

    $res = Gdrive::delete($filePath);

    return response()->json([
      'status' => 'ok',
      'message' => 'File deleted successfully.',
      'data' => $res,
    ]);
  });

  // Rename a file
  Route::get('/rename-file', function (Request $request) {
    $from = $request->query('from', 'test.txt');
    $to = $request->query('to', 'test-renamed.txt');

    $res = Gdrive::rename($from, $to);

    return response()->json([
      'status' => 'ok',
      'message' => "File renamed from '{$from}' to '{$to}'.",
      'data' => $res,
    ]);
  });

  // Copy a file
  Route::get('/copy-file', function (Request $request) {
    $from = $request->query('from', 'test.txt');
    $to = $request->query('to', 'test-copy.txt');
    $res = Gdrive::copy($from, $to);
    return response()->json([
      'status' => 'ok',
      'message' => "File '{$from}' copied to '{$to}'.",
      'data' => $res,
    ]);
  });

  // Check if a file or directory exists
  Route::get('/check-exists', function (Request $request) {
    $path = $request->query('path', 'test.txt');
    $res = Gdrive::exists($path);
    return response()->json([
      'status' => 'ok',
      'message' => "'{$path}' exists.",
      'data' => $res,
    ]);
  });

  // Create a directory
  Route::get('/create-directory', function (Request $request) {
    $dir = $request->query('dir', 'test-folder');
    $res = Gdrive::makeDirectory($dir);
    return response()->json([
      'status' => 'ok',
      'message' => "Directory '{$dir}' created successfully.",
      'data' => $res,
    ]);
  });

  // Delete a directory
  Route::get('/delete-directory', function (Request $request) {
    $dir = $request->query('dir', 'test-folder');
    $res = Gdrive::deleteDirectory($dir);
    return response()->json([
      'status' => 'ok',
      'message' => "Directory '{$dir}' deleted successfully.",
      'data' => $res,
    ]);
  });

  // Download a file to local storage
  Route::get('/download-file-to-local', function (Request $request) {
    $path = $request->query('path', 'test.txt');
    $localPath = storage_path("app/public/{$path}");
    $result = Gdrive::download($path, $localPath);
    return response()->json([
      'status' => 'ok',
      'message' => 'File downloaded successfully.',
      'data' => $result,
    ]);
  });

  Route::get('/preview-file', function (Request $request) {
    $path = $request->query('path', 'test.pdf');
    $response = Gdrive::previewFile($path);
    if ($response === null) {
      return response()->json([
        'status' => 'error',
        'message' => 'File not found or cannot be previewed.',
      ], 404);
    }
    return $response;
  });
});
