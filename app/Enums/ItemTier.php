<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ItemTier extends Enum
{
    const BRONZE = 1;
    const SILVER = 2;
    const GOLD = 3;
    const PLATINUM = 4;
    const DIAMOND = 5;

}
