const cards = Array.from(document.querySelectorAll('.game-card'));
const searchInput = document.getElementById('searchInput');
const platformFilter = document.getElementById('platformFilter');
const developerFilter = document.getElementById('developerFilter');

const detailTitle = document.getElementById('detailTitle');
const detailDiscount = document.getElementById('detailDiscount');
const detailPrice = document.getElementById('detailPrice');
const detailOldPrice = document.getElementById('detailOldPrice');
const detailPlatform = document.getElementById('detailPlatform');
const detailGenre = document.getElementById('detailGenre');
const detailDeveloper = document.getElementById('detailDeveloper');
const detailDescription = document.getElementById('detailDescription');

function selectCard(card) {
    cards.forEach(item => item.classList.remove('active'));
    card.classList.add('active');

    detailTitle.textContent = card.dataset.name;
    detailDiscount.textContent = `-${card.dataset.discount}%`;
    detailPrice.textContent = `$${card.dataset.price}`;
    detailOldPrice.textContent = `$${card.dataset.oldPrice}`;
    detailPlatform.textContent = card.dataset.platform;
    detailGenre.textContent = card.dataset.genre;
    detailDeveloper.textContent = card.dataset.developer;
    detailDescription.textContent = card.dataset.description;

    // Update hidden input for Add to Library
    const selectedGameIdInput = document.getElementById('selectedGameId');
    if (selectedGameIdInput) {
        selectedGameIdInput.value = card.dataset.id || card.dataset.gameId || '';
    }
}

cards.forEach(card => {
    card.addEventListener('click', () => selectCard(card));
});

function applyFilters() {
    const query = searchInput.value.trim().toLowerCase();
    const platform = platformFilter.value;
    const developer = developerFilter.value;

    cards.forEach(card => {
        const matchName = card.dataset.name.toLowerCase().includes(query);
        const matchPlatform = platform === 'all' || card.dataset.platform === platform;
        const matchDeveloper = developer === 'all' || card.dataset.developer === developer;
        card.style.display = (matchName && matchPlatform && matchDeveloper) ? '' : 'none';
    });

    const visibleActive = document.querySelector('.game-card.active:not([style*="display: none"])');
    if (!visibleActive) {
        const firstVisible = cards.find(card => card.style.display !== 'none');
        if (firstVisible) {
            selectCard(firstVisible);
        }
    }
}

searchInput.addEventListener('input', applyFilters);
platformFilter.addEventListener('change', applyFilters);
developerFilter.addEventListener('change', applyFilters);
