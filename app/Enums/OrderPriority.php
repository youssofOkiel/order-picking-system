<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderPriority extends Enum
{
    const High = 1;
    const Medium = 2;
    const Low = 3;
}
