<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class ImageHelper
{
    /**
     * Konversi gambar ke base64
     */
    public static function imageToBase64($path)
    {
        try {
            if (!file_exists($path)) {
                Log::error("Image file not found: $path");
                return '';
            }

            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return base64_encode($data);
        } catch (\Exception $e) {
            Log::error("Failed to convert image to base64: " . $e->getMessage());
            return '';
        }
    }
}
