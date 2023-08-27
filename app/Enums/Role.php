<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Role extends Enum
{
    const BusinessOwner = 'business_owner';
    const Picker = 'picker';
}
