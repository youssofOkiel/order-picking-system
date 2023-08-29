<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TimeSlotStatus extends Enum
{
    const Available = 'available';
    const Unavailable = 'unavailable';
}
