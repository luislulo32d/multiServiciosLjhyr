<?php
namespace App\Helpers;

class Money
{
    public static function bsDesdeUsd(float $usd, float $tasa): float
    {
        return round($usd * $tasa, 2);
    }

    public static function usdDesdeBs(float $bs, float $tasa): float
    {
        return $tasa > 0 ? round($bs / $tasa, 2) : 0;
    }
}
