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
   
     public function compressAndStoreImagewithURL($image, $path, $quality = 75)
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


     public function compressAndStoreImagewithDimensions($file, $w = 100, $h = 100, $crop = true, $quality = 75)
     {
         // Ensure quality is between 0 and 100
         $quality = max(0, min(100, $quality));
     
         // Get image dimensions and type
         list($width, $height, $imageType) = getimagesize($file);
         $r = $width / $height;
     
         if ($crop) {
             if ($width > $height) {
                 $width = ceil($width - ($width * abs($r - $w / $h)));
             } else {
                 $height = ceil($height - ($height * abs($r - $w / $h)));
             }
             $newwidth = $w;
             $newheight = $h;
         } else {
             if ($w / $h > $r) {
                 $newwidth = $h * $r;
                 $newheight = $h;
             } else {
                 $newheight = $w / $r;
                 $newwidth = $w;
             }
         }
     
         // Create a new image from the file based on its type
         switch ($imageType) {
             case IMAGETYPE_JPEG:
                 $src = imagecreatefromjpeg($file);
                 break;
             case IMAGETYPE_PNG:
                 $src = imagecreatefrompng($file);
                 break;
             case IMAGETYPE_GIF:
                 $src = imagecreatefromgif($file);
                 break;
             default:
                 throw new \Exception('Unsupported image type');
         }
     
         // Create a new true color image
         $dst = imagecreatetruecolor($newwidth, $newheight);
     
         // Preserve transparency for PNG and GIF
         if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
             imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
             imagealphablending($dst, false);
             imagesavealpha($dst, true);
         }
     
         // Copy and resize the image
         imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
     
         // Create a new true color image with the desired dimensions
         $finalDst = imagecreatetruecolor($w, $h);
     
         // Copy and resize the image to the final destination
         imagecopyresampled($finalDst, $dst, 0, 0, 0, 0, $w, $h, $newwidth, $newheight);
     
         // Generate the new filename
         $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
         $extension = image_type_to_extension($imageType, false); // Get extension without dot
         $newFileName = $originalName . '_' . uniqid() . '.' . $extension;
         $uploadsPath = 'public/uploads/' . $newFileName; // Save without 'public/'
     
         // Save the resized image to the storage/uploads directory
         ob_start();
         switch ($imageType) {
             case IMAGETYPE_JPEG:
                 imagejpeg($finalDst, null, $quality);
                 break;
             case IMAGETYPE_PNG:
                 $pngQuality = 9 - ($quality / 10); // Convert quality to PNG scale (0-9)
                 imagepng($finalDst, null, $pngQuality);
                 break;
             case IMAGETYPE_GIF:
                 imagegif($finalDst);
                 break;
         }
         $imageData = ob_get_contents();
         ob_end_clean();
     
         Storage::put($uploadsPath, $imageData);
     
         // Clean up
         imagedestroy($src);
         imagedestroy($dst);
         imagedestroy($finalDst);

         $new_uploadsPath = 'uploads/' . $newFileName; // Save without 'public/'
     
         // Return the path to the stored image
         return $new_uploadsPath;
     }
     






    
   
    

     
     
}
