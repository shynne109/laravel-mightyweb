<?php

namespace MightyWeb\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class FileUploadService
{
    /**
     * Upload an image file.
     *
     * @return string|false
     */
    public function uploadImage(UploadedFile $file, string $directory, ?string $oldFile = null, $width = null, $height = null)
    {
        // Validate image
        if (! $this->isValidImage($file)) {
            return false;
        }

        // Get configuration
        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $optimize = config('mightyweb.images.optimize', true);
        $visibility = config('mightyweb.storage.visibility', 'public');

        // Generate unique filename
        $filename = $this->generateFilename($file);
        $fullPath = $basePath.'/'.$directory.'/'.$filename;

        // Optimize and save image
        if ($optimize) {
            $this->optimizeAndSave($file, $disk, $fullPath, $width, $height);
        } else {
            Storage::disk($disk)->put($fullPath, file_get_contents($file->getRealPath()));
        }

        // Set visibility for cloud disks (S3, etc.)
        Storage::disk($disk)->setVisibility($fullPath, $visibility);

        // Delete old file if exists
        if ($oldFile) {
            $this->deleteOldFile($oldFile);
        }

        // Return full URL instead of just filename
        return $this->getFileUrl($directory, $filename);
    }

    /**
     * Delete a file by directory and filename.
     */
    public function deleteFile(string $directory, string $filename): bool
    {
        if (empty($filename)) {
            return false;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath.'/'.$directory.'/'.$filename;

        if (Storage::disk($disk)->exists($fullPath)) {
            return Storage::disk($disk)->delete($fullPath);
        }

        return false;
    }

    /**
     * Delete an old file from a URL or storage path.
     */
    public function deleteOldFile(string $fileUrlOrPath): bool
    {
        if (empty($fileUrlOrPath)) {
            return false;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $storagePath = $this->resolveStoragePath($fileUrlOrPath);

        if ($storagePath && Storage::disk($disk)->exists($storagePath)) {
            return Storage::disk($disk)->delete($storagePath);
        }

        return false;
    }

    /**
     * Resolve a URL or path to a relative storage path.
     */
    protected function resolveStoragePath(string $fileUrlOrPath): ?string
    {
        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');

        // If it's already a relative path containing the base path, return as-is
        if (str_contains($fileUrlOrPath, $basePath) && ! str_starts_with($fileUrlOrPath, 'http')) {
            return $fileUrlOrPath;
        }

        // Extract path from full URL by comparing against the disk's base URL
        $diskUrl = rtrim(Storage::disk($disk)->url(''), '/');
        if (str_starts_with($fileUrlOrPath, $diskUrl)) {
            return ltrim(str_replace($diskUrl, '', $fileUrlOrPath), '/');
        }

        // Try to extract the storage-relative path from any URL
        if (str_contains($fileUrlOrPath, $basePath)) {
            $pos = strpos($fileUrlOrPath, $basePath);

            return substr($fileUrlOrPath, $pos);
        }

        return null;
    }

    /**
     * Get the full URL for a file.
     */
    public function getFileUrl(string $directory, string $filename): ?string
    {
        if (empty($filename)) {
            return null;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath.'/'.$directory.'/'.$filename;

        return Storage::disk($disk)->url($fullPath);
    }

    /**
     * Optimize and save image.
     */
    protected function optimizeAndSave(UploadedFile $file, string $disk, string $path, $imageWidth = null, $imageHeight = null): void
    {
        $maxWidth = config('mightyweb.images.max_width', 2000);
        $maxHeight = config('mightyweb.images.max_height', 2000);
        $quality = config('mightyweb.images.quality', 85);

        $image = ImageManager::gd()->read($file);

        $width = $image->width();
        $height = $image->height();

        if ($imageWidth != null || $imageHeight != null) {
            $image->resize($imageWidth, $imageHeight);
        }

        if ($width > $maxWidth || $height > $maxHeight) {
            $image->resize($maxWidth, $maxHeight);
        }

        // Encode preserving original format
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $encoded = match ($extension) {
            'jpg', 'jpeg' => $image->toJpeg($quality),
            'webp' => $image->toWebp($quality),
            'gif' => $image->toGif(),
            default => $image->toPng(),
        };

        Storage::disk($disk)->put($path, $encoded->__toString());
    }

    /**
     * Validate if file is a valid image.
     */
    protected function isValidImage(UploadedFile $file): bool
    {
        $allowedTypes = config('mightyweb.validation.allowed_image_types', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        $maxSize = config('mightyweb.validation.max_file_size', 5120); // KB

        // Check extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (! in_array($extension, $allowedTypes)) {
            return false;
        }

        // Check file size (convert to KB)
        $fileSizeKB = $file->getSize() / 1024;
        if ($fileSizeKB > $maxSize) {
            return false;
        }

        // Check if file is actually an image
        if (! $this->isImage($file)) {
            return false;
        }

        return true;
    }

    /**
     * Check if file is an image using getimagesize.
     */
    protected function isImage(UploadedFile $file): bool
    {
        try {
            $imageInfo = @getimagesize($file->getRealPath());

            return $imageInfo !== false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Generate a unique filename.
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Sanitize basename
        $basename = Str::slug($basename);

        // Generate unique name with timestamp
        return $basename.'_'.time().'_'.Str::random(8).'.'.$extension;
    }

    /**
     * Get image dimensions.
     */
    public function getImageDimensions(string $directory, string $filename): ?array
    {
        if (empty($filename)) {
            return null;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath.'/'.$directory.'/'.$filename;

        if (! Storage::disk($disk)->exists($fullPath)) {
            return null;
        }

        try {
            $image = ImageManager::gd()->read(Storage::disk($disk)->get($fullPath));

            return [
                'width' => $image->width(),
                'height' => $image->height(),
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Create thumbnail from image.
     *
     * @return string|false
     */
    public function createThumbnail(string $directory, string $filename, int $width = 150, int $height = 150)
    {
        if (empty($filename)) {
            return false;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath.'/'.$directory.'/'.$filename;

        if (! Storage::disk($disk)->exists($fullPath)) {
            return false;
        }

        try {
            // Load original image
            $image = ImageManager::gd()->read(Storage::disk($disk)->get($fullPath));
            // Create thumbnail
            $image->cover($width, $height, 'center');

            // Generate thumbnail filename
            $pathInfo = pathinfo($filename);
            $thumbnailName = $pathInfo['filename'].'_thumb.'.$pathInfo['extension'];
            $thumbnailPath = $basePath.'/'.$directory.'/thumbs/'.$thumbnailName;

            // Save thumbnail
            Storage::disk($disk)->put($thumbnailPath, $image->encode()->__toString());

            return $thumbnailName;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Copy file from one directory to another.
     */
    public function copyFile(string $fromDirectory, string $toDirectory, string $filename): bool
    {
        if (empty($filename)) {
            return false;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');

        $fromPath = $basePath.'/'.$fromDirectory.'/'.$filename;
        $toPath = $basePath.'/'.$toDirectory.'/'.$filename;

        if (! Storage::disk($disk)->exists($fromPath)) {
            return false;
        }

        return Storage::disk($disk)->copy($fromPath, $toPath);
    }

    /**
     * Get file size in human-readable format.
     */
    public function getFileSize(string $directory, string $filename): ?string
    {
        if (empty($filename)) {
            return null;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath.'/'.$directory.'/'.$filename;

        if (! Storage::disk($disk)->exists($fullPath)) {
            return null;
        }

        $bytes = Storage::disk($disk)->size($fullPath);

        return $this->formatBytes($bytes);
    }

    /**
     * Format bytes to human-readable format.
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision).' '.$units[$pow];
    }
}
