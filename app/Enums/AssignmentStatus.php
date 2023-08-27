<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AssignmentStatus extends Enum
{
    const Assigned = 'assigned';
    const Completed = 'completed';
}
