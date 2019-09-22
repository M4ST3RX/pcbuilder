<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Util extends Model
{
    public static function formatSize($size_in_mb, $in)
    {
        $size = 0;

        switch ($in)
        {
            case "B":
                $size = $size_in_mb * 1024 * 1024;
                break;
            case "KB":
                $size = $size_in_mb * 1024;
                break;
            case "MB":
                $size = $size_in_mb;
                break;
            case "GB":
                $size = $size_in_mb / 1024;
                break;
            case "TB":
                $size = $size_in_mb / 1024 / 1024;
                break;
            case "PB":
                $size = $size_in_mb / 1024 / 1024 / 1024;
                break;
        }

        return $size;
    }

    public static function formatSizeUnits($size_in_mb)
    {
        $bytes = $size_in_mb * 1024 * 1024;
        if($bytes >= 1099511627776)
        {
            $bytes = round($bytes / 1099511627776, 2) . ' TB';
        }
        elseif ($bytes >= 1073741824)
        {
            $bytes = round($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = round($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = round($bytes / 1024, 2) . ' KB';
        }

        return $bytes;
    }

    public static function formatHertzUnits($megahertz)
    {
        if($megahertz >= 1000)
        {
            $hertz = round($megahertz / 1000, 2) . ' GHz';
        } else {
            $hertz = round($megahertz, 2) . ' MHz';
        }

        return $hertz;
    }
}
