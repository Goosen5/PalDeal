<?php

class Database
{
    private static $pdo    = null;
    private static $sqlite = null;
    private static $driver = null;

    private static function boot()
    {
        if (self::$driver !== null) {
            return;
        }

        $path = BASE_PATH . '/database/paldeals.db';

        if (extension_loaded('pdo_sqlite')) {
            self::$pdo = new PDO('sqlite:' . $path);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$driver = 'pdo';
            return;
        }

        if (class_exists('SQLite3')) {
            self::$sqlite = new SQLite3($path);
            self::$driver = 'sqlite3';
            return;
        }

        throw new RuntimeException('No SQLite driver available.');
    }

    public static function execute($sql, $params = [])
    {
        self::boot();

        if (self::$driver === 'pdo') {
            return self::$pdo->prepare($sql)->execute($params);
        }

        $stmt = self::$sqlite->prepare($sql);
        self::bind($stmt, $params);
        return (bool) $stmt->execute();
    }

    public static function fetchAll($sql, $params = [])
    {
        self::boot();

        if (self::$driver === 'pdo') {
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $stmt   = self::$sqlite->prepare($sql);
        self::bind($stmt, $params);
        $result = $stmt->execute();
        $rows   = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function fetchOne($sql, $params = [])
    {
        return self::fetchAll($sql, $params)[0] ?? null;
    }

    public static function fetchValue($sql, $params = [])
    {
        $row = self::fetchOne($sql, $params);
        return $row !== null ? reset($row) : null;
    }

    public static function lastInsertId()
    {
        self::boot();
        return self::$driver === 'pdo'
            ? (int) self::$pdo->lastInsertId()
            : (int) self::$sqlite->lastInsertRowID();
    }

    private static function bind($stmt, $params)
    {
        $types = ['integer' => SQLITE3_INTEGER, 'double' => SQLITE3_FLOAT, 'NULL' => SQLITE3_NULL];
        foreach ($params as $key => $value) {
            $idx = is_int($key) ? $key + 1 : (strpos($key, ':') === 0 ? $key : ':' . $key);
            $stmt->bindValue($idx, $value, $types[gettype($value)] ?? SQLITE3_TEXT);
        }
    }
}
