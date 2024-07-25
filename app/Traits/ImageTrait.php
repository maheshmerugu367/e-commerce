<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    /**
     * Compress and store an image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $path
     * @param int $quality
     * @return string
     */
    public function compressAndStoreImage($image, $path, $quality = 75)
    {
        // Get the original file name and extension
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $newFileName = $originalName . '_' . uniqid() . '.' . $extension;

        // Get the temporary path of the uploaded file
        $tempPath = $image->getPathname();

        // Create a GD image resource
        switch (strtolower($extension)) {
            case 'jpeg':
            case 'jpg':
                $img = imagecreatefromjpeg($tempPath);
                break;
            case 'png':
                $img = imagecreatefrompng($tempPath);
                break;
            case 'gif':
                $img = imagecreatefromgif($tempPath);
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        // Compress the image and save it to a buffer
        ob_start();
        switch (strtolower($extension)) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($img, null, $quality);
                break;
            case 'png':
                $pngQuality = ($quality - 100) / 11.111111;
                $pngQuality = round(abs($pngQuality));
                imagepng($img, null, $pngQuality);
                break;
            case 'gif':
                imagegif($img);
                break;
        }
        $compressedImage = ob_get_clean();

        // Free up memory
        imagedestroy($img);

        // Define the storage path
        $storagePath = $path . '/' . $newFileName;

        // Store the image in the storage/app/public directory
        Storage::disk('public')->put($storagePath, $compressedImage);

        // Return the image path
        return $storagePath;
    }
}
