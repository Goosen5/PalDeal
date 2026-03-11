// example data for games and achievements only
const games = [
	{ name: 'Cyberpunk 2077', img: 'assets/images/cyberpunk.png' },
	{ name: 'Minecraft', img: 'assets/images/minecraft.png' },
	{ name: 'Valorant', img: 'assets/images/valorant.png' }
];
const achievements = [
	{ title: 'Premier achat', desc: 'Acheté un jeu', icon: 'assets/images/trophy.png' },
	{ title: 'Collectionneur', desc: '5 jeux achetés', icon: 'assets/images/trophy.png' }
];

window.onload = function() {
	// Fill games
	const gamesDiv = document.getElementById('profile-games');
	gamesDiv.innerHTML = games.map(g => `<div class='game-card'><div class='example-bank-space'></div><span>${g.name}</span></div>`).join('');
	// Fill achievements
	const achDiv = document.getElementById('profile-achievements');
	achDiv.innerHTML = achievements.map(a => `<div class='achievement-card'><div class='example-bank-space'></div><div><strong>${a.title}</strong><br/><span>${a.desc}</span></div></div>`).join('');
};