<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME ?? 'PalDeals'; ?></title>
    <link rel="stylesheet" href="/assets/css/home.css">
</head>
<body>
    <header>
        <div class="header-separator"> 
            <!-- add profile button with profile.png icon on the right side of the header -->
            <a class="profile-btn" href="/?page=profile" title="Profile">
                <img src="/assets/images/user.png" alt="Profile">
            </a>
        </div>
    </header>
    <main>
        <div class="games-panel">
            <?php
            $db = new PDO('sqlite:' . __DIR__ . '/../../database/paldeals.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->query('SELECT * FROM game');
            $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="panel-toolbar">
                <input id="searchInput" type="text" placeholder="Search games..." />
                <select id="platformFilter">
                    <option value="all">All platforms</option>
                    <option value="Steam">Steam</option>
                    <option value="Rockstar">Rockstar</option>
                </select>
                <select id="developerFilter">
                    <option value="all">All developers</option>
                    <?php
                    $devs = array_unique(array_map(function($g) { return $g['developer'] ?? ''; }, $games));
                    foreach ($devs as $dev) {
                        if ($dev) {
                            echo '<option value="'.htmlspecialchars($dev).'">'.htmlspecialchars($dev).'</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div id="gameGrid" class="game-grid">
                <?php foreach ($games as $index => $game): ?>
                    <div
                        class="game-card<?php echo $index === 0 ? ' active' : ''; ?>"
                        data-name="<?php echo htmlspecialchars($game['name'] ?? $game['title'] ?? ''); ?>"
                        data-platform="<?php echo htmlspecialchars($game['platform'] ?? ''); ?>"
                        data-price="<?php echo isset($game['price']) ? number_format($game['price'], 2) : '0.00'; ?>"
                        data-old-price="<?php echo isset($game['old_price']) ? number_format($game['old_price'], 2) : '0.00'; ?>"
                        data-discount="<?php echo isset($game['discount']) ? (int) $game['discount'] : 0; ?>"
                        data-genre="<?php echo htmlspecialchars($game['genre'] ?? ''); ?>"
                        data-developer="<?php echo htmlspecialchars($game['developer'] ?? ''); ?>"
                        data-description="<?php echo htmlspecialchars($game['description'] ?? ''); ?>"
                    >
                        <div class="card-top">
                            <span class="badge-platform"><?php echo htmlspecialchars($game['platform'] ?? ''); ?></span>
                            <span class="badge-discount">-<?php echo isset($game['discount']) ? (int) $game['discount'] : 0; ?>%</span>
                        </div>
                        <div class="cover-placeholder">
                            <?php if (!empty($game['image_url'])): ?>
                                <img src="/<?php echo htmlspecialchars($game['image_url']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>" style="width:100%;height:auto;">
                            <?php endif; ?>
                        </div>
                        <h3 class="card-title"><?php echo htmlspecialchars($game['title'] ?? ''); ?></h3>
                        <div class="card-prices">
                            <span class="price-current">$<?php echo isset($game['price']) ? number_format($game['price'], 2) : '0.00'; ?></span>
                            <span class="price-old">$<?php echo isset($game['old_price']) ? number_format($game['old_price'], 2) : '0.00'; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
            
        <div class="selected-game">
                <?php if (!empty($games) && isset($games[0])): ?>
                    <div class="hero">
                        <h2 id="detailTitle" class="hero-title"><?php echo htmlspecialchars($games[0]['name'] ?? $games[0]['title'] ?? ''); ?></h2>
                    </div>
                    <div class="detail-price-row">
                        <span id="detailDiscount" class="badge-discount">-<?php echo isset($games[0]['discount']) ? (int) $games[0]['discount'] : 0; ?>%</span>
                        <span id="detailPrice" class="price-current">$<?php echo isset($games[0]['price']) ? number_format($games[0]['price'], 2) : '0.00'; ?></span>
                        <span id="detailOldPrice" class="price-old">$<?php echo isset($games[0]['old_price']) ? number_format($games[0]['old_price'], 2) : '0.00'; ?></span>
                    </div>

                    <ul class="detail-meta">
                        <li><strong>Platform:</strong> <span id="detailPlatform"><?php echo htmlspecialchars($games[0]['platform'] ?? ''); ?></span></li>
                        <li><strong>Genre:</strong> <span id="detailGenre"><?php echo htmlspecialchars($games[0]['genre'] ?? ''); ?></span></li>
                        <li><strong>Developer:</strong> <span id="detailDeveloper"><?php echo htmlspecialchars($games[0]['developer'] ?? ''); ?></span></li>
                    </ul>

                    <p id="detailDescription" class="detail-description"><?php echo htmlspecialchars($games[0]['description'] ?? ''); ?></p>
                    <form id="addToLibraryForm" method="post">
                        <input type="hidden" name="game_id" id="selectedGameId" value="<?php echo $games[0]['id'] ?? ''; ?>">
                        <button class="buy-button" type="button" onclick="addToLibrary()">Add to Library</button>
                    </form>

                    <script>
function addToLibrary() {
    const gameId = document.getElementById('selectedGameId').value;
    fetch('/?page=add_to_library', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'game_id=' + encodeURIComponent(gameId)
    }).then(res => res.text()).then(data => {
        alert('Added to library!');
    });
}
</script>

                <?php else: ?>
                    <div class="hero">
                        <h2 id="detailTitle" class="hero-title">No game selected</h2>
                    </div>
                    <div class="detail-price-row">
                        <span id="detailDiscount" class="badge-discount">-0%</span>
                        <span id="detailPrice" class="price-current">$0.00</span>
                        <span id="detailOldPrice" class="price-old">$0.00</span>
                    </div>
                    <ul class="detail-meta">
                        <li><strong>Platform:</strong> <span id="detailPlatform"></span></li>
                        <li><strong>Genre:</strong> <span id="detailGenre"></span></li>
                        <li><strong>Developer:</strong> <span id="detailDeveloper"></span></li>
                    </ul>
                    <p id="detailDescription" class="detail-description"></p>
                <?php endif; ?>
        </div>
    </main>
    <footer>
        <div class="header-separator"></div>
    </footer>

    <script src="/assets/js/home.js"></script>
</body>
</html>
