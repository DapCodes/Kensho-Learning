document.addEventListener("DOMContentLoaded", function () {
    const copyButtons = document.querySelectorAll(".copy-quiz-btn");

    copyButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const quizCode = this.getAttribute("data-quiz-code");

            // Buat elemen sementara
            const tempInput = document.createElement("input");
            tempInput.value = quizCode;
            document.body.appendChild(tempInput);
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // Untuk mobile
            document.execCommand("copy");
            document.body.removeChild(tempInput);
        });
    });
});
// Delete confirmation function
function deleteQuiz(quizId, quizTitle) {
    if (
        confirm(
            `Apakah Anda yakin ingin menghapus quiz "${quizTitle}"?\n\nTindakan ini tidak dapat dibatalkan.`
        )
    ) {
        document.getElementById("delete-form-" + quizId).submit();
    }
}
