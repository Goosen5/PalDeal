<?php

class Application
{
    private $params = [];

    public function run()
    {
        $this->getUrl();
        $page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : null;
        $page !== null ? $this->route($page) : $this->loadView('home');
    }

    private function getUrl()
    {
        if (!isset($_GET['url'])) {
            return;
        }
        $url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
        $this->params = explode('/', $url);
    }

    private function route($page)
    {
        $public = ['login', 'register'];
        if (!in_array($page, $public)) {
            require_once BASE_PATH . '/src/Controllers/LoginController.php';
            if (!LoginController::isLoggedIn()) {
                header('Location: /?page=login');
                exit;
            }
        }

        $dispatch = [
            'register'       => [$this, 'handleRegister'],
            'login'          => [$this, 'handleLogin'],
            'profile'        => [$this, 'handleProfile'],
            'basket'         => [$this, 'handleBasket'],
            'logout'         => [$this, 'handleLogout'],
            'admin'          => [$this, 'handleAdmin'],
            'add_to_library'  => [$this, 'handleAddToLibrary'],
            'add_to_cart'     => [$this, 'handleAddToCart'],
            'remove_from_cart'=> [$this, 'handleRemoveFromCart'],
            'checkout'        => [$this, 'handleCheckout'],
        ];

        isset($dispatch[$page]) ? $dispatch[$page]() : $this->loadView($page);
    }

    private function handleRegister()
    {
        require_once BASE_PATH . '/src/Controllers/RegisterController.php';
        $result  = RegisterController::handle();
        $errors  = $result['errors'];
        $success = $result['success'];
        require_once BASE_PATH . '/src/Views/register.php';
    }

    private function handleLogin()
    {
        require_once BASE_PATH . '/src/Controllers/LoginController.php';
        $result  = LoginController::handle();
        $errors  = $result['errors'];
        $success = $result['success'];
        if ($success) {
            header('Location: /?page=profile');
            exit;
        }
        require_once BASE_PATH . '/src/Views/login.php';
    }

    private function handleProfile()
    {
        require_once BASE_PATH . '/src/Controllers/LibraryController.php';
        require_once BASE_PATH . '/src/Controllers/AchievementController.php';
        $user         = LoginController::getUser();
        $library      = isset($user['id']) ? LibraryController::getLibrary($user['id']) : [];
        $achievements = isset($user['id']) ? AchievementController::getUserAchievements((int) $user['id']) : [];
        isset($user['id']) && AchievementController::syncLibraryAchievements((int) $user['id']);
        $score  = count($library) * 2 + count($achievements) * 3;
        $level  = 1 + intdiv($score, 5);
        $xpPct  = ($score % 5) * 20;
        require_once BASE_PATH . '/src/Views/profile.php';
    }

    private function handleBasket()
    {
        require_once BASE_PATH . '/src/Controllers/BasketController.php';
        $user      = LoginController::getUser();
        $cartGames = isset($user['id']) ? BasketController::getCartGames((int) $user['id']) : [];
        $total     = array_sum(array_column($cartGames, 'price'));
        require_once BASE_PATH . '/src/Views/basket.php';
    }

    private function handleLogout()
    {
        require_once BASE_PATH . '/src/Controllers/LogoutController.php';
        LogoutController::handle();
    }

    private function handleAdmin()
    {
        require_once BASE_PATH . '/src/Controllers/GameAdminController.php';
        require_once BASE_PATH . '/src/Controllers/UserAdminController.php';
        $user = LoginController::getUser();
        if (($user['is_admin'] ?? 0) != 1) {
            header('Location: /?page=profile');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['admin_action'] ?? '';

            if ($action === 'create_game') {
                GameAdminController::create($_POST);
            }

            if ($action === 'update_game' && isset($_POST['id'])) {
                GameAdminController::update((int) $_POST['id'], $_POST);
            }

            if ($action === 'delete_game' && isset($_POST['id'])) {
                GameAdminController::delete((int) $_POST['id']);
            }

            if ($action === 'create_user') {
                UserAdminController::create($_POST);
            }

            if ($action === 'update_user' && isset($_POST['id'])) {
                UserAdminController::update((int) $_POST['id'], $_POST);
            }

            if ($action === 'delete_user' && isset($_POST['id'])) {
                UserAdminController::delete((int) $_POST['id']);
            }

            header('Location: /?page=admin');
            exit;
        }

        $games = GameAdminController::all();
        $users = UserAdminController::all();
        require_once BASE_PATH . '/src/Views/admin.php';
    }

    private function handleAddToLibrary()
    {
        require_once BASE_PATH . '/src/Controllers/LibraryController.php';
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['game_id'])) {
            return;
        }
        $user = LoginController::getUser();
        if (!isset($user['id'])) {
            echo 'error: not logged in';
            exit;
        }
        LibraryController::addToLibrary($user['id'], (int) $_POST['game_id']);
        echo 'success';
        exit;
    }

    private function handleRemoveFromCart()
    {
        require_once BASE_PATH . '/src/Controllers/BasketController.php';
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['game_id'])) {
            header('Location: /?page=basket');
            exit;
        }
        $user = LoginController::getUser();
        if (!isset($user['id'])) {
            header('Location: /?page=login');
            exit;
        }
        BasketController::removeFromCart((int) $user['id'], (int) $_POST['game_id']);
        header('Location: /?page=basket');
        exit;
    }

    private function handleCheckout()
    {
        require_once BASE_PATH . '/src/Controllers/BasketController.php';
        require_once BASE_PATH . '/src/Controllers/LibraryController.php';
        require_once BASE_PATH . '/src/Controllers/AchievementController.php';
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?page=basket');
            exit;
        }
        $user = LoginController::getUser();
        if (!isset($user['id'])) {
            header('Location: /?page=login');
            exit;
        }
        $userId    = (int) $user['id'];
        $cartGames = BasketController::getCartGames($userId);
        foreach ($cartGames as $game) {
            LibraryController::addToLibrary($userId, (int) $game['id']);
        }
        AchievementController::syncLibraryAchievements($userId);
        BasketController::clearCart($userId);
        header('Location: /?page=profile');
        exit;
    }

    private function handleAddToCart()
    {
        require_once BASE_PATH . '/src/Controllers/BasketController.php';
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['game_id'])) {
            return;
        }
        $user = LoginController::getUser();
        if (!isset($user['id'])) {
            echo 'error: not logged in';
            exit;
        }
        BasketController::addToCart((int) $user['id'], (int) $_POST['game_id']);
        echo 'success';
        exit;
    }

    private function loadView($page)
    {
        $safe = preg_replace('/[^a-z0-9_-]/i', '', $page);
        $path = BASE_PATH . '/src/Views/' . $safe . '.php';
        file_exists($path) ? require_once $path : http_response_code(404);
    }
}
