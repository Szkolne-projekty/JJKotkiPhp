<?php

class Utils
{
    public static function getEnv($key, $default = null)
    {
        return getenv($key) ?: $default;
    }

    public static function redirect($url)
    {
        header("Location: $url");
        exit();
    }

    public static function hasPermission($permission_name)
    {
        global $pdo;
        $role_id = $_SESSION['role_id'];

        $stmt = $pdo->prepare('
            SELECT COUNT(*) FROM role_permissions
            INNER JOIN permissions ON role_permissions.permission_id = permissions.id
            WHERE role_permissions.role_id = :role_id AND permissions.permission_name = :permission_name
        ');

        $stmt->execute(['role_id' => $role_id, 'permission_name' => $permission_name]);
        return $stmt->fetchColumn() > 0;
    }

    public static function isLoggedIn()
    {
        session_start();
        return isset($_SESSION['user_id']);
    }
}
