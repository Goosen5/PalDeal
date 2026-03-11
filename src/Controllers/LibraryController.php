<?php
class LibraryController {
    public static function addToLibrary($userId, $gameId) {
            error_log("addToLibrary called with userId=$userId, gameId=$gameId");
            try {
                error_log('addToLibrary called with userId=' . var_export($userId, true) . ', gameId=' . var_export($gameId, true));
                try {
                    $sqlCreate = "CREATE TABLE IF NOT EXISTS user_game (user_id INTEGER, game_id INTEGER)";
                    error_log('Ensuring user_game table: ' . $sqlCreate);
                    $this->pdo->exec($sqlCreate);
                    error_log('user_game table ensured');
                    $sqlInsert = "INSERT INTO user_game (user_id, game_id) VALUES (?, ?)";
                    error_log('Preparing SQL: ' . $sqlInsert);
                    $stmt = $this->pdo->prepare($sqlInsert);
                    error_log('Statement prepared, executing with params: userId=' . var_export($userId, true) . ', gameId=' . var_export($gameId, true));
                    $result = $stmt->execute([$userId, $gameId]);
                    error_log('Execute result: ' . var_export($result, true));
                    if ($result) {
                        error_log('Game added to library successfully');
                    } else {
                        $errorInfo = $stmt->errorInfo();
                        error_log('Failed to add game to library. ErrorInfo: ' . var_export($errorInfo, true));
                    }
                } catch (PDOException $e) {
                    error_log('PDOException: ' . $e->getMessage());
                } catch (Exception $e) {
                    error_log('General Exception: ' . $e->getMessage());
                }
            } catch (PDOException $e) {
                error_log("PDOException in addToLibrary: " . $e->getMessage());
            }
    }
        public static function getLibrary($userId) {
            $db = new PDO('sqlite:' . __DIR__ . '/../../database/paldeals.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Ensure user_game table exists
            $sqlUserGame = 'CREATE TABLE IF NOT EXISTS user_game (user_id INTEGER, game_id INTEGER)';
            error_log('Ensuring user_game table: ' . $sqlUserGame);
            $db->exec($sqlUserGame);
            // Ensure games table exists
            $sqlGames = 'CREATE TABLE IF NOT EXISTS games (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, platform TEXT, oldPrice REAL, discount INTEGER, genre TEXT, developer TEXT)';
            error_log('Ensuring games table: ' . $sqlGames);
            $db->exec($sqlGames);
            // Query user's library
            $sqlSelect = 'SELECT g.* FROM user_game ug JOIN games g ON ug.game_id = g.id WHERE ug.user_id = ?';
            error_log('Preparing library select: ' . $sqlSelect);
            $stmt = $db->prepare($sqlSelect);
            $stmt->execute([$userId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Library query result: ' . var_export($result, true));
            return $result;
        }
}
