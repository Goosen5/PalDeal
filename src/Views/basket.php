<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME ?? 'PalDeals'; ?></title>
    <link rel="stylesheet" href="/assets/css/basket.css">
</head>
<body>
    <header>
        <div class="header-separator"></div>
    </header>
    <main>
        <div class="main-panel">
            <a class="back-home-btn" href="/" title="Retour à l'accueil">
                <span class="arrow-left">&#8592;</span>
            </a>
            <div class="count-diamond"> <!--rotated div to act as a diamond--> 
                <div class="count-diamond-inner"> 
                    <span class="count">3</span><!--inner div to rotate back the text-->
                </div>
            </div>
            <?php
            require_once __DIR__ . '/../Controllers/BasketController.php';
            $cartGames = BasketController::getCartGames();
            $total = 0;
            ?>
            <div class="basket-items">
                    <?php if (empty($cartGames)): ?>
                        <div class="basket-row"><span>Your cart is empty.</span></div>
                    <?php else: ?>
                        <?php foreach ($cartGames as $game): ?>
                            <div class="basket-row">
                                <span><?php echo htmlspecialchars($game['name'] ?? $game['title'] ?? ''); ?></span>
                                <span>$<?php echo isset($game['price']) ? number_format($game['price'], 2) : '0.00'; ?></span>
                            </div>
                            <?php $total += $game['price'] ?? 0; ?>
                        <?php endforeach; ?>
                        <form method="post" action="/?page=checkout_cart">
                            <button type="submit" class="checkout-btn">Checkout All</button>
                        </form>
                    <?php endif; ?>
            </div>
            <div class="separator"></div>
            <div class="total">
                <span>Total</span>
                <span><?php echo '$' . number_format($total, 2); ?></span>
            </div>
            <!-- <button class="checkout-button">Checkout</button> -->
             <button class="checkout-button">Checkout</button>
        </div>
    </div>
</main>