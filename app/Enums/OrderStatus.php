<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const Pending = 'pending';
    const Picked = 'picked';
    const Delivered = 'delivered';
}
