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
            <div class="count-diamond">
                <div class="count-diamond-inner">
                    <span class="count"><?php echo count($cartGames ?? []); ?></span>
                </div>
            </div>
            <div class="basket-items">
                <?php if (empty($cartGames)): ?>
                    <div class="basket-row"><span>Your cart is empty.</span></div>
                <?php else: ?>
                    <?php foreach ($cartGames as $game): ?>
                        <div class="basket-row">
                            <span class="game-title"><?php echo htmlspecialchars($game['name'] ?? $game['title'] ?? ''); ?></span>
                            <div class="basket-row-right">
                                <span>$<?php echo isset($game['price']) ? number_format($game['price'], 2) : '0.00'; ?></span>
                                <form method="POST" action="/?page=remove_from_cart">
                                    <input type="hidden" name="game_id" value="<?php echo (int) $game['id']; ?>">
                                    <button type="submit" class="remove-btn">&#x2715;</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="separator"></div>
            <div class="total">
                <span>Total</span>
                <span>$<?php echo number_format($total, 2); ?></span>
            </div>
            <?php if (!empty($cartGames)): ?>
                <form method="POST" action="/?page=checkout" class="checkout-form">
                    <button type="submit" class="checkout-button">Checkout</button>
                </form>
            <?php else: ?>
                <a href="/" class="checkout-button">Continue shopping</a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
