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
         $quality = max(0, min(100, $quality));
 
         $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
         $extension = $image->getClientOriginalExtension();
         $newFileName = $originalName . '_' . uniqid() . '.' . $extension;
 
         $tempPath = $image->getPathname();
 
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
 
         ob_start();
         switch (strtolower($extension)) {
             case 'jpeg':
             case 'jpg':
                 imagejpeg($img, null, $quality);
                 break;
             case 'png':
                 $pngQuality = (int) round(9 - ($quality / 10));
                 imagepng($img, null, $pngQuality);
                 break;
             case 'gif':
                 imagegif($img);
                 break;
         }
         $compressedImage = ob_get_clean();
         imagedestroy($img);
 
         $storagePath = $path . '/' . $newFileName;
 
         // Store the image in the storage/app/public directory
         Storage::disk('public')->put($storagePath, $compressedImage);
 
         // Generate the full URL including the domain
         return url('storage/' . $storagePath);
     }
}
