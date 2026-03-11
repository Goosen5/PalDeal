

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
					<strong><?= htmlspecialchars($game['name']) ?></strong>
					<span> (<?= htmlspecialchars($game['platform']) ?>)</span>
					<?php if (!empty($game['genre'])): ?>
						<span> - <?= htmlspecialchars($game['genre']) ?></span>
					<?php endif; ?>
					<?php if (!empty($game['developer'])): ?>
						<span> - <?= htmlspecialchars($game['developer']) ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p>Vous n'avez encore aucun jeu dans votre bibliothèque.</p>
		<?php endif; ?>
	</div>
	<div class="profile-section profile-center">
		<div class="profile-user-data">
			<div id="profile-avatar" class="profile-avatar example-bank-space"></div>
			<?php if (isset($user) && !empty($user['is_admin']) && $user['is_admin'] == 1): ?>
				<a href="/?page=admin" class="profile-admin-btn" style="margin: 1.2rem 0 0 0; display: inline-block; background: #3d85ab; color: #fff; border: none; border-radius: 6px; padding: 0.7rem 1.5rem; font-size: 1em; text-decoration: none; cursor: pointer; transition: background 0.2s;">Accéder à l'administration</a>
			<?php endif; ?>
			<form method="POST" action="/?page=logout" style="display:inline-block; margin-left:1rem;">
				<button type="submit" style="background:#d9534f; color:#fff; border:none; border-radius:6px; padding:0.7rem 1.5rem; font-size:1em; cursor:pointer;">Déconnexion</button>
			</form>
			<div class="profile-user-info">
				<span id="profile-name">
					<?php if (isset($user)) echo htmlspecialchars($user['username']); ?>
				</span><br>
				<span id="profile-email">
					<?php if (isset($user)) echo htmlspecialchars($user['email']); ?>
				</span><br>
				<span id="profile-level">Level: 1</span><br>
				<span id="profile-diamonds">Diamonds: 0</span>
			</div>
		</div>
	</div>
	<div class="profile-section" id="profile-achievements">
		<!-- Succès -->
	</div>
</div>
