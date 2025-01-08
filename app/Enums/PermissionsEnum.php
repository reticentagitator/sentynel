<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    /**
     * case NAMEINAPP = 'name-in-database';
     */

    case SHOW_USER = 'user.list';
    case UPDATE_USER = 'user.update';
    case ADD_USER = 'user.add';
    case DELETE_USER = 'user.delete';
    case MANAGE_ROLES = 'roles';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            self::SHOW_USER => 'Show User',
            self::UPDATE_USER => 'Update User',
            self::ADD_USER => 'Add User',
            self::DELETE_USER => 'Delete User',
        };
    }

    public function values(): array
    {
        return [
            self::SHOW_USER,
            self::UPDATE_USER,
            self::ADD_USER,
            self::DELETE_USER,
        ];
    }
}
