<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ItemRarity extends Enum
{
    const NORMAL = 1;
    const PLUS = 2;
    const PRO = 3;
    const ELITE = 4;
    const MASTER = 5;

    public static function getDescription(mixed $value): string
    {
        switch ($value)
        {
            case self::NORMAL:
                return "";
            default:
                return self::getKey($value);

        }
    }
}
