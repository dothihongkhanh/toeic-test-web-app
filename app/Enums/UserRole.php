<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Admin()
 * @method static static Client()
 */
final class UserRole extends Enum
{
    const Admin = 1;
    const Client = 2;
}
