<link rel="stylesheet" href="assets/css/profile.css">
<script src="assets/js/profile.js"></script>

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
        <div class="profile-user-data">
            <div id="profile-avatar" class="profile-avatar example-bank-space"></div>
            <?php if (isset($user) && !empty($user['is_admin']) && $user['is_admin'] == 1): ?>
                <a href="/?page=admin" class="profile-admin-btn">Acceder a l'administration</a>
            <?php endif; ?>
            <form method="POST" action="/?page=logout">
                <button type="submit" class="profile-logout-btn">Deconnexion</button>
            </form>
            <div class="profile-user-info">
                <span id="profile-name"><?php if (isset($user)) echo htmlspecialchars($user['username']); ?></span>
                <span id="profile-email"><?php if (isset($user)) echo htmlspecialchars($user['email']); ?></span>
                <span id="profile-level">Level: 1</span>
                <span id="profile-diamonds">Diamonds: 0</span>
            </div>
        </div>
    </div>

    <div class="profile-section" id="profile-achievements">
        <h2>Succes</h2>
    </div>
</div>
