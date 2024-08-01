<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ImageDelete
{

    public function deleteImage($url)
{

   

// Parse the URL
$parsed_url = parse_url($url);

// Check if the parsed URL contains a path
if (isset($parsed_url['path'])) {
    // Get the full path
    $full_path = $_SERVER['DOCUMENT_ROOT'] . $parsed_url['path'];

    // Check if the file exists and attempt to delete it
    if (file_exists($full_path)) {
        if (unlink($full_path)) {
        } else {
        }
    } else {
        // echo 'File not found.';
    }
} else {
    echo 'Invalid URL format.';
}

    

}

}