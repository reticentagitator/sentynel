export type Role = "super-admin" | "admin" | "user";

export type UserPermissions =
    | "user.list"
    | "user.add"
    | "user.update"
    | "user.delete";

export type ShopPermissions =
    | "shop.list"
    | "shop.add"
    | "shop.update"
    | "shop.delete";

export type Permission = UserPermissions | ShopPermissions;

export type RolePermissions = {
    [key in Role]: Permission[];
};
