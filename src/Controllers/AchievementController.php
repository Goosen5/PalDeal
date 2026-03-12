<?php
require_once BASE_PATH . '/src/Database.php';

class AchievementController
{
    private static function ensureSchema()
    {
        Database::execute('CREATE TABLE IF NOT EXISTS achievements (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            description TEXT
        )');

        Database::execute('CREATE TABLE IF NOT EXISTS user_achievements (
            user_id INTEGER,
            achievement_id INTEGER,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (achievement_id) REFERENCES achievements(id) ON DELETE CASCADE
        )');
    }

    public static function grantAchievement($userId, $achievementId)
    {
        self::ensureSchema();

        $owned = (int) Database::fetchValue(
            'SELECT COUNT(*) FROM user_achievements WHERE user_id = ? AND achievement_id = ?',
            [(int) $userId, (int) $achievementId]
        );

        if ($owned === 0) {
            Database::execute(
                'INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, ?)',
                [(int) $userId, (int) $achievementId]
            );
        }
    }

    public static function syncLibraryAchievements($userId)
    {
        self::ensureSchema();

        $libraryCount = (int) Database::fetchValue(
            'SELECT COUNT(*) FROM library WHERE user_id = ?',
            [(int) $userId]
        );

        if ($libraryCount >= 1) {
            self::grantAchievement($userId, 1);
        }

        if ($libraryCount >= 5) {
            self::grantAchievement($userId, 2);
        }
    }

    public static function getUserAchievements($userId)
    {
        self::ensureSchema();

        return Database::fetchAll(
            'SELECT a.*
             FROM user_achievements ua
             INNER JOIN achievements a ON a.id = ua.achievement_id
             WHERE ua.user_id = ?
             ORDER BY ua.rowid DESC',
            [(int) $userId]
        );
    }
}