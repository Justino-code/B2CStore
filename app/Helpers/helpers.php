<?php
if (!function_exists('calculateDiscountPercentage')) {
    function calculateDiscountPercentage($original, $discount)
    {
        if ($original <= 0 || $discount >= $original) {
            return 0;
        }
        
        $percentage = (($original - $discount) / $original) * 100;
        return round($percentage);
    }
}

// app/Helpers/helpers.php

if (! function_exists('image_url')) {
    function image_url(?string $path): string
    {
        if (! $path) {
            return asset('images/placeholder.png');
        }

        // Se já for URL externa
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Caso seja imagem local
        return asset('storage/' . ltrim($path, '/'));
    }
}

if (! function_exists('format_kwanza')) {
    function format_kwanza(float|int $value): string
    {
        return number_format($value, 2, ',', '.') . ' Kz';
    }
}
