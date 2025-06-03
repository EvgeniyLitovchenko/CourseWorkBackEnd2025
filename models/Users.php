<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property bool $isSuperAdmin
 * @property string $created_at
 */
class Users extends Model
{
    public static $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public static function isAdminLogin()
    {
        return isset($_SESSION['user']);
    }
    public static function isSuperAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']["isSuperAdmin"];
    }
    public static function login($username, $password)
    {
        $user = self::findByCondition(['username' => $username])[0] ?? null;
        if ($user && $password === $user['password_hash']) {
            unset($user['password_hash']);
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }
}
