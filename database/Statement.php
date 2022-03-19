<?php

namespace Database;

use mysqli_stmt;

class Statement
{
    private mysqli_stmt $stmt;

    /**
     * Statement constructor.
     * @param mysqli_stmt $stmt
     */
    private function __construct(mysqli_stmt $stmt)
    {
        $this->stmt = $stmt;
    }

    public static function from(mysqli_stmt $stmt): Statement
    {
        return new Statement($stmt);
    }

    public function close(): bool
    {
        return $this->stmt->close();
    }

    public function getIntAndClose(): int
    {
        return (int)$this->getFieldAndClose();
    }

    public function getFieldAndClose()
    {
        $output = $this->stmt->get_result()->fetch_array(MYSQLI_NUM)[0];
        $this->stmt->close();
        return $output;
    }

    public function getBoolAndClose(): bool
    {
        return (bool)$this->getFieldAndClose();
    }

    public function getStringAndClose(): string
    {
        return (string)$this->getFieldAndClose();
    }

    public function getInsertedIdAndClose(): int
    {
        $output = $this->stmt->insert_id;
        $this->stmt->close();
        return $output;
    }

    public function getAssocAndClose(): array
    {
        $output = $this->stmt->get_result()->fetch_assoc();
        $this->stmt->close();
        return $output;
    }

    public function getAllAssocAndClose()
    {
        $output = $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $this->stmt->close();
        return $output;
    }
}