<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ItemType extends Enum
{
    const MOTHERBOARD = 1;
    const PROCESSOR = 2;
    const GRAPHICS_CARD = 3;
    const HARD_DRIVE = 4;
    const MEMORY = 5;
    const POWER_SUPPLY = 6;

}
