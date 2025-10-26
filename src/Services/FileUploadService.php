<?php

namespace MightyWeb\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload an image file.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $oldFile
     * @return string|false
     */
    public function uploadImage(UploadedFile $file, string $directory, ?string $oldFile = null)
    {
        // Validate image
        if (!$this->isValidImage($file)) {
            return false;
        }

        // Get configuration
        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $optimize = config('mightyweb.images.optimize', true);

        // Generate unique filename
        $filename = $this->generateFilename($file);
        $fullPath = $basePath . '/' . $directory . '/' . $filename;

        // Optimize and save image
        if ($optimize) {
            $this->optimizeAndSave($file, $disk, $fullPath);
        } else {
            Storage::disk($disk)->put($fullPath, file_get_contents($file->getRealPath()));
        }

        // Delete old file if exists
        if ($oldFile) {
            $this->deleteFile($directory, $oldFile);
        }

        return $filename;
    }

    /**
     * Delete a file.
     *
     * @param string $directory
     * @param string $filename
     * @return bool
     */
    public function deleteFile(string $directory, string $filename): bool
    {
        if (empty($filename)) {
            return false;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath . '/' . $directory . '/' . $filename;

        if (Storage::disk($disk)->exists($fullPath)) {
            return Storage::disk($disk)->delete($fullPath);
        }

        return false;
    }

    /**
     * Get the full URL for a file.
     *
     * @param string $directory
     * @param string $filename
     * @return string|null
     */
    public function getFileUrl(string $directory, string $filename): ?string
    {
        if (empty($filename)) {
            return null;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath . '/' . $directory . '/' . $filename;

        return Storage::disk($disk)->url($fullPath);
    }

    /**
     * Optimize and save image.
     *
     * @param UploadedFile $file
     * @param string $disk
     * @param string $path
     * @return void
     */
    protected function optimizeAndSave(UploadedFile $file, string $disk, string $path): void
    {
        $maxWidth = config('mightyweb.images.max_width', 2000);
        $maxHeight = config('mightyweb.images.max_height', 2000);
        $quality = config('mightyweb.images.quality', 85);

        // Load image
        $image = Image::make($file->getRealPath());

        // Get original dimensions
        $width = $image->width();
        $height = $image->height();

        // Resize if necessary (maintain aspect ratio)
        if ($width > $maxWidth || $height > $maxHeight) {
            $image->resize($maxWidth, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Encode with quality
        $encoded = $image->encode($file->getClientOriginalExtension(), $quality);

        // Save to storage
        Storage::disk($disk)->put($path, $encoded->__toString());
    }

    /**
     * Validate if file is a valid image.
     *
     * @param UploadedFile $file
     * @return bool
     */
    protected function isValidImage(UploadedFile $file): bool
    {
        $allowedTypes = config('mightyweb.validation.allowed_image_types', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        $maxSize = config('mightyweb.validation.max_file_size', 5120); // KB

        // Check extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedTypes)) {
            return false;
        }

        // Check file size (convert to KB)
        $fileSizeKB = $file->getSize() / 1024;
        if ($fileSizeKB > $maxSize) {
            return false;
        }

        // Check if file is actually an image
        if (!$this->isImage($file)) {
            return false;
        }

        return true;
    }

    /**
     * Check if file is an image using getimagesize.
     *
     * @param UploadedFile $file
     * @return bool
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
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        
        // Sanitize basename
        $basename = Str::slug($basename);
        
        // Generate unique name with timestamp
        return $basename . '_' . time() . '_' . Str::random(8) . '.' . $extension;
    }

    /**
     * Get image dimensions.
     *
     * @param string $directory
     * @param string $filename
     * @return array|null
     */
    public function getImageDimensions(string $directory, string $filename): ?array
    {
        if (empty($filename)) {
            return null;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath . '/' . $directory . '/' . $filename;

        if (!Storage::disk($disk)->exists($fullPath)) {
            return null;
        }

        try {
            $image = Image::make(Storage::disk($disk)->get($fullPath));
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
     * @param string $directory
     * @param string $filename
     * @param int $width
     * @param int $height
     * @return string|false
     */
    public function createThumbnail(string $directory, string $filename, int $width = 150, int $height = 150)
    {
        if (empty($filename)) {
            return false;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath . '/' . $directory . '/' . $filename;

        if (!Storage::disk($disk)->exists($fullPath)) {
            return false;
        }

        try {
            // Load original image
            $image = Image::make(Storage::disk($disk)->get($fullPath));

            // Create thumbnail
            $image->fit($width, $height);

            // Generate thumbnail filename
            $pathInfo = pathinfo($filename);
            $thumbnailName = $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
            $thumbnailPath = $basePath . '/' . $directory . '/thumbs/' . $thumbnailName;

            // Save thumbnail
            Storage::disk($disk)->put($thumbnailPath, $image->encode()->__toString());

            return $thumbnailName;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Copy file from one directory to another.
     *
     * @param string $fromDirectory
     * @param string $toDirectory
     * @param string $filename
     * @return bool
     */
    public function copyFile(string $fromDirectory, string $toDirectory, string $filename): bool
    {
        if (empty($filename)) {
            return false;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        
        $fromPath = $basePath . '/' . $fromDirectory . '/' . $filename;
        $toPath = $basePath . '/' . $toDirectory . '/' . $filename;

        if (!Storage::disk($disk)->exists($fromPath)) {
            return false;
        }

        return Storage::disk($disk)->copy($fromPath, $toPath);
    }

    /**
     * Get file size in human-readable format.
     *
     * @param string $directory
     * @param string $filename
     * @return string|null
     */
    public function getFileSize(string $directory, string $filename): ?string
    {
        if (empty($filename)) {
            return null;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $basePath = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $basePath . '/' . $directory . '/' . $filename;

        if (!Storage::disk($disk)->exists($fullPath)) {
            return null;
        }

        $bytes = Storage::disk($disk)->size($fullPath);

        return $this->formatBytes($bytes);
    }

    /**
     * Format bytes to human-readable format.
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
