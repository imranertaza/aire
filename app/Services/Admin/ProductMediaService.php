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
     * Upload or update quickview product image.
     */
    public function saveQuickviewImage(UploadedFile $file, Product $product): string
    {
        $oldImage = $product->quickview_image;
        if (!empty($oldImage)) {
            \App\Services\ImageService::clearCache($oldImage);
        }

        $baseName = Str::slug($product->name ?: 'product') . '-quickview';
        $filename = $baseName . '-' . time();
        $path = $this->fileUploadService->replace(
            $file,
            "product/{$product->id}",
            $oldImage,
            $this->disk,
            $filename
        );

        $product->update(['quickview_image' => $path]);

        return $path;
    }

    /**
     * Save gallery images for a product.
     *
     * @param array<UploadedFile> $files
     * @param array<int, int> $sortOrders
     */
    public function saveGalleryImages(array $files, Product $product, array $sortOrders = []): void
    {
        foreach ($files as $index => $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $mime = $file->getMimeType() ?: '';
            $extension = strtolower($file->getClientOriginalExtension());
            $isVideo = str_starts_with($mime, 'video/') || in_array($extension, ['mp4', 'webm', 'mov', 'ogg', 'mkv']);
            $fileType = $isVideo ? 'video' : 'image';

            $sortOrder = isset($sortOrders[$index]) ? (int)$sortOrders[$index] : $index;

            $productImage = ProductImage::create([
                'product_id' => $product->id,
                'image'      => '',
                'file_type'  => $fileType,
                'sort_order' => $sortOrder,
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

            $productImage->update([
                'image'     => $path,
                'file_type' => $fileType,
            ]);
        }
    }

    /**
     * Save external gallery video links (YouTube, Vimeo, direct video URL) for a product.
     *
     * @param array $videos Array of items: [['url' => '...', 'file_type' => 'youtube', 'sort_order' => 0], ...]
     */
    public function saveGalleryVideos(array $videos, Product $product): void
    {
        foreach ($videos as $item) {
            $url = trim((string)($item['url'] ?? ''));
            if (empty($url)) {
                continue;
            }

            $fileType = $item['file_type'] ?? 'youtube';
            if (!in_array($fileType, ['youtube', 'vimeo', 'video'])) {
                if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
                    $fileType = 'youtube';
                } elseif (str_contains($url, 'vimeo.com')) {
                    $fileType = 'vimeo';
                } else {
                    $fileType = 'video';
                }
            }

            $sortOrder = isset($item['sort_order']) ? (int)$item['sort_order'] : 0;

            ProductImage::create([
                'product_id' => $product->id,
                'image'      => $url,
                'file_type'  => $fileType,
                'sort_order' => $sortOrder,
                'alt_name'   => $product->name,
                'createdBy'  => Auth::id(),
                'updatedBy'  => Auth::id(),
            ]);
        }
    }

    /**
     * Update sort orders for existing gallery images.
     *
     * @param array<int|string, int|string> $sortOrders Key is product_image ID, value is sort_order
     */
    public function updateGallerySortOrders(array $sortOrders, int $productId): void
    {
        foreach ($sortOrders as $imageId => $order) {
            ProductImage::where('id', (int)$imageId)
                ->where('product_id', $productId)
                ->update(['sort_order' => (int)$order]);
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
                if ($img->file_type !== 'video') {
                    \App\Services\ImageService::clearCache($img->image);
                }
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
