<?php
require_once BASE_PATH . '/src/Database.php';

class UserAdminController
{
    public static function all()
    {
        return Database::fetchAll('SELECT id, username, email, is_admin FROM users ORDER BY id DESC');
    }

    public static function create($data)
    {
        Database::execute(
            'INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)',
            [
                trim((string) ($data['username'] ?? '')),
                trim((string) ($data['email'] ?? '')),
                password_hash((string) ($data['password'] ?? ''), PASSWORD_DEFAULT),
                self::adminValue($data['is_admin'] ?? 0),
            ]
        );
    }

    public static function update($id, $data)
    {
        Database::execute(
            'UPDATE users SET username = ?, email = ?, password = ?, is_admin = ? WHERE id = ?',
            [
                trim((string) ($data['username'] ?? '')),
                trim((string) ($data['email'] ?? '')),
                password_hash((string) ($data['password'] ?? ''), PASSWORD_DEFAULT),
                self::adminValue($data['is_admin'] ?? 0),
                (int) $id,
            ]
        );
    }

    public static function delete($id)
    {
        Database::execute('DELETE FROM users WHERE id = ?', [(int) $id]);
    }

    private static function adminValue($value)
    {
        return (int) ((int) $value === 1);
    }
}