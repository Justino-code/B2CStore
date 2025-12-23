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