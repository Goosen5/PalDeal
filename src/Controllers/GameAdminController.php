<?php
require_once BASE_PATH . '/src/Database.php';

class GameAdminController
{
    public static function all()
    {
        return Database::fetchAll('SELECT * FROM game ORDER BY id DESC');
    }

    public static function create($data)
    {
        $initialPrice = (float) ($data['old_price'] ?? 0);
        $discount = self::discount($data['discount'] ?? 0);
        $price = self::computedPrice($initialPrice, $discount);

        Database::execute(
            'INSERT INTO game (title, description, price, difficulty, image_url, platform, old_price, discount, genre, developer)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                trim((string) ($data['title'] ?? '')),
                trim((string) ($data['description'] ?? '')),
                $price,
                self::difficulty($data['difficulty'] ?? ''),
                trim((string) ($data['image_url'] ?? '')),
                trim((string) ($data['platform'] ?? 'Steam')),
                $initialPrice,
                $discount,
                trim((string) ($data['genre'] ?? '')),
                trim((string) ($data['developer'] ?? '')),
            ]
        );
    }

    public static function update($id, $data)
    {
        $initialPrice = (float) ($data['old_price'] ?? 0);
        $discount = self::discount($data['discount'] ?? 0);
        $price = self::computedPrice($initialPrice, $discount);

        Database::execute(
            'UPDATE game
             SET title = ?, description = ?, price = ?, difficulty = ?, image_url = ?, platform = ?, old_price = ?, discount = ?, genre = ?, developer = ?
             WHERE id = ?',
            [
                trim((string) ($data['title'] ?? '')),
                trim((string) ($data['description'] ?? '')),
                $price,
                self::difficulty($data['difficulty'] ?? ''),
                trim((string) ($data['image_url'] ?? '')),
                trim((string) ($data['platform'] ?? 'Steam')),
                $initialPrice,
                $discount,
                trim((string) ($data['genre'] ?? '')),
                trim((string) ($data['developer'] ?? '')),
                (int) $id,
            ]
        );
    }

    public static function delete($id)
    {
        Database::execute('DELETE FROM game WHERE id = ?', [(int) $id]);
    }

    private static function difficulty($value)
    {
        $value = trim((string) $value);
        return in_array($value, ['easy', 'medium', 'hard', 'nightmare'], true) ? $value : 'easy';
    }

    private static function discount($value)
    {
        $discount = (int) $value;
        return max(0, min(100, $discount));
    }

    private static function computedPrice($initialPrice, $discount)
    {
        return round($initialPrice * (100 - $discount) / 100, 2);
    }
}