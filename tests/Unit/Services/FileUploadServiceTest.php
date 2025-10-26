<?php

namespace MightyWeb\Tests\Unit\Services;

use MightyWeb\Services\FileUploadService;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileUploadServiceTest extends TestCase
{
    use RefreshDatabase;

    protected FileUploadService $service;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->service = new FileUploadService();
    }

    /** @test */
    public function it_can_upload_a_file()
    {
        $file = UploadedFile::fake()->image('test.jpg');
        
        $path = $this->service->uploadFile($file, 'test-directory');

        $this->assertNotNull($path);
        $this->assertStringContainsString('test-directory/', $path);
        Storage::disk('public')->assertExists($path);
    }

    /** @test */
    public function it_generates_unique_filenames()
    {
        $file1 = UploadedFile::fake()->image('test.jpg');
        $file2 = UploadedFile::fake()->image('test.jpg');

        $path1 = $this->service->uploadFile($file1, 'test-directory');
        $path2 = $this->service->uploadFile($file2, 'test-directory');

        $this->assertNotEquals($path1, $path2);
    }

    /** @test */
    public function it_can_delete_a_file()
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $path = $this->service->uploadFile($file, 'test-directory');

        Storage::disk('public')->assertExists($path);

        $result = $this->service->deleteFile($path);

        $this->assertTrue($result);
        Storage::disk('public')->assertMissing($path);
    }

    /** @test */
    public function it_handles_non_existent_file_deletion_gracefully()
    {
        $result = $this->service->deleteFile('non-existent-file.jpg');

        $this->assertFalse($result);
    }

    /** @test */
    public function it_validates_image_file_types()
    {
        $validFile = UploadedFile::fake()->image('image.jpg');
        $path = $this->service->uploadFile($validFile, 'test-directory');

        $this->assertNotNull($path);
    }

    /** @test */
    public function it_preserves_original_file_extension()
    {
        $jpgFile = UploadedFile::fake()->image('test.jpg');
        $pngFile = UploadedFile::fake()->image('test.png');

        $jpgPath = $this->service->uploadFile($jpgFile, 'test-directory');
        $pngPath = $this->service->uploadFile($pngFile, 'test-directory');

        $this->assertStringEndsWith('.jpg', $jpgPath);
        $this->assertStringEndsWith('.png', $pngPath);
    }

    /** @test */
    public function it_creates_directory_if_not_exists()
    {
        $file = UploadedFile::fake()->image('test.jpg');
        
        $path = $this->service->uploadFile($file, 'new-test-directory/subdirectory');

        $this->assertNotNull($path);
        $this->assertStringContainsString('new-test-directory/subdirectory/', $path);
        Storage::disk('public')->assertExists($path);
    }
}
