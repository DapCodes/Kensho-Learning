document.addEventListener("DOMContentLoaded", function () {
    // Copy quiz code functionality
    const copyButtons = document.querySelectorAll(".copy-quiz-btn");
    copyButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const quizCode = this.getAttribute("data-quiz-code");

            // Modern clipboard API with fallback
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard
                    .writeText(quizCode)
                    .then(function () {
                        showCopyFeedback(button, true);
                    })
                    .catch(function () {
                        // Fallback to old method
                        fallbackCopy(quizCode, button);
                    });
            } else {
                // Fallback for older browsers or non-HTTPS
                fallbackCopy(quizCode, button);
            }
        });
    });

    // Fallback copy method
    function fallbackCopy(text, button) {
        const tempInput = document.createElement("input");
        tempInput.value = text;
        tempInput.style.position = "absolute";
        tempInput.style.left = "-9999px";
        document.body.appendChild(tempInput);
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        try {
            const successful = document.execCommand("copy");
            showCopyFeedback(button, successful);
        } catch (err) {
            showCopyFeedback(button, false);
        }

        document.body.removeChild(tempInput);
    }

    // Show copy feedback
    function showCopyFeedback(button, success) {
        const originalContent = button.innerHTML;
        const originalClass = button.className;

        if (success) {
            button.innerHTML = '<i class="ti ti-check"></i>';
            button.classList.add("btn-success");
            button.classList.remove("btn-outline-secondary");

            // Create toast notification
            showToast("Kode quiz berhasil disalin!", "success");

            setTimeout(() => {
                button.innerHTML = originalContent;
                button.className = originalClass;
            }, 2000);
        } else {
            button.innerHTML = '<i class="ti ti-x"></i>';
            button.classList.add("btn-danger");
            button.classList.remove("btn-outline-secondary");

            showToast("Gagal menyalin kode quiz", "error");

            setTimeout(() => {
                button.innerHTML = originalContent;
                button.className = originalClass;
            }, 2000);
        }
    }

    // Toast notification function
    function showToast(message, type) {
        // Remove existing toasts
        const existingToasts = document.querySelectorAll(".custom-toast");
        existingToasts.forEach((toast) => toast.remove());

        const toast = document.createElement("div");
        toast.className = `custom-toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="ti ti-${type === "success" ? "check" : "x"}"></i>
                <span>${message}</span>
            </div>
        `;

        // Add toast styles
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === "success" ? "#28a745" : "#dc3545"};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            font-size: 14px;
            max-width: calc(100vw - 40px);
        `;

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.transform = "translateX(0)";
        }, 100);

        // Remove after 3 seconds
        setTimeout(() => {
            toast.style.transform = "translateX(100%)";
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 3000);
    }

    // Enhanced activation toggle functionality - PERBAIKAN UTAMA
    const activationForms = document.querySelectorAll(
        'form[action*="toggleAktivasi"]'
    );
    activationForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault(); // Prevent default form submission

            const button = this.querySelector('button[type="submit"]');
            const isActive = button.textContent
                .trim()
                .toLowerCase()
                .includes("nonaktifkan");
            const action = isActive ? "menonaktifkan" : "mengaktifkan";

            // Create custom confirmation
            const confirmed = confirm(
                `Apakah Anda yakin ingin ${action} quiz ini?`
            );

            if (confirmed) {
                // Show loading state
                const originalContent = button.innerHTML;
                button.innerHTML =
                    '<i class="ti ti-loader-2 animate-spin"></i> Processing...';
                button.disabled = true;

                // Create a new FormData from the form
                const formData = new FormData(this);
                const actionUrl = this.getAttribute("action");

                // Use fetch for better control
                fetch(actionUrl, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN":
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute("content") ||
                            formData.get("_token"),
                    },
                })
                    .then((response) => {
                        if (response.ok) {
                            // Reload page to reflect changes
                            window.location.reload();
                        } else {
                            throw new Error("Network response was not ok");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        // Fallback: submit form normally
                        this.submit();
                    });
            }
        });
    });

    // Auto-hide existing Bootstrap toasts
    const bootstrapToasts = document.querySelectorAll(".toast.show");
    bootstrapToasts.forEach((toast) => {
        setTimeout(() => {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        }, 5000);
    });

    // Add loading states to other buttons (excluding activation buttons)
    const actionButtons = document.querySelectorAll(
        '.btn[href], .btn[type="submit"]:not([form*="toggleAktivasi"])'
    );
    actionButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            // Skip if it's copy button or activation button
            if (
                this.classList.contains("copy-quiz-btn") ||
                this.closest('form[action*="toggleAktivasi"]')
            ) {
                return;
            }

            if (this.type !== "button") {
                const originalContent = this.innerHTML;
                this.innerHTML =
                    '<i class="ti ti-loader-2 animate-spin"></i> Loading...';
                this.disabled = true;

                // Re-enable after 5 seconds as failsafe
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.disabled = false;
                }, 5000);
            }
        });
    });

    // Smooth scroll for mobile
    if (window.innerWidth <= 768) {
        const cards = document.querySelectorAll(".mobile-quiz-card");
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.opacity = "0";
            card.style.transform = "translateY(20px)";

            setTimeout(() => {
                card.style.transition = "all 0.5s ease";
                card.style.opacity = "1";
                card.style.transform = "translateY(0)";
            }, index * 100);
        });
    }

    // Handle window resize
    let resizeTimer;
    window.addEventListener("resize", function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            // Force layout recalculation on orientation change
            document.body.style.display = "none";
            document.body.offsetHeight; // Trigger reflow
            document.body.style.display = "";
        }, 100);
    });
});

// Delete confirmation function - Enhanced
function deleteQuiz(quizId, quizTitle) {
    // Create custom confirmation modal for better UX
    const confirmed = confirm(
        `Apakah Anda yakin ingin menghapus quiz "${quizTitle}"?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait quiz ini.`
    );

    if (confirmed) {
        const form = document.getElementById("delete-form-" + quizId);
        if (form) {
            // Add loading state to any visible delete button
            const deleteButton = document.querySelector(
                `button[onclick*="deleteQuiz(${quizId}"]`
            );
            if (deleteButton) {
                deleteButton.innerHTML =
                    '<i class="ti ti-loader-2 animate-spin"></i> Menghapus...';
                deleteButton.disabled = true;
            }
            form.submit();
        }
    }
}

// Add CSS animations for loading spinner
const style = document.createElement("style");
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    .toast-content {
        display: flex;
        align-items: center;
        gap: 8px;
    }
`;
document.head.appendChild(style);
