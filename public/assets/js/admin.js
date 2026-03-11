let jeux = [
    { name: 'Cyberpunk 2077', genre: 'RPG', price: 59.99, desc: 'Futuristic open world.' },
    { name: 'Minecraft', genre: 'Sandbox', price: 26.95, desc: 'Block building adventure.' },
    { name: 'Valorant', genre: 'FPS', price: 0, desc: 'Tactical shooter.' }
];
let users = [
    { name: 'Alex Dupont', email: 'alex.dupont@email.com', role: 'Admin' },
    { name: 'Marie Curie', email: 'marie.curie@email.com', role: 'User' },
    { name: 'John Doe', email: 'john.doe@email.com', role: 'User' }
];

function renderJeux() {
    const jeuxDiv = document.getElementById('admin-jeux');
    jeuxDiv.innerHTML = '<div class="admin-title">Jeux</div>' +
        '<form id="add-game-form" style="margin-bottom:1rem;">'
        + '<input type="text" id="new-game-name" placeholder="Nom du jeu" required style="margin-right:0.5rem;">'
        + '<input type="text" id="new-game-genre" placeholder="Genre" required style="margin-right:0.5rem;">'
        + '<input type="number" id="new-game-price" placeholder="Prix" min="0" step="0.01" required style="margin-right:0.5rem;">'
        + '<input type="text" id="new-game-desc" placeholder="Description" required style="margin-right:0.5rem;">'
        + '<button type="submit">Ajouter</button>'
        + '</form>'
        + jeux.map((j, i) => `
            <div class='game-row'>
                <div class='example-blank-space'></div>
                <span><strong>${j.name}</strong> <br>Genre: ${j.genre} <br>Prix: ${j.price}€ <br>${j.desc}</span>
                <button onclick="removeGame(${i})">Supprimer</button>
                <button onclick="showGamePopup(${i})">Modifier</button>
            </div>`).join('');
    document.getElementById('add-game-form').onsubmit = function(e) {
        e.preventDefault();
        const name = document.getElementById('new-game-name').value.trim();
        const genre = document.getElementById('new-game-genre').value.trim();
        const price = parseFloat(document.getElementById('new-game-price').value);
        const desc = document.getElementById('new-game-desc').value.trim();
        if(name && genre && !isNaN(price) && desc) {
            jeux.push({ name, genre, price, desc });
            renderJeux();
        }
    };
}

function removeGame(index) {
    jeux.splice(index, 1);
    renderJeux();
}

function showGamePopup(index) {
    removePopup();
    const j = jeux[index];
    const popupBg = document.createElement('div');
    popupBg.className = 'admin-popup-bg';
    popupBg.innerHTML = `
        <div class='admin-popup'>
            <button class='close-btn' onclick='removePopup()'>Fermer</button>
            <h2>Modifier le jeu</h2>
            <label>Nom</label>
            <input type='text' id='popup-game-name' value='${j.name}'>
            <label>Genre</label>
            <input type='text' id='popup-game-genre' value='${j.genre}'>
            <label>Prix</label>
            <input type='number' id='popup-game-price' value='${j.price}' min='0' step='0.01'>
            <label>Description</label>
            <textarea id='popup-game-desc'>${j.desc}</textarea>
            <button onclick='saveGamePopup(${index})'>Enregistrer</button>
        </div>
    `;
    document.body.appendChild(popupBg);
}

function saveGamePopup(index) {
    jeux[index].name = document.getElementById('popup-game-name').value.trim();
    jeux[index].genre = document.getElementById('popup-game-genre').value.trim();
    jeux[index].price = parseFloat(document.getElementById('popup-game-price').value);
    jeux[index].desc = document.getElementById('popup-game-desc').value.trim();
    removePopup();
    renderJeux();
}

function renderUsers() {
    const usersDiv = document.getElementById('admin-users');
    usersDiv.innerHTML = '<div class="admin-title">Users</div>' +
        users.map((u, i) => `
            <div class='user-row'>
                <div class='example-blank-space'></div>
                <span><strong>${u.name}</strong> <br>Email: ${u.email} <br>Role: ${u.role}</span>
                <button onclick="removeUser(${i})">Supprimer</button>
                <button onclick="showUserPopup(${i})">Modifier</button>
            </div>`).join('');
}

function removeUser(index) {
    users.splice(index, 1);
    renderUsers();
}

function showUserPopup(index) {
    removePopup();
    const u = users[index];
    const popupBg = document.createElement('div');
    popupBg.className = 'admin-popup-bg';
    popupBg.innerHTML = `
        <div class='admin-popup'>
            <button class='close-btn' onclick='removePopup()'>Fermer</button>
            <h2>Modifier l'utilisateur</h2>
            <label>Nom</label>
            <input type='text' id='popup-user-name' value='${u.name}'>
            <label>Email</label>
            <input type='email' id='popup-user-email' value='${u.email}'>
            <label>Role</label>
            <input type='text' id='popup-user-role' value='${u.role}'>
            <button onclick='saveUserPopup(${index})'>Enregistrer</button>
        </div>
    `;
    document.body.appendChild(popupBg);
}

function saveUserPopup(index) {
    users[index].name = document.getElementById('popup-user-name').value.trim();
    users[index].email = document.getElementById('popup-user-email').value.trim();
    users[index].role = document.getElementById('popup-user-role').value.trim();
    removePopup();
    renderUsers();
}

function removePopup() {
    const popup = document.querySelector('.admin-popup-bg');
    if (popup) popup.remove();
}

window.onload = function() {
    renderJeux();
    renderUsers();
};
