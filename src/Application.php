<?php
/**
 * Main Application class
 */

class Application
{
    private $controller;
    private $method;
    private $params = [];

    public function __construct()
    {
        // Route handling logic here
    }

    public function run()
    {
        $this->getUrl();
        
        // Default routing
        if (isset($_GET['page'])) {
            $page = htmlspecialchars($_GET['page']);
            // Route to controller based on page parameter
            $this->route($page);
        } else {
            $this->loadDefaultPage();
        }
    }

    private function getUrl()
    {
        // Parse URL for routing
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $this->params = explode('/', $url);
        }
    }

    private function route($page)
    {
        // session_start(); // Already started in config.php
        $publicPages = ['login', 'register'];
        if (!in_array($page, $publicPages)) {
            require_once BASE_PATH . '/src/Controllers/LoginController.php';
            if (!LoginController::isLoggedIn()) {
                header('Location: /?page=login');
                exit;
            }
        }
        if ($page === 'register') {
            require_once BASE_PATH . '/src/Controllers/RegisterController.php';
            $result = RegisterController::handle();
            $errors = $result['errors'];
            $success = $result['success'];
            require_once BASE_PATH . '/src/Views/register.php';
        } elseif ($page === 'login') {
            require_once BASE_PATH . '/src/Controllers/LoginController.php';
            $result = LoginController::handle();
            $errors = $result['errors'];
            $success = $result['success'];
            if ($success) {
                header('Location: /?page=profile');
                exit;
            }
            require_once BASE_PATH . '/src/Views/login.php';
        } elseif ($page === 'profile') {
            require_once BASE_PATH . '/src/Controllers/LoginController.php';
            require_once BASE_PATH . '/src/Controllers/LibraryController.php';
            $user = LoginController::getUser();
            $library = [];
            if (isset($user['id'])) {
                $library = LibraryController::getLibrary($user['id']);
            }
            require_once BASE_PATH . '/src/Views/profile.php';
        } elseif ($page === 'logout') {
            require_once BASE_PATH . '/src/Controllers/LogoutController.php';
            LogoutController::handle();
        } elseif ($page === 'admin') {
            require_once BASE_PATH . '/src/Controllers/LoginController.php';
            $user = LoginController::getUser();
            if (!isset($user['is_admin']) || $user['is_admin'] != 1) {
                header('Location: /?page=profile');
                exit;
            }
            $viewPath = BASE_PATH . '/src/Views/admin.php';
            if (file_exists($viewPath)) {
                require_once $viewPath;
            } else {
                echo '<h2>404 - Page not found</h2>';
            }
        } elseif ($page === 'add_to_library') {
            require_once BASE_PATH . '/src/Controllers/LibraryController.php';
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game_id'])) {
                session_start();
                $userId = $_SESSION['user_id'] ?? null;
                if ($userId) {
                    LibraryController::addToLibrary($userId, (int)$_POST['game_id']);
                    echo 'success';
                } else {
                    echo 'error: not logged in';
                }
                exit;
            }
        } else {
            $viewPath = BASE_PATH . '/src/Views/' . $page . '.php';
            if (file_exists($viewPath)) {
                require_once $viewPath;
            } else {
                echo '<h2>404 - Page not found</h2>';
            }
        }
    }

    private function loadDefaultPage()
    {
        // Load home page
        $viewPath = BASE_PATH . '/src/Views/home.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        }
    }
}
?>
