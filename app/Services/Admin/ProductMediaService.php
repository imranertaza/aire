<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\Common\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductMediaService
{
    protected string $disk = 'public';
    protected FileUploadService $fileUploadService;

    public function __construct(?FileUploadService $fileUploadService = null)
    {
        $this->fileUploadService = $fileUploadService ?? app(FileUploadService::class);
    }

    /**
     * Upload or update main product image.
     */
    public function saveMainImage(UploadedFile $file, Product $product): string
    {
        $oldImage = $product->main_image;
        if (!empty($oldImage)) {
            \App\Services\ImageService::clearCache($oldImage);
        }

        $baseName = Str::slug($product->name ?: 'product');
        $filename = $baseName . '-' . time();
        $path = $this->fileUploadService->replace(
            $file,
            "product/{$product->id}",
            $oldImage,
            $this->disk,
            $filename
        );

        $product->update(['main_image' => $path]);

        return $path;
    }

    /**
     * Save gallery images for a product.
     *
     * @param array<UploadedFile> $files
     */
    public function saveGalleryImages(array $files, Product $product): void
    {
        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $productImage = ProductImage::create([
                'product_id' => $product->id,
                'image'      => '',
                'alt_name'   => $product->name,
                'createdBy'  => Auth::id(),
                'updatedBy'  => Auth::id(),
            ]);

            $filename = Str::slug($product->name) . '-' . $productImage->id;
            $path = $this->fileUploadService->upload(
                $file,
                "product/{$product->id}/gallery",
                $this->disk,
                $filename
            );

            $productImage->update(['image' => $path]);
        }
    }

    /**
     * Delete specific gallery images by IDs.
     *
     * @param array<int> $imageIds
     */
    public function deleteGalleryImages(array $imageIds, int $productId): void
    {
        $images = ProductImage::where('product_id', $productId)
            ->whereIn('id', $imageIds)
            ->get();

        foreach ($images as $img) {
            if (!empty($img->image)) {
                \App\Services\ImageService::clearCache($img->image);
            }
            $this->deleteFile($img->image);
            $img->delete();
        }
    }

    /**
     * Upload an auxiliary file (e.g. PDF, section image).
     */
    public function uploadAuxiliaryFile(UploadedFile $file, int $productId, string $subfolder = '', string $prefix = 'file'): string
    {
        $filename = $prefix . '_' . time();
        $targetDir = $subfolder ? "product/{$productId}/{$subfolder}" : "product/{$productId}";

        return $this->fileUploadService->upload($file, $targetDir, $this->disk, $filename);
    }

    /**
     * Copy an existing file to a new location.
     */
    public function copyFile(?string $sourcePath, string $destinationDir, string $filename): ?string
    {
        return $this->fileUploadService->copy($sourcePath, $destinationDir, $filename, $this->disk);
    }

    /**
     * Check if a file exists.
     */
    public function fileExists(?string $path): bool
    {
        return $this->fileUploadService->exists($path, $this->disk);
    }

    /**
     * Delete a single file if it exists.
     */
    public function deleteFile(?string $path): void
    {
        $this->fileUploadService->delete($path, $this->disk);
    }

    /**
     * Completely remove a product's storage directory.
     */
    public function deleteProductDirectory(int $productId): void
    {
        $this->fileUploadService->deleteDirectory("product/{$productId}", $this->disk);
    }
}
