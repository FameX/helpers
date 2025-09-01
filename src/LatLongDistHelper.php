<?php
declare(strict_types=1);

namespace Famex\Helpers;

class LatLongDistHelper
{
    public static function calculate(float $lat1, float $lon1, float $lat2, float $lon2, string $unit = "K"): float
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit === "K") {
            return ($miles * 1.609344);
        }

        if ($unit === "N") {
            return ($miles * 0.8684);
        }

        return $miles;
    }
}