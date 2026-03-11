<?php
require_once BASE_PATH . '/src/Database.php';

class BasketController {
    private static function ensureBasketSchema() {
        Database::execute('CREATE TABLE IF NOT EXISTS basket (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )');

        Database::execute('CREATE TABLE IF NOT EXISTS basket_game (
            basket_id INTEGER,
            game_id INTEGER,
            FOREIGN KEY (basket_id) REFERENCES basket(id) ON DELETE CASCADE,
            FOREIGN KEY (game_id) REFERENCES game(id) ON DELETE CASCADE
        )');
    }

    private static function getOrCreateBasketId($userId) {
        $basketId = Database::fetchValue('SELECT id FROM basket WHERE user_id = ? LIMIT 1', [(int)$userId]);

        if ($basketId) {
            return (int)$basketId;
        }

        Database::execute('INSERT INTO basket (user_id) VALUES (?)', [(int)$userId]);
        return (int) Database::lastInsertId();
    }

    public static function addToCart($userId, $gameId) {
        self::ensureBasketSchema();

        $basketId = self::getOrCreateBasketId($userId);

        $exists = Database::fetchValue('SELECT 1 FROM basket_game WHERE basket_id = ? AND game_id = ? LIMIT 1', [$basketId, (int)$gameId]);

        if (!$exists) {
            Database::execute('INSERT INTO basket_game (basket_id, game_id) VALUES (?, ?)', [$basketId, (int)$gameId]);
        }
    }

    public static function getCartGames($userId) {
        self::ensureBasketSchema();

        return Database::fetchAll('SELECT g.*
            FROM basket b
            INNER JOIN basket_game bg ON bg.basket_id = b.id
            INNER JOIN game g ON g.id = bg.game_id
            WHERE b.user_id = ?
            ORDER BY bg.rowid DESC', [(int)$userId]);
    }

    public static function clearCart($userId) {
        self::ensureBasketSchema();

        $basketId = Database::fetchValue('SELECT id FROM basket WHERE user_id = ? LIMIT 1', [(int)$userId]);

        if ($basketId) {
            Database::execute('DELETE FROM basket_game WHERE basket_id = ?', [(int)$basketId]);
        }
    }
}
