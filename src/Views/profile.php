<link rel="stylesheet" href="assets/css/profile.css">

<div class="profile-main-panel">
    <a class="back-home-btn" href="/" title="Retour à l'accueil">
        <span class="arrow-left">&#8592;</span>
    </a>

    <div class="profile-section" id="profile-games">
        <h2>Ma bibliothèque</h2>
        <?php if (!empty($library)): ?>
            <ul class="profile-library-list">
                <?php foreach ($library as $game): ?>
                    <li class="profile-library-item">
                        <div class="game-library-cover" style="<?= !empty($game['image_url']) ? 'background-image:url(' . htmlspecialchars($game['image_url']) . ');background-size:cover;background-position:center' : '' ?>"></div>
                        <div class="game-library-info">
                            <span class="game-library-title"><?= htmlspecialchars($game['title']) ?></span>
                            <span class="game-library-meta"><?= htmlspecialchars(implode(' · ', array_filter([$game['platform'] ?? '', $game['genre'] ?? '', $game['developer'] ?? '']))) ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="library-empty-msg">Ta bibliotheque est vide... Le boss final c'est la procrastination, fonce vers la boutique !</p>
        <?php endif; ?>
    </div>

    <div class="profile-section profile-center">
        <div class="pw-base-info">
            <span>🎮 <?= count($library) ?> jeux</span>
            <span>🏆 <?= count($achievements) ?> succès</span>
        </div>

        <div class="pw-avatar-slot">
            <div id="profile-avatar" class="pw-avatar-img"></div>
        </div>

        <div class="pw-level-block">
            <div class="pw-level-row">
                <div class="pw-level-badge"><?= $level ?></div>
                <div class="pw-level-meta">
                    <span class="pw-level-tag">PLAYER LEVEL</span>
                    <span class="pw-level-next">NEXT &nbsp;<strong><?= $xpPct === 0 ? 0 : 5 - intdiv($xpPct, 20) ?> XP</strong></span>
                </div>
            </div>
            <div class="pw-bar-track">
                <div class="pw-bar-fill pw-bar-xp" style="width:<?= $xpPct ?>%"></div>
            </div>
        </div>

        <div class="pw-stats-panel">
            <div class="pw-stats-header">| Stats</div>
            <div class="pw-stat-row">
                <span class="pw-stat-name">🎮 &nbsp;Library</span>
                <span class="pw-stat-val"><?= count($library) ?></span>
            </div>
            <div class="pw-stat-row">
                <span class="pw-stat-name">🏆 &nbsp;Achievements</span>
                <span class="pw-stat-val"><?= count($achievements) ?></span>
            </div>
        </div>

        <div class="pw-username"><?= htmlspecialchars($user['username'] ?? '') ?></div>
        <div class="pw-email"><?= htmlspecialchars($user['email'] ?? '') ?></div>

        <div class="pw-actions">
            <?php if (isset($user) && !empty($user['is_admin']) && $user['is_admin'] == 1): ?>
                <a href="/?page=admin" class="profile-admin-btn">Administration</a>
            <?php endif; ?>
            <form method="POST" action="/?page=logout">
                <button type="submit" class="profile-logout-btn">Deconnexion</button>
            </form>
        </div>
    </div>

    <div class="profile-section" id="profile-achievements">
        <h2>Succes</h2>
        <?php if (!empty($achievements)): ?>
            <ul class="profile-library-list">
                <?php foreach ($achievements as $achievement): ?>
                    <li class="achievement-card">
                        <div class="example-bank-space"></div>
                        <div>
                            <strong><?= htmlspecialchars($achievement['name']) ?></strong>
                            <br>
                            <span><?= htmlspecialchars($achievement['description'] ?? '') ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="library-empty-msg">Aucun succes debloque pour le moment.</p>
        <?php endif; ?>
    </div>
</div>
