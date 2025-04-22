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
        $user_id = $_SESSION['user_id'] ?: null;

        if (!$user_id) {
            return false;
        }

        $stmt = $pdo->prepare('
            SELECT COUNT(*) FROM role_permissions
            INNER JOIN permissions ON role_permissions.permission_id = permissions.id
            WHERE role_permissions.role_id = (SELECT users.role_id FROM users WHERE users.id = :user_id) 
            AND permissions.permission_name = :permission_name
        ');

        $stmt->execute(['user_id' => $user_id, 'permission_name' => $permission_name]);
        return $stmt->fetchColumn() > 0;
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /* https://www.uuidgenerator.net/dev-corner/php */
    public static function generateUuid()
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
