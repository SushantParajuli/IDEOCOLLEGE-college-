function applyFilter(type, value) {
    const url = new URL(window.location.href);
    url.searchParams.set(type, value);
    window.location.href = url.href;
}

function instantSearch() {
    const val = document.getElementById('mainSearch').value.toLowerCase();
    const cards = document.querySelectorAll('.college-card');
    cards.forEach(card => {
        const text = card.innerText.toLowerCase();
        card.style.display = text.includes(val) ? "block" : "none";
    });
}

function toggleDetails(btn) {
    const pane = btn.nextElementSibling;
    if (pane.style.display === "block") {
        pane.style.display = "none";
        btn.innerHTML = `View Details <i data-lucide="chevron-down"></i>`;
    } else {
        pane.style.display = "block";
        btn.innerHTML = `Show Less <i data-lucide="chevron-up"></i>`;
    }
    lucide.createIcons();
}

function openEnroll(name, id) {
    document.getElementById('enrollModal').style.display = 'block';
    document.getElementById('m-title').innerText = "Enroll at " + name;
    document.getElementById('m-id').value = id;
}

function closeModal() {
    document.getElementById('enrollModal').style.display = 'none';
}

function scrollToId(id) {
    document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
}
