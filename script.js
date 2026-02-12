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

function triggerGlow(element) {
    element.classList.add('badge-glow');
    setTimeout(() => { element.classList.remove('badge-glow'); }, 800);
}

function scrollToId(id) {
    const targetId = id.replace('#', '');
    const target = document.getElementById(targetId);
    if (target) {
        const headerOffset = 90;
        const elementPosition = target.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
        window.scrollTo({ top: offsetPosition, behavior: "smooth" });
    }
}

function openEnroll(name, id) {
    document.getElementById('enrollModal').style.display = 'block';
    document.getElementById('m-title').innerText = "Enroll at " + name;
    document.getElementById('m-id').value = id;
}

function closeModal() {
    document.getElementById('enrollModal').style.display = 'none';
}

// Global Nav Smooth Scroll
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        scrollToId(this.getAttribute('href'));
    });
});
