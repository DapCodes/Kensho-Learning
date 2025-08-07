document.addEventListener("DOMContentLoaded", function () {
    const quizFilter = document.getElementById("quiz_filter");
    const filterForm = document.getElementById("filterForm");

    // Auto-submit form when filter changes
    quizFilter.addEventListener("change", function () {
        // Show loading indicator
        const loadingIndicator = document.createElement("div");
        loadingIndicator.className =
            "position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center";
        loadingIndicator.style.backgroundColor = "rgba(255, 255, 255, 0.8)";
        loadingIndicator.style.zIndex = "9999";
        loadingIndicator.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted">Memuat data...</p>
            </div>
        `;
        document.body.appendChild(loadingIndicator);

        // Submit form
        filterForm.submit();
    });

    // Enhanced search functionality
    const searchInput = document.createElement("input");
    searchInput.type = "text";
    searchInput.className = "form-control mb-3";
    searchInput.placeholder = "Cari peserta, quiz, atau mata pelajaran...";
    searchInput.id = "searchInput";

    // Add search input to the table card header
    const tableHeader = document.querySelector(".card-header");
    if (tableHeader) {
        const searchContainer = document.createElement("div");
        searchContainer.className = "row align-items-center";
        searchContainer.innerHTML = `
            <div class="col-md-6">
                <h5 class="mb-0 fw-bold">
                    <i class="ti ti-table me-2 text-success"></i>Tabel Data Nilai
                </h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-3">
                    <input type="text" class="form-control" placeholder="Cari peserta, quiz, atau mata pelajaran..." id="searchInput">
                    <span class="badge bg-success-subtle text-success px-3 py-2">
                        ${
                            document.querySelectorAll(".hasil-row").length
                        } Data Tersedia
                    </span>
                </div>
            </div>
        `;
        tableHeader.innerHTML = "";
        tableHeader.appendChild(searchContainer);
    }

    // Real-time search functionality
    const searchInputElement = document.getElementById("searchInput");
    if (searchInputElement) {
        searchInputElement.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll(".hasil-row");
            let visibleCount = 0;

            rows.forEach((row) => {
                const peserta = row
                    .querySelector("td:nth-child(2)")
                    .textContent.toLowerCase();
                const quiz = row
                    .querySelector("td:nth-child(3)")
                    .textContent.toLowerCase();
                const mapel = row
                    .querySelector("td:nth-child(3) small")
                    .textContent.toLowerCase();

                if (
                    peserta.includes(searchTerm) ||
                    quiz.includes(searchTerm) ||
                    mapel.includes(searchTerm)
                ) {
                    row.style.display = "";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });

            // Update counter
            const counter = document.querySelector(".badge");
            if (counter) {
                counter.textContent = `${visibleCount} Data Tersedia`;
            }

            // Show/hide empty state
            const tableBody = document.querySelector("tbody");
            const emptyState = document.querySelector(".empty-search-state");

            if (visibleCount === 0 && searchTerm !== "") {
                if (!emptyState) {
                    const emptyRow = document.createElement("tr");
                    emptyRow.className = "empty-search-state";
                    emptyRow.innerHTML = `
                        <td colspan="9" class="text-center py-5">
                            <div class="mb-3">
                                <i class="ti ti-search text-muted" style="font-size: 48px;"></i>
                            </div>
                            <h5 class="text-muted">Tidak Ada Data Ditemukan</h5>
                            <p class="text-muted">Tidak ada data yang cocok dengan pencarian "${searchTerm}"</p>
                        </td>
                    `;
                    tableBody.appendChild(emptyRow);
                }
            } else if (emptyState) {
                emptyState.remove();
            }
        });
    }

    // Toast auto-hide functionality
    const toasts = document.querySelectorAll(".toast");
    toasts.forEach((toast) => {
        // Auto hide after 5 seconds
        setTimeout(() => {
            toast.classList.remove("show");
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 5000);
    });

    // Enhanced table row hover effects
    const tableRows = document.querySelectorAll(".hasil-row");
    tableRows.forEach((row) => {
        row.addEventListener("mouseenter", function () {
            this.style.backgroundColor = "#f8f9fa";
            this.style.transform = "translateY(-2px)";
            this.style.boxShadow = "0 4px 8px rgba(0,0,0,0.1)";
            this.style.transition = "all 0.2s ease";
        });

        row.addEventListener("mouseleave", function () {
            this.style.backgroundColor = "";
            this.style.transform = "";
            this.style.boxShadow = "";
        });
    });

    // Initialize tooltips for action buttons
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll("[title]")
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Export button loading state
    const exportButtons = document.querySelectorAll('[href*="export"]');
    exportButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const originalText = this.innerHTML;
            this.innerHTML =
                '<i class="spinner-border spinner-border-sm me-2"></i>Exporting...';
            this.disabled = true;

            // Re-enable after 3 seconds
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 3000);
        });
    });

    // Smooth scrolling for long tables
    const tableContainer = document.querySelector(".table-responsive");
    if (tableContainer) {
        tableContainer.style.scrollBehavior = "smooth";
    }

    // Enhanced mobile responsiveness
    function handleMobileView() {
        const table = document.querySelector(".table");
        const isMobile = window.innerWidth < 768;

        if (isMobile && table) {
            // Add mobile-friendly classes
            table.classList.add("table-sm");

            // Hide less important columns on mobile
            const lessImportantColumns = document.querySelectorAll(
                "th:nth-child(4), td:nth-child(4), th:nth-child(5), td:nth-child(5)"
            );
            lessImportantColumns.forEach((col) => {
                col.style.display = isMobile ? "none" : "";
            });
        }
    }

    // Initial mobile check
    handleMobileView();

    // Listen for window resize
    window.addEventListener("resize", handleMobileView);

    // Add confirmation for reset button
    const resetButton = document.querySelector(
        '[href*="dataNilai"]:not([href*="export"])'
    );
    if (resetButton && resetButton.textContent.includes("Reset")) {
        resetButton.addEventListener("click", function (e) {
            if (quizFilter.value !== "all") {
                const confirmReset = confirm(
                    "Apakah Anda yakin ingin mereset filter dan menampilkan semua data?"
                );
                if (!confirmReset) {
                    e.preventDefault();
                }
            }
        });
    }

    // Keyboard shortcuts
    document.addEventListener("keydown", function (e) {
        // Ctrl/Cmd + F for search
        if ((e.ctrlKey || e.metaKey) && e.key === "f") {
            e.preventDefault();
            if (searchInputElement) {
                searchInputElement.focus();
            }
        }

        // Escape to clear search
        if (e.key === "Escape" && searchInputElement) {
            searchInputElement.value = "";
            searchInputElement.dispatchEvent(new Event("input"));
        }
    });

    // Initialize page with animations
    function initializePageAnimations() {
        const cards = document.querySelectorAll(".card");
        cards.forEach((card, index) => {
            card.style.opacity = "0";
            card.style.transform = "translateY(20px)";

            setTimeout(() => {
                card.style.transition = "all 0.5s ease";
                card.style.opacity = "1";
                card.style.transform = "translateY(0)";
            }, index * 100);
        });
    }

    // Initialize animations
    initializePageAnimations();

    // REMOVED: Custom dropdown functionality that was interfering with Bootstrap
    // Bootstrap will handle dropdown functionality automatically

    // Add loading state to filter form
    filterForm.addEventListener("submit", function () {
        const submitButton = this.querySelector('button[type="submit"]');
        if (submitButton) {
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML =
                '<i class="spinner-border spinner-border-sm me-2"></i>Memuat...';
            submitButton.disabled = true;
        }
    });

    // Status badge click for more info
    const statusBadges = document.querySelectorAll(".badge");
    statusBadges.forEach((badge) => {
        if (badge.textContent.includes("Perlu Koreksi")) {
            badge.style.cursor = "pointer";
            badge.title =
                "Klik untuk melihat detail essay yang perlu dikoreksi";
        }
    });

    console.log("Enhanced filter script loaded successfully!");
});
