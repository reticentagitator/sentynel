import { Permission, Role } from "./role-permissions";

export * from "./role-permissions";

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
        roles: (Role | string)[];
        permissions: Permission[];
    };
};
