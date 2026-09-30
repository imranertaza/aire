<?php

namespace App\Services\Common;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Default storage disk.
     */
    protected string $defaultDisk = 'public';

    /**
     * Upload an uploaded file to the specified directory.
     *
     * @param UploadedFile $file The file from request
     * @param string $directory Target directory (e.g. 'customers/pics', 'products')
     * @param string|null $disk Storage disk ('public', 'local', 's3')
     * @param string|null $customFilename Optional custom filename without extension
     * @return string Relative stored path (e.g. 'customers/pics/abc123xyz.jpg')
     */
    public function upload(
        UploadedFile $file,
        string $directory = 'uploads',
        ?string $disk = null,
        ?string $customFilename = null
    ): string {
        $disk = $disk ?? $this->defaultDisk;
        $directory = trim($directory, '/');

        if ($customFilename) {
            $extension = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
            $cleanName = Str::slug(pathinfo($customFilename, PATHINFO_FILENAME));
            $filename = $cleanName . '.' . strtolower($extension);

            return $file->storeAs($directory, $filename, $disk);
        }

        return $file->store($directory, $disk);
    }

    /**
     * Replace an old file with a new uploaded file.
     * Automatically removes the old file from disk if present.
     *
     * @param UploadedFile|null $newFile New uploaded file (if provided)
     * @param string $directory Target directory
     * @param string|null $oldPath Existing file path to delete
     * @param string|null $disk Storage disk
     * @param string|null $customFilename Optional custom filename
     * @return string|null New file path if uploaded, or old file path if no new file provided
     */
    public function replace(
        ?UploadedFile $newFile,
        string $directory,
        ?string $oldPath = null,
        ?string $disk = null,
        ?string $customFilename = null
    ): ?string {
        if (! $newFile instanceof UploadedFile) {
            return $oldPath;
        }

        // Delete old file if exists
        $this->delete($oldPath, $disk);

        // Upload new file with custom filename
        return $this->upload($newFile, $directory, $disk, $customFilename);
    }

    /**
     * Upload an image file and resize/fit it to specific dimensions.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int|null $width
     * @param int|null $height
     * @param string|null $disk
     * @param string|null $customFilename
     * @return string
     */
    public function uploadAndFit(
        UploadedFile $file,
        string $directory = 'uploads',
        ?int $width = null,
        ?int $height = null,
        ?string $disk = null,
        ?string $customFilename = null
    ): string {
        $path = $this->upload($file, $directory, $disk, $customFilename);

        if ($width !== null || $height !== null) {
            $disk = $disk ?? $this->defaultDisk;
            $fullPath = Storage::disk($disk)->path($path);

            if (class_exists(\Intervention\Image\Facades\Image::class) && file_exists($fullPath)) {
                try {
                    $img = \Intervention\Image\Facades\Image::make($fullPath);
                    if ($width && $height) {
                        $img->fit($width, $height);
                    } elseif ($width) {
                        $img->widen($width, function ($constraint) {
                            $constraint->upsize();
                        });
                    } elseif ($height) {
                        $img->heighten($height, function ($constraint) {
                            $constraint->upsize();
                        });
                    }
                    $img->save();
                } catch (\Throwable) {
                    // Fallback to original image if processing fails
                }
            }
        }

        return $path;
    }

    /**
     * Replace an old image with a new one and fit it to dimensions.
     *
     * @param UploadedFile|null $newFile
     * @param string $directory
     * @param int|null $width
     * @param int|null $height
     * @param string|null $oldPath
     * @param string|null $disk
     * @param string|null $customFilename
     * @return string|null
     */
    public function replaceAndFit(
        ?UploadedFile $newFile,
        string $directory,
        ?int $width = null,
        ?int $height = null,
        ?string $oldPath = null,
        ?string $disk = null,
        ?string $customFilename = null
    ): ?string {
        if (! $newFile instanceof UploadedFile) {
            return $oldPath;
        }

        $this->delete($oldPath, $disk);

        return $this->uploadAndFit($newFile, $directory, $width, $height, $disk, $customFilename);
    }

    /**
     * Delete a file safely from disk without throwing exceptions.
     *
     * @param string|null $path Relative path of the file
     * @param string|null $disk Storage disk
     * @return bool True if deleted or already non-existent, false on failure
     */
    public function delete(?string $path, ?string $disk = null): bool
    {
        if (empty($path)) {
            return true;
        }

        $disk = $disk ?? $this->defaultDisk;

        try {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->delete($path);
            }
        } catch (\Throwable) {
            return false;
        }

        return true;
    }

    /**
     * Upload multiple files into a directory.
     *
     * @param array<int, UploadedFile> $files
     * @param string $directory
     * @param string|null $disk
     * @return array<int, string> Array of uploaded paths
     */
    public function uploadMultiple(array $files, string $directory = 'uploads', ?string $disk = null): array
    {
        $paths = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->upload($file, $directory, $disk);
            }
        }

        return $paths;
    }

    /**
     * Delete multiple files from disk safely.
     *
     * @param array<int, string|null> $paths
     * @param string|null $disk
     * @return void
     */
    public function deleteMultiple(array $paths, ?string $disk = null): void
    {
        foreach ($paths as $path) {
            $this->delete($path, $disk);
        }
    }
}
