<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('authorize')) {
    function authorize($permission, $code = 403)
    {
        if (!hasPermission($permission)) {
            abort($code);
        }

        return true;
    }
}

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        return $user->hasPermissionTo($permission);
    }
}

if (!function_exists('filterValue')) {
    function filterValue($value)
    {
        if (is_null($value)) return $value;

        $bool = filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        if ($bool === null) {
            if (is_string($value) && json_validate($value)) {
                return array_map(function ($item) {
                    return is_string($item) ? trim($item) : $item;
                }, json_decode($value, true));
            } else {
                return $value;
            }
        }

        return $bool;
    }
}
