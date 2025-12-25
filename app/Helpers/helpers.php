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

if (! function_exists('image_url')) {
    /**
     * Retorna a URL de uma imagem ou null se não existir.
     *
     * @param string|null $path
     * @param bool $placeholder - se true, retorna placeholder caso não exista
     * @return string|null
     */
    function image_url(?string $path, bool $placeholder = false): ?string
    {
        if (! $path) {
            return $placeholder ? asset('images/placeholder.png') : null;
        }

        // Se já for URL externa
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Caminho completo no storage
        $storagePath = storage_path('app/public/' . ltrim($path, '/'));

        // Verifica se o arquivo existe no storage
        if (! file_exists($storagePath)) {
            return $placeholder ? asset('images/placeholder.png') : null;
        }

        // Retorna a URL acessível publicamente
        return asset('storage/' . ltrim($path, '/'));
    }
}


if (! function_exists('format_kwanza')) {
    function format_kwanza(float|int $value): string
    {
        return number_format($value, 2, ',', '.') . ' Kz';
    }
}
