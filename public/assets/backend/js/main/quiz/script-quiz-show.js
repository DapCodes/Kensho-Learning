document.addEventListener("DOMContentLoaded", function () {
    const questionItems = document.querySelectorAll(".question-item");

    questionItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        item.classList.add("fade-in");
    });
});

function shareQuiz() {
    if (navigator.share) {
        navigator.share({
            title: "{{ $quiz->judul_quiz }}",
            text: "Ikuti quiz: {{ $quiz->judul_quiz }}",
            url: window.location.href,
        });
    } else {
        // Fallback untuk browser yang tidak mendukung Web Share API
        const url = window.location.href;
        navigator.clipboard
            .writeText(url)
            .then(() => {
                alert("Link quiz telah disalin ke clipboard!");
            })
            .catch(() => {
                // Jika clipboard API tidak didukung, gunakan metode lama
                const textArea = document.createElement("textarea");
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand("copy");
                document.body.removeChild(textArea);
                alert("Link quiz telah disalin ke clipboard!");
            });
    }
}
