 // Filter handling
function applyFilter(type, value) {
    const url = new URL(window.location.href);
    url.searchParams.set(type, value);
    window.location.href = url.href;
}

// Smooth scrolling for "Explore" button and anchors
function scrollToId(id) {
    const target = document.getElementById(id);
    if (target) {
        const headerOffset = 90;
        const elementPosition = target.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

        window.scrollTo({
            top: offsetPosition,
            behavior: "smooth"
        });
    }
}

// Badge Glow on Click
function triggerGlow(element) {
    element.classList.add('badge-glow');
    setTimeout(() => {
        element.classList.remove('badge-glow');
    }, 800);
}

// Toggle detail panes in cards
function toggleDetails(btn) {
    const pane = btn.nextElementSibling;
    if (pane.style.display === "block") {
        pane.style.display = "none";
        btn.innerText = "View Details";
    } else {
        pane.style.display = "block";
        btn.innerText = "Hide Details";
    }
}

// Search filter logic
function instantSearch() {
    let input = document.getElementById('mainSearch').value.toLowerCase();
    let cards = document.querySelectorAll('.college-card');
    cards.forEach(card => {
        let name = card.querySelector('h3').innerText.toLowerCase();
        let location = card.querySelector('p').innerText.toLowerCase();
        if (name.includes(input) || location.includes(input)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}