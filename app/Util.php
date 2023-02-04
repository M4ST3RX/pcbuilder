<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Util extends Model
{
    public static function formatSize($size_in_bytes, $in)
    {
        $size = 0;

        switch ($in)
        {
            case "B":
                $size = $size_in_bytes;
                break;
            case "KB":
                $size = $size_in_bytes / 1024;
                break;
            case "MB":
                $size = $size_in_bytes / 1024 / 1024;
                break;
            case "GB":
                $size = $size_in_bytes / 1024 / 1024 / 1024;
                break;
            case "TB":
                $size = $size_in_bytes / 1024 / 1024 / 1024 / 1024;
                break;
            case "PB":
                $size = $size_in_bytes / 1024 / 1024 / 1024 / 1024 / 1024;
                break;
        }

        return $size;
    }

    public static function formatSizeUnits($bytes, $full_name = false)
    {
        $name = "";
        $size_in_unit = 0;

        if($bytes >= 1099511627776)
        {
            $size_in_unit = round($bytes / 1099511627776, 2);
            $name = $full_name ? "TeraByte" : "TB";
        }
        elseif ($bytes >= 1073741824)
        {
            $size_in_unit = round($bytes / 1073741824, 2);
            $name = $full_name ? "GigaByte" : "GB";
        }
        elseif ($bytes >= 1048576)
        {
            $size_in_unit = round($bytes / 1048576, 2);
            $name = $full_name ? "MegaByte" : "MB";
        }
        elseif ($bytes >= 1024)
        {
            $size_in_unit = round($bytes / 1024, 2);
            $name = $full_name ? "KiloByte" : "KB";
        } else
        {
            $size_in_unit = $bytes;
            $name = $full_name ? "Byte" : "B";
        }

        if ($full_name) {
            if ($size_in_unit > 1) {
                $name .= "s";
            }
        }

        return $size_in_unit . ' ' . $name;
    }

    public static function formatHertzUnits($hertz)
    {
        if($hertz >= 1000000000)
        {
            $hertz = round($hertz / 1000000000, 2) . ' GHz';
        } else if($hertz >= 1000000){
            $hertz = round($hertz / 1000000, 2) . ' MHz';
        } else if ($hertz >= 1000) {
            $hertz = round($hertz / 1000, 2) . ' kHz';
        } else {
            $hertz = round($hertz, 2) . ' Hz';
        }

        return $hertz;
    }

    public static function formatHashRate($hash_rate) {
        return $hash_rate . ' H/s';
    }

    public static function formatPowerUnits($power) {
        return $power . " W";
    }

    public static function createCryptoWalletHash($id) {
        $salt = "e1ebadabbac7543d5369a746b4f3835a_";
        $wallet = hash('sha256',  $salt . $id);
        return $wallet;
    }

    public static function computerSlotToType($slot) {
        switch($slot) {
            case 0:
                return 1;
            case 1:
                return 2;
            case 2:
            case 3:
                return 3;
            case 4:
            case 5:
            case 6:
            case 7:
                return 4;
            case 8:
                return 6;
            case 9:
            case 10:
            case 11:
            case 12:
                return 5;
            default:
                return -1;
        }
    }

    public static function getStorageQualityRange($tier, $rarity) {
        switch($rarity) {
            default:
            case 1:
                $min = 1;
                $max = 25;
                break;
            case 2:
                $min = 10;
                $max = 125;
                break;
            case 3:
                $min = 175;
                $max = 400;
                break;
            case 4:
                $min = 375;
                $max = 900;
                break;
            case 5:
                $min = 800;
                $max = 10240;
                break;
        }

        $min *= pow(1024, $tier);
        $max *= pow(1024, $tier);

        return ['min' => $min, 'max' => $max];
    }

    public static function getPowerQualityRange($tier, $rarity)
    {
        switch ($rarity) {
            default:
            case 1:
                $min = 100;
                $max = 350;
                break;
            case 2:
                $min = 300;
                $max = 600;
                break;
            case 3:
                $min = 500;
                $max = 900;
                break;
            case 4:
                $min = 750;
                $max = 1200;
                break;
            case 5:
                $min = 1000;
                $max = 1600;
                break;
        }

        $min *= $tier * 0.25;
        $max *= $tier * 0.25;

        return ['min' => $min, 'max' => $max];
    }

    public static function getPowerUsageQualityRange($tier, $rarity, $type)
    {
        $weight = 0;
        switch($type) {
            case 1:
                $weight = 0.1;
                break;
            case 2:
                $weight = 0.5;
                break;
            case 3:
                $weight = 0.9;
                break;
            case 4:
                $weight = 0.05;
                break;
            case 5:
                $weight = 0.05;
                break;
        }

        switch ($rarity) {
            default:
            case 1:
                $min = 60;
                $max = 200;
                break;
            case 2:
                $min = 150;
                $max = 400;
                break;
            case 3:
                $min = 300;
                $max = 650;
                break;
            case 4:
                $min = 570;
                $max = 790;
                break;
            case 5:
                $min = 700;
                $max = 950;
                break;
        }

        $min *= $tier * 0.25 * $weight;
        $max *= $tier * 0.25 * $weight;

        return ['min' => $max, 'max' => $min];
    }

    public static function getHashRateQualityRange($tier, $rarity, $type)
    {
        $weight = 0;
        switch ($type) {
            case 2:
                $weight = 0.5;
                break;
            case 3:
                $weight = 1;
                break;
        }

        switch ($rarity) {
            default:
            case 1:
                $min = 250;
                $max = 450;
                break;
            case 2:
                $min = 400;
                $max = 700;
                break;
            case 3:
                $min = 600;
                $max = 950;
                break;
            case 4:
                $min = 800;
                $max = 1150;
                break;
            case 5:
                $min = 1000;
                $max = 1350;
                break;
        }

        $min *= $tier * $weight;
        $max *= $tier * $weight;

        return ['min' => $min, 'max' => $max];
    }

    public static function getCoresQualityRange($tier, $rarity)
    {
        switch ($rarity) {
            default:
            case 1:
                $min = 1;
                $max = 2;
                break;
            case 2:
                $min = 2;
                $max = 4;
                break;
            case 3:
                $min = 4;
                $max = 8;
                break;
            case 4:
                $min = 8;
                $max = 32;
                break;
            case 5:
                $min = 32;
                $max = 64;
                break;
        }

        $min *= pow(2, $tier) * 0.5;
        $max *= pow(2, $tier) * 0.5;

        return ['min' => round($min), 'max' => round($max)];
    }
}
