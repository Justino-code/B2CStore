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


if (!function_exists('format_kwanza')) {
    /**
     * Formata um valor em Kwanza (AOA)
     */
    function format_kwanza($valor, $decimals = 2, $decimalSeparator = ',', $thousandsSeparator = '.', $simboly=' AOA')
    {
        if (!is_numeric($valor)) {
            return '0,00'. $simboly;
        }
        
        return number_format($valor, $decimals, $decimalSeparator, $thousandsSeparator) . $simboly;
    }
}


if (!function_exists('formatar_endereco')) {
    function formatar_endereco($enderecoTexto)
    {
        if (empty($enderecoTexto)) {
            return 'Endereço não informado';
        }
        
        $partes = explode(',', $enderecoTexto);
        $partes = array_map('trim', $partes);
        
        if (count($partes) >= 5) {
            return sprintf(
                '%s, %s - %s, %s/%s',
                $partes[0],
                $partes[1],
                $partes[2],
                $partes[3],
                $partes[4]
            );
        }
        
        return $enderecoTexto;
    }
}

if (!function_exists('extrair_endereco_array')) {
    function extrair_endereco_array($enderecoTexto)
    {
        if (empty($enderecoTexto)) {
            return null;
        }
        
        $partes = explode(',', $enderecoTexto);
        $partes = array_map('trim', $partes);
        $partes = array_pad($partes, 6, '');
        
        return [
            'logradouro' => $partes[0] ?? '',
            'numero' => $partes[1] ?? '',
            'bairro' => $partes[2] ?? '',
            'cidade' => $partes[3] ?? '',
            'estado' => $partes[4] ?? '',
            'cep' => $partes[5] ?? '',
        ];
    }
}
