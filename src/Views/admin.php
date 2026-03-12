<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= APP_NAME ?? 'PalDeals' ?> &mdash; Admin</title>
	<link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
<a href="/?page=profile" class="admin-profile-btn" style="margin: 1.2rem 0 0 2rem; display: inline-block; background: #3d85ab; color: #fff; border: none; border-radius: 6px; padding: 0.7rem 1.5rem; font-size: 1em; text-decoration: none; cursor: pointer; transition: background 0.2s;">Accéder au profil</a>
<div class="admin-main-panel">
	<div class="admin-section" id="admin-jeux">
		<div class="admin-title">Jeux</div>

		<form id="add-game-form" method="POST" action="/?page=admin" style="margin-bottom:1rem; flex-wrap:wrap;">
			<input type="hidden" name="admin_action" value="create_game">
			<div class="admin-form-grid">
				<label class="admin-field">Titre<input type="text" name="title" required></label>
				<label class="admin-field">Plateforme<input type="text" name="platform" value="Steam"></label>
				<label class="admin-field">Genre<input type="text" name="genre"></label>
				<label class="admin-field">Développeur<input type="text" name="developer"></label>
				<label class="admin-field">Prix initial<input type="number" name="old_price" min="0" step="0.01" value="0" required></label>
				<label class="admin-field">Réduction %<input type="number" name="discount" min="0" max="100" step="1" value="0"></label>
				<label class="admin-field">Difficulté
					<select name="difficulty" required>
						<option value="easy">easy</option>
						<option value="medium">medium</option>
						<option value="hard">hard</option>
						<option value="nightmare">nightmare</option>
					</select>
				</label>
				<label class="admin-field admin-field-full">Image URL<input type="text" name="image_url"></label>
				<label class="admin-field admin-field-full">Description<textarea name="description" rows="2"></textarea></label>
			</div>
			<button type="submit">Ajouter</button>
		</form>

		<?php foreach ($games as $game): ?>
			<div class="game-row">
				<div class="example-blank-space" style="<?= !empty($game['image_url']) ? 'background-image:url(' . htmlspecialchars($game['image_url']) . ');background-size:cover;background-position:center' : '' ?>"></div>
				<form method="POST" action="/?page=admin" style="display:flex; flex-direction:column; gap:0.4rem; min-width:260px;">
					<input type="hidden" name="admin_action" value="update_game">
					<input type="hidden" name="id" value="<?= (int) ($game['id'] ?? 0) ?>">
					<div class="admin-form-grid">
						<label class="admin-field">Titre<input type="text" name="title" value="<?= htmlspecialchars($game['title'] ?? '') ?>" required></label>
						<label class="admin-field">Plateforme<input type="text" name="platform" value="<?= htmlspecialchars($game['platform'] ?? '') ?>"></label>
						<label class="admin-field">Genre<input type="text" name="genre" value="<?= htmlspecialchars($game['genre'] ?? '') ?>"></label>
						<label class="admin-field">Développeur<input type="text" name="developer" value="<?= htmlspecialchars($game['developer'] ?? '') ?>"></label>
						<label class="admin-field">Prix initial<input type="number" name="old_price" value="<?= htmlspecialchars((string) ($game['old_price'] ?? 0)) ?>" min="0" step="0.01" required></label>
						<label class="admin-field">Réduction %<input type="number" name="discount" value="<?= (int) ($game['discount'] ?? 0) ?>" min="0" max="100" step="1"></label>
						<label class="admin-field">Difficulté
							<select name="difficulty" required>
								<option value="easy" <?= (($game['difficulty'] ?? '') === 'easy') ? 'selected' : '' ?>>easy</option>
								<option value="medium" <?= (($game['difficulty'] ?? '') === 'medium') ? 'selected' : '' ?>>medium</option>
								<option value="hard" <?= (($game['difficulty'] ?? '') === 'hard') ? 'selected' : '' ?>>hard</option>
								<option value="nightmare" <?= (($game['difficulty'] ?? '') === 'nightmare') ? 'selected' : '' ?>>nightmare</option>
							</select>
						</label>
						<label class="admin-field admin-field-full">Image URL<input type="text" name="image_url" value="<?= htmlspecialchars($game['image_url'] ?? '') ?>"></label>
						<label class="admin-field admin-field-full">Description<textarea name="description" rows="2"><?= htmlspecialchars($game['description'] ?? '') ?></textarea></label>
					</div>
					<button type="submit">Modifier</button>
				</form>
				<form method="POST" action="/?page=admin" style="align-self:flex-start;">
					<input type="hidden" name="admin_action" value="delete_game">
					<input type="hidden" name="id" value="<?= (int) ($game['id'] ?? 0) ?>">
					<button type="submit">Supprimer</button>
				</form>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="admin-section" id="admin-users">
		<div class="admin-title">Users</div>

		<form id="add-user-form" method="POST" action="/?page=admin" style="margin-bottom:1rem; flex-wrap:wrap;">
			<input type="hidden" name="admin_action" value="create_user">
			<div class="admin-form-grid">
				<label class="admin-field">Username<input type="text" name="username" required></label>
				<label class="admin-field">Email<input type="email" name="email" required></label>
				<label class="admin-field">Password<input type="password" name="password" required></label>
				<label class="admin-field">Role
					<select name="is_admin" required>
						<option value="0">User</option>
						<option value="1">Admin</option>
					</select>
				</label>
			</div>
			<button type="submit">Ajouter</button>
		</form>

		<?php foreach ($users as $managedUser): ?>
			<div class="user-row">
				<form method="POST" action="/?page=admin" style="display:flex; flex-direction:column; gap:0.4rem; min-width:260px; width:100%;">
					<input type="hidden" name="admin_action" value="update_user">
					<input type="hidden" name="id" value="<?= (int) ($managedUser['id'] ?? 0) ?>">
					<div class="admin-form-grid">
						<label class="admin-field">Username<input type="text" name="username" value="<?= htmlspecialchars($managedUser['username'] ?? '') ?>" required></label>
						<label class="admin-field">Email<input type="email" name="email" value="<?= htmlspecialchars($managedUser['email'] ?? '') ?>" required></label>
						<label class="admin-field">Password<input type="password" name="password" required></label>
						<label class="admin-field">Role
							<select name="is_admin" required>
								<option value="0" <?= (($managedUser['is_admin'] ?? 0) == 0) ? 'selected' : '' ?>>User</option>
								<option value="1" <?= (($managedUser['is_admin'] ?? 0) == 1) ? 'selected' : '' ?>>Admin</option>
							</select>
						</label>
					</div>
					<button type="submit">Modifier</button>
				</form>
				<form method="POST" action="/?page=admin" style="align-self:flex-start;">
					<input type="hidden" name="admin_action" value="delete_user">
					<input type="hidden" name="id" value="<?= (int) ($managedUser['id'] ?? 0) ?>">
					<button type="submit">Supprimer</button>
				</form>
			</div>
		<?php endforeach; ?>
	</div>
</div>
</body>
</html>
