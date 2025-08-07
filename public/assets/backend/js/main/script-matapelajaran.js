// URL base untuk mata pelajaran
const mataPelajaranBaseUrl = "{{ route('matapelajaran.index') }}";

// Delete confirmation function
function deleteMataPelajaran(mataPelajaranId, mataPelajaranName) {
    if (
        confirm(
            `Apakah Anda yakin ingin menghapus mata pelajaran "${mataPelajaranName}"?\n\nTindakan ini tidak dapat dibatalkan.`
        )
    ) {
        document.getElementById("delete-form-" + mataPelajaranId).submit();
    }
}

// Edit mata pelajaran function
function editMataPelajaran(id, nama, deskripsi) {
    // Set form action untuk update
    const actionUrl = `${mataPelajaranBaseUrl}/${id}`;
    document.getElementById("editMataPelajaranForm").action = actionUrl;

    // Debug: log URL yang akan digunakan
    console.log("Edit form action URL:", actionUrl);

    // Set value input nama mata pelajaran dan deskripsi
    document.getElementById("edit_nama_mapel").value = nama;
    document.getElementById("edit_deskripsi").value = deskripsi || "";

    // Clear any previous validation errors
    const namaElement = document.getElementById("edit_nama_mapel");
    const deskripsiElement = document.getElementById("edit_deskripsi");

    namaElement.classList.remove("is-invalid");
    deskripsiElement.classList.remove("is-invalid");

    // Remove any previous error messages
    const errorElements = document.querySelectorAll(
        "#editMataPelajaranModal .invalid-feedback"
    );
    errorElements.forEach((element) => element.remove());
}

// Auto-hide toasts after 5 seconds
document.addEventListener("DOMContentLoaded", function () {
    const toasts = document.querySelectorAll(".toast");
    toasts.forEach(function (toast) {
        setTimeout(function () {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        }, 5000);
    });

    // Reset form saat modal ditutup
    const editModal = document.getElementById("editMataPelajaranModal");
    if (editModal) {
        editModal.addEventListener("hidden.bs.modal", function () {
            const form = document.getElementById("editMataPelajaranForm");
            form.reset();
            form.action = "";

            // Clear validation errors
            const namaElement = document.getElementById("edit_nama_mapel");
            const deskripsiElement = document.getElementById("edit_deskripsi");

            namaElement.classList.remove("is-invalid");
            deskripsiElement.classList.remove("is-invalid");

            // Remove any error messages
            const errorElements = document.querySelectorAll(
                "#editMataPelajaranModal .invalid-feedback"
            );
            errorElements.forEach((element) => element.remove());
        });
    }

    // Reset add modal form saat modal ditutup
    const addModal = document.getElementById("addMataPelajaranModal");
    if (addModal) {
        addModal.addEventListener("hidden.bs.modal", function () {
            const form = addModal.querySelector("form");
            form.reset();

            // Clear validation errors
            const inputs = form.querySelectorAll(".form-control");
            inputs.forEach((input) => {
                input.classList.remove("is-invalid");
            });

            // Remove any error messages
            const errorElements = form.querySelectorAll(".invalid-feedback");
            errorElements.forEach((element) => element.remove());
        });
    }
});
