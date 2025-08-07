// URL base untuk kategori
const kategoriBaseUrl = "{{ route('kategori.index') }}";

// Delete confirmation function
function deleteKategori(kategoriId, kategoriName) {
    if (
        confirm(
            `Apakah Anda yakin ingin menghapus kategori "${kategoriName}"?\n\nTindakan ini tidak dapat dibatalkan.`
        )
    ) {
        document.getElementById("delete-form-" + kategoriId).submit();
    }
}

// Edit category function
function editCategory(id, nama) {
    // Set form action untuk update
    const actionUrl = `${kategoriBaseUrl}/${id}`;
    document.getElementById("editCategoryForm").action = actionUrl;

    // Debug: log URL yang akan digunakan
    console.log("Edit form action URL:", actionUrl);

    // Set value input nama kategori
    document.getElementById("edit_nama_kategori").value = nama;

    // Clear any previous validation errors
    const inputElement = document.getElementById("edit_nama_kategori");
    inputElement.classList.remove("is-invalid");

    // Remove any previous error messages
    const errorElement = inputElement.nextElementSibling;
    if (errorElement && errorElement.classList.contains("invalid-feedback")) {
        errorElement.remove();
    }
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
    const editModal = document.getElementById("editCategoryModal");
    if (editModal) {
        editModal.addEventListener("hidden.bs.modal", function () {
            const form = document.getElementById("editCategoryForm");
            form.reset();
            form.action = "";

            // Clear validation errors
            const inputElement = document.getElementById("edit_nama_kategori");
            inputElement.classList.remove("is-invalid");

            // Remove any error messages
            const errorElement = inputElement.nextElementSibling;
            if (
                errorElement &&
                errorElement.classList.contains("invalid-feedback")
            ) {
                errorElement.remove();
            }
        });
    }
});
