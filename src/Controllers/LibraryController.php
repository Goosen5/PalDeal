<?php
require_once BASE_PATH . '/src/Database.php';

class LibraryController
{
    private static function ensureSchema()
    {
        Database::execute('CREATE TABLE IF NOT EXISTS library (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            game_id INTEGER,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (game_id) REFERENCES game(id) ON DELETE CASCADE
        )');
    }

    public static function addToLibrary($userId, $gameId)
    {
        self::ensureSchema();

        $owned = (int) Database::fetchValue(
            'SELECT COUNT(*) FROM library WHERE user_id = ? AND game_id = ?',
            [(int) $userId, (int) $gameId]
        );

        if ($owned === 0) {
            Database::execute(
                'INSERT INTO library (user_id, game_id) VALUES (?, ?)',
                [(int) $userId, (int) $gameId]
            );
        }
    }

    public static function getLibrary($userId)
    {
        self::ensureSchema();

        return Database::fetchAll(
            'SELECT g.* FROM library l INNER JOIN game g ON g.id = l.game_id WHERE l.user_id = ?',
            [(int) $userId]
        );
    }
}
