<?php

namespace Database;

use Config\AccessLevel;
use Exception\DbException;

/*
 * Users Table
 */

class UserInfo
{
    /**
     * Get Password Hash
     * @param string $username
     * @return string
     * @throws DbException in case of SQL error
     */
    public static function getPasswordHash(string $username): string
    {
        return MySQLi::stmt("select password from users where username = ?", "s", $username)
            ->getStringAndClose();
    }

    /**
     * Check User for exists
     * @param string $name
     * @return bool
     * @throws DbException in case of SQL error
     */
    public static function checkNameExist(string $name): bool
    {
        return MySQLi::stmt("select count(id) from users where name = ?", "s", $name)->getStringAndClose();
    }

    /**
     * Check User for exists
     * @param string $username
     * @return bool
     * @throws DbException in case of SQL error
     */
    public static function checkUsernameExist(string $username): bool
    {
        return MySQLi::stmt("select count(id) from users where username = ?", "s", $username)
            ->getBoolAndClose();
    }

    /**
     * Check Email for exists
     * @param string $email
     * @return bool
     * @throws DbException in case of SQL error
     */
    public static function checkEmailExist(string $email): bool
    {
        return MySQLi::stmt("select count(id) from users where email = ?", "s", $email)->getBoolAndClose();
    }

    /**
     * Add User
     * @param string $name
     * @param string $username
     * @param string $email
     * @param string $password
     * @param int $accessLevel
     * @return int (quote id)
     */
    public static function add(string $name, string $username, string $email, string $password, int $accessLevel = AccessLevel::NOT_CONFIRMED): int
    {
        return MySQLi::stmt("insert into users (name, username, email, password, access_level) values (?, ?, ?, ?, ?)",
            "ssssi", $name, $username, $email, $password, $accessLevel)->getInsertedIdAndClose();
    }

    /**
     * Update Last login field
     * @param string $username
     * @throws DbException in case of SQL error
     */
    public static function updateLastLogin(string $username)
    {
        MySQLi::stmt("update users set last_login = current_timestamp() where username = ?",
            "s", $username)->close();
    }

    /**
     * Get Access Level
     * @param ?string $username
     * @return int
     * @throws DbException in case of SQL error
     */
    public static function getAccessLevel(?string $username): int
    {
        return MySQLi::stmt("select access_level from users where username = ?", "s", $username)
            ->getIntAndClose();
    }

    /**
     * Update Random field
     * @param string $username
     * @param string $random
     * @throws DbException in case of SQL error
     */
    public static function updateRandom(string $username, string $random)
    {
        MySQLi::stmt("update users set random = ? where username = ?", "ss", $random, $username)->close();
    }

    /**
     * Update Password by Random
     * @param string $random
     * @param string $password
     * @throws DbException in case of SQL error
     */
    public static function updateRandomPassword(string $random, string $password)
    {
        MySQLi::stmt("update users set password = ?, random = null where random = ?",
            "ss", $password, $random)->close();
    }

    /**
     * Get Random
     * @param string $username
     * @return string
     * @throws DbException in case of SQL error
     */
    public static function getRandom(string $username): string
    {
        return MySQLi::stmt("select random from users where username = ?", "s", $username)
            ->getStringAndClose();
    }

    /**
     * Check Random
     * @param string $random
     * @return bool
     * @throws DbException in case of SQL error
     */
    public static function checkRandom(string $random): bool
    {
        return MySQLi::stmt("select count(id) from users where random = ? and access_level != ?",
            "si", $random, AccessLevel::NOT_CONFIRMED)->getBoolAndClose();
    }

    /**
     * Update Access Level
     * @param string $random
     * @param int $level
     * @throws DbException in case of SQL error
     */
    public static function updateRandomLevel(string $random, int $level)
    {
        MySQLi::stmt("update users set access_level = ?, random = null where random = ?",
            "is", $level, $random)->close();
    }

    /**
     * Get User Info
     * @param string $username
     * @return array
     * @throws DbException in case of SQL error
     */
    public static function get(string $username): array
    {
        return MySQLi::stmt("select * from users where name = ?", "s", $username)->getAssocAndClose();
    }
}
