document.addEventListener("DOMContentLoaded", function () {
    // Quick grade buttons functionality
    document.querySelectorAll(".quick-grade-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const targetName = this.getAttribute("data-target");
            const value = this.getAttribute("data-value");
            const input = document.querySelector(`input[name="${targetName}"]`);

            if (input) {
                input.value = parseFloat(value).toFixed(2);
                input.focus();

                // Add visual feedback
                this.classList.add("active");
                setTimeout(() => this.classList.remove("active"), 200);
            }
        });
    });

    // Grade input validation
    document.querySelectorAll(".grade-input").forEach((input) => {
        input.addEventListener("input", function () {
            const maxGrade = parseFloat(this.getAttribute("data-max-grade"));
            const currentValue = parseFloat(this.value);

            if (currentValue > maxGrade) {
                this.value = maxGrade;
            }

            if (currentValue < 0) {
                this.value = 0;
            }
        });
    });

    // Edit graded essay functionality
    document.querySelectorAll(".edit-graded-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const detailId = this.getAttribute("data-detail-id");
            const currentGrade = this.getAttribute("data-current-grade");
            const maxGrade = this.getAttribute("data-max-grade");

            // Set form action
            const form = document.getElementById("editGradeForm");
            form.action = `/penilaian/update-single-grade/${detailId}`;

            // Set input values
            document.getElementById("editGradeInput").value = currentGrade;
            document.getElementById("editGradeInput").max = maxGrade;
            document.getElementById("editMaxGrade").textContent = maxGrade;

            // Show modal
            const modal = new bootstrap.Modal(
                document.getElementById("editGradeModal")
            );
            modal.show();
        });
    });

    // Form submission confirmation
    document
        .getElementById("gradingForm")
        ?.addEventListener("submit", function (e) {
            const inputs = this.querySelectorAll(".grade-input");
            let hasValues = false;

            inputs.forEach((input) => {
                if (input.value && parseFloat(input.value) >= 0) {
                    hasValues = true;
                }
            });

            if (!hasValues) {
                e.preventDefault();
                alert("Silakan masukkan nilai untuk setidaknya satu essay!");
                return false;
            }

            return confirm("Apakah Anda yakin ingin menyimpan penilaian ini?");
        });

    // Auto-hide toasts
    setTimeout(() => {
        document.querySelectorAll(".toast").forEach((toast) => {
            toast.classList.remove("show");
        });
    }, 5000);
});
