// URL base untuk kelas
const kelasBaseUrl = "{{ route('kelas.index') }}";

// Delete confirmation function
function deleteKelas(kelasId, kelasName) {
    if (
        confirm(
            `Apakah Anda yakin ingin menghapus kelas "${kelasName}"?\n\nTindakan ini tidak dapat dibatalkan.`
        )
    ) {
        document.getElementById("delete-form-" + kelasId).submit();
    }
}

// Edit kelas function
function editKelas(id, namaKelas, jurusan) {
    // Set form action untuk update
    const actionUrl = `${kelasBaseUrl}/${id}`;
    document.getElementById("editKelasForm").action = actionUrl;

    // Debug: log URL yang akan digunakan
    console.log("Edit form action URL:", actionUrl);

    // Set value input nama kelas dan jurusan
    document.getElementById("edit_nama_kelas").value = namaKelas;
    document.getElementById("edit_jurusan").value = jurusan;

    // Clear any previous validation errors
    const namaElement = document.getElementById("edit_nama_kelas");
    const jurusanElement = document.getElementById("edit_jurusan");

    namaElement.classList.remove("is-invalid");
    jurusanElement.classList.remove("is-invalid");

    // Remove any previous error messages
    const errorElements = document.querySelectorAll(
        "#editKelasModal .invalid-feedback"
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
    const editModal = document.getElementById("editKelasModal");
    if (editModal) {
        editModal.addEventListener("hidden.bs.modal", function () {
            const form = document.getElementById("editKelasForm");
            form.reset();
            form.action = "";

            // Clear validation errors
            const namaElement = document.getElementById("edit_nama_kelas");
            const jurusanElement = document.getElementById("edit_jurusan");

            namaElement.classList.remove("is-invalid");
            jurusanElement.classList.remove("is-invalid");

            // Remove any error messages
            const errorElements = document.querySelectorAll(
                "#editKelasModal .invalid-feedback"
            );
            errorElements.forEach((element) => element.remove());
        });
    }

    // Reset add modal form saat modal ditutup
    const addModal = document.getElementById("addKelasModal");
    if (addModal) {
        addModal.addEventListener("hidden.bs.modal", function () {
            const form = addModal.querySelector("form");
            form.reset();

            // Clear validation errors
            const inputs = form.querySelectorAll(".form-control, .form-select");
            inputs.forEach((input) => {
                input.classList.remove("is-invalid");
            });

            // Remove any error messages
            const errorElements = form.querySelectorAll(".invalid-feedback");
            errorElements.forEach((element) => element.remove());
        });
    }
});
