<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AssignmentStatus extends Enum
{
    const Pending = 'pending';
    const Picking = 'picking';
    const Completed = 'completed';
}
