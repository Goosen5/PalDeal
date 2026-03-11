<?php
class BasketController {
    public static function addToCart($gameId) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (!in_array($gameId, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $gameId;
        }
    }

    public static function getCartGames() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            return [];
        }
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/paldeals.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $ids = implode(',', array_map('intval', $_SESSION['cart']));
        $stmt = $db->query('SELECT * FROM game WHERE id IN (' . $ids . ')');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function clearCart() {
        $_SESSION['cart'] = [];
    }
}
