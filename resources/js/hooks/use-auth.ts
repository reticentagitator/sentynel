import { PageProps, Permission, Role } from "@/types";
import { usePage } from "@inertiajs/react";

export const useAuth = () => {
    const {
        props: { auth },
    } = usePage<PageProps>();

    const hasRole = (role: Role | string) => auth.roles.includes(role);
    const hasPermission = (permission: Permission) =>
        auth.permissions.includes(permission);

    return {
        user: auth.user,
        roles: auth.roles,
        permissions: auth.permissions,

        hasRole,
        hasPermission,
    };
};
