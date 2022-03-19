<?php

namespace Database;

use Config\Database;
use Exception\DbConnectionException;
use Exception\DbException;

class MySQLi extends \MySQLi
{
    private static ?MySQLi $link = null;

    /**
     * todo make private!!!
     * MySQLi constructor.
     * @throws DbConnectionException in case of SQL connection error
     */
    public function __construct()
    {
        parent::__construct(Database::HOST, Database::USER, Database::PASSWORD, Database::DATABASE);
        if ($this->connect_errno) throw new DbConnectionException("Could not connect to MySQL server. $this->connect_error");
        $this->set_charset('utf8');
    }

    public static function stmt(string $query, string $types, $var1, ...$_): Statement
    {
        $stmt = self::link()->prepare($query);
        if (!$stmt) throw new DbException(self::link()->error);
        call_user_func_array([$stmt, "bind_param"], array_merge([$types, $var1], $_));
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error);
        return Statement::from($stmt);
    }

    /**
     * @return MySQLi
     * @throws DbConnectionException in case of SQL connection error
     */
    private static function &link(): MySQLi
    {
        if (self::$link == null) self::$link = new MySQLi();
        return self::$link;
    }

    public static function stmtWoParams(string $query): Statement
    {
        $stmt = self::link()->prepare($query);
        if (!$stmt) throw new DbException(self::link()->error);
        $stmt->execute();
        if ($stmt->errno != 0) throw new DbException($stmt->error);
        return Statement::from($stmt);
    }

    public static function escape(string $string): string
    {
        return self::$link->real_escape_string($string);
    }
}
