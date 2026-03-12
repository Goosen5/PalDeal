const achievements = [
	{ title: 'Premier achat', desc: 'Acheté un jeu', icon: 'assets/images/trophy.png' },
	{ title: 'Collectionneur', desc: '5 jeux achetés', icon: 'assets/images/trophy.png' }
];

window.onload = function() {
	const achDiv = document.getElementById('profile-achievements');
	achDiv.innerHTML = achievements.map(a =>
		`<div class='achievement-card'><div class='example-bank-space'></div><div><strong>${a.title}</strong><br/><span>${a.desc}</span></div></div>`
	).join('');
};