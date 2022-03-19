<?php

namespace Database;

use Exception\DbException;

/*
 * Quotes Table
 */

class QuoteInfo
{
    /**
     * Remove Quote
     * @param int $id
     * @throws DbException in case of SQL error
     */
    public static function remove(int $id)
    {
        MySQLi::stmt("delete from quotes where id = ?", "i", $id)->close();
    }

    /**
     * Add Quote
     * @param string $quote
     * @return int (quote id)
     * @throws DbException in case of SQL error
     */
    public static function add(string $quote): int
    {
        return MySQLi::stmt("insert into quotes (text) values (?)", "s", $quote)->getInsertedIdAndClose();
    }

    /**
     * Get Quote
     * @param int $id
     * @return array
     * @throws DbException in case of SQL error
     */
    public static function get(int $id): array
    {
        return MySQLi::stmt("select * from quotes where id = ?", "i", $id)->getAssocAndClose();
    }

    /**
     * Get Last Quote
     * @return array
     * @throws DbException in case of SQL error
     */
    public static function getLast(): array
    {
        return MySQLi::stmtWoParams("select * from quotes order by id desc limit 0, 1")->getAssocAndClose();
    }

    /**
     * Check Quote for exists
     * @param int $id
     * @return bool
     * @throws DbException in case of SQL error
     */
    public static function checkForExists(int $id): bool
    {
        return MySQLi::stmt("select count(id) from quotes where id = ?", "i", $id)->getBoolAndClose();
    }

    /**
     * Update Quote
     * @param int $id
     * @param string $text
     * @throws DbException in case of SQL error
     */
    public static function update(int $id, string $text)
    {
        MySQLi::stmt("update quotes set text = ? where id = ?", "si", $text, $id)->close();
    }

    /**
     * @param string $condition
     * @return int
     */
    public static function searchCount(string $condition): int
    {
        return MySQLi::stmtWoParams("select count(id) from quotes $condition")->getIntAndClose();
    }

    /**
     * @param string $condition
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public static function search(string $condition, int $offset, int $limit)
    {
        return MySQLi::stmt("select * from quotes $condition order by id desc limit ?, ?",
            "ii", $offset, $limit)->getAllAssocAndClose();
    }

    public static function resetAutoIncrement()
    {
        MySQLi::stmtWoParams("alter table `quotes` auto_increment = 1")->close();
    }
}
