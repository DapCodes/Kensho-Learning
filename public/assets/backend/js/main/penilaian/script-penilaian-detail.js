// Toggle question detail visibility
function toggleQuestionDetail(index) {
    const content = document.getElementById(`question-content-${index}`);
    const icon = document.getElementById(`toggle-icon-${index}`);

    if (content.style.display === "none") {
        content.style.display = "block";
        icon.classList.remove("ti-chevron-down");
        icon.classList.add("ti-chevron-up");
    } else {
        content.style.display = "none";
        icon.classList.remove("ti-chevron-up");
        icon.classList.add("ti-chevron-down");
    }
}

// Toggle all answers visibility
function toggleAllAnswers() {
    const allContent = document.querySelectorAll('[id^="question-content-"]');
    const toggleText = document.getElementById("toggleText");
    const allIcons = document.querySelectorAll('[id^="toggle-icon-"]');

    const firstContent = allContent[0];
    const isVisible = firstContent.style.display !== "none";

    allContent.forEach((content) => {
        content.style.display = isVisible ? "none" : "block";
    });

    allIcons.forEach((icon) => {
        if (isVisible) {
            icon.classList.remove("ti-chevron-up");
            icon.classList.add("ti-chevron-down");
        } else {
            icon.classList.remove("ti-chevron-down");
            icon.classList.add("ti-chevron-up");
        }
    });

    toggleText.textContent = isVisible
        ? "Tampilkan Semua"
        : "Sembunyikan Semua";
}

// Filter answers by type
function filterAnswers(type) {
    const questions = document.querySelectorAll(".question-item");
    const noResults = document.getElementById("no-results");
    const filterButtons = document.querySelectorAll('[id^="filter"]');
    let visibleCount = 0;

    // Remove active class from all filter buttons
    filterButtons.forEach((btn) => btn.classList.remove("active"));

    // Add active class to clicked button
    document
        .getElementById(`filter${type.charAt(0).toUpperCase() + type.slice(1)}`)
        .classList.add("active");

    questions.forEach((question) => {
        const status = question.getAttribute("data-status");
        let shouldShow = false;

        switch (type) {
            case "all":
                shouldShow = true;
                break;
            case "correct":
                shouldShow = status === "benar";
                break;
            case "wrong":
                shouldShow = status === "salah";
                break;
        }

        if (shouldShow) {
            question.style.display = "block";
            visibleCount++;
        } else {
            question.style.display = "none";
        }
    });

    // Show/hide no results message
    if (visibleCount === 0) {
        noResults.classList.remove("d-none");
    } else {
        noResults.classList.add("d-none");
    }
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", function () {
    // Set initial filter to 'all'
    document.getElementById("filterAll").classList.add("active");

    // Animate question items
    const questionItems = document.querySelectorAll(".question-item");
    questionItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.05}s`;
        item.classList.add("fade-in-question");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Animate cards on load
    const cards = document.querySelectorAll(".card");
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add("fade-in");
    });

    // Animate progress bars
    const progressBars = document.querySelectorAll(".progress-bar");
    progressBars.forEach((bar) => {
        const width = bar.style.width;
        bar.style.width = "0%";
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });
});

function printResult() {
    window.print();
}

function shareResult() {
    if (navigator.share) {
        navigator.share({
            title: "Hasil Quiz",
            text: "Saya telah menyelesaikan quiz dan mendapat skor {{ $hasil->skor }}!",
            url: window.location.href,
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert("Link hasil telah disalin ke clipboard!");
        });
    }
}
