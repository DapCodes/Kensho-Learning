document.addEventListener("DOMContentLoaded", function () {
    const setupForm = document.getElementById("quiz-setup-form");
    const setupCard = document.getElementById("quiz-setup-card");
    const questionsContainer = document.getElementById("questions-container");
    const questionsList = document.getElementById("questions-list");
    const backButton = document.getElementById("back-to-setup");

    let questionIndex = 1;

    document
        .getElementById("add-question")
        .addEventListener("click", function () {
            addNewQuestion();
        });

    // Handle quiz setup form submission
    setupForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const title = document.getElementById("quiz-title").value.trim();
        const numQuestions = parseInt(
            document.getElementById("num-questions").value
        );
        const duration = document.getElementById("duration").value;
        const description = document
            .getElementById("quiz-description")
            .value.trim();
        const visibility = document.getElementById("visibility").value;
        const categories = document.getElementById("categories").value;
        const mapel = document.getElementById("mapel").value;
        const aktivasi = document.getElementById("aktivasi").value;
        const pengulangan = document.getElementById("pengulangan").value; // Tambahkan ini

        // Validation
        if (
            !title ||
            !numQuestions ||
            !duration ||
            !visibility ||
            !categories ||
            !mapel ||
            !aktivasi ||
            !pengulangan
        ) {
            alert("Harap isi semua field yang wajib diisi.");
            return;
        }

        if (numQuestions < 1 || numQuestions > 50) {
            alert("Jumlah soal harus antara 1 sampai 50.");
            return;
        }

        if (parseInt(duration) < 1 || parseInt(duration) > 300) {
            alert("Durasi harus antara 1 sampai 300 menit.");
            return;
        }

        // Get option text from selected values
        const categorySelect = document.getElementById("categories");
        const selectedCategoryName =
            categorySelect.options[categorySelect.selectedIndex].text;

        const aktivasiSelect = document.getElementById("aktivasi");
        const selectedAktivasiName =
            aktivasiSelect.options[aktivasiSelect.selectedIndex].text;

        const mapelSelect = document.getElementById("mapel");
        const selectedMapelName =
            mapelSelect.options[mapelSelect.selectedIndex].text;

        const pengulanganSelect = document.getElementById("pengulangan");
        const selectedPengulanganName =
            pengulanganSelect.options[pengulanganSelect.selectedIndex].text;

        // Update display information
        document.getElementById("display-title").textContent = title;
        document.getElementById("display-questions").textContent = numQuestions;
        document.getElementById("display-duration").textContent = duration;
        document.getElementById("display-description").textContent =
            description || "Tidak ada deskripsi";
        document.getElementById("display-visibility").textContent = visibility;
        document.getElementById("display-categories").textContent =
            selectedCategoryName;
        document.getElementById("display-mapel").textContent =
            selectedMapelName;
        document.getElementById("display-aktivasi").textContent =
            selectedAktivasiName;
        document.getElementById("display-pengulangan").textContent =
            selectedPengulanganName; // Tambahkan ini

        // Update hidden fields
        document.getElementById("hidden-title").value = title;
        document.getElementById("hidden-questions").value = numQuestions;
        document.getElementById("hidden-duration").value = duration;
        document.getElementById("hidden-description").value = description;
        document.getElementById("hidden-visibility").value = visibility;
        document.getElementById("hidden-aktivasi").value = aktivasi;
        document.getElementById("hidden-categories").value = categories;
        document.getElementById("hidden-mapel").value = mapel;
        document.getElementById("hidden-pengulangan").value = pengulangan; // Tambahkan ini

        // Generate question forms
        generateQuestionForms(numQuestions);

        // Show questions container and hide setup
        setupCard.style.display = "none";
        questionsContainer.style.display = "block";

        // Scroll to top
        window.scrollTo(0, 0);
    });

    // Handle back to setup button
    backButton.addEventListener("click", function () {
        setupCard.style.display = "block";
        questionsContainer.style.display = "none";
        window.scrollTo(0, 0);
    });

    // Generate question forms dynamically
    function generateQuestionForms(numQuestions) {
        questionsList.innerHTML = "";
        questionIndex = 1;

        for (let i = 1; i <= numQuestions; i++) {
            const questionCard = createQuestionForm(i);
            questionsList.appendChild(questionCard);
        }

        // Set questionIndex untuk soal tambahan setelah soal utama
        questionIndex = numQuestions + 1;
    }

    function addNewQuestion() {
        const questionCard = createQuestionForm(questionIndex);
        questionsList.appendChild(questionCard);
        questionIndex++;

        // Update hidden field untuk jumlah soal
        const currentQuestionCount = questionsList.children.length;
        document.getElementById("hidden-questions").value =
            currentQuestionCount;

        // Update display
        document.getElementById("display-questions").textContent =
            currentQuestionCount;
    }

    // Create individual question form
    // Modifikasi fungsi createQuestionForm untuk menambahkan button hapus
    function createQuestionForm(questionNumber) {
        const card = document.createElement("div");
        card.className = "card mb-4";
        card.setAttribute("data-question-id", questionNumber); // Tambahkan data attribute
        card.innerHTML = `
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">Soal ${questionNumber}</h6>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteQuestion(this)" title="Hapus Soal">
                <i class="ti ti-trash me-1"></i>Hapus
            </button>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="question-${questionNumber}" class="form-label">Teks Soal <span class="text-danger">*</span></label>
                <textarea class="form-control" id="question-${questionNumber}" name="questions[${questionNumber}][text]" rows="3" required placeholder="Masukkan soal di sini..."></textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="question-type-${questionNumber}" class="form-label">Tipe Soal <span class="text-danger">*</span></label>
                        <select class="form-select" id="question-type-${questionNumber}" name="questions[${questionNumber}][type]" required onchange="handleQuestionTypeChange(${questionNumber})">
                            <option value="">Pilih Tipe Soal</option>
                            <option value="pilihan_ganda">Pilihan Ganda</option>
                            <option value="essay">Essay</option>
                            <option value="benar_salah">Benar/Salah</option>
                            <option value="checkbox">Checkbox (Multiple Answer)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="question-weight-${questionNumber}" class="form-label">Bobot Soal <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="question-weight-${questionNumber}" name="questions[${questionNumber}][weight]" min="1" max="100" required placeholder="1-100">
                    </div>
                </div>
            </div>
            <div id="question-options-${questionNumber}">
                <!-- Dynamic options will be inserted here -->
            </div>
        </div>
    `;
        return card;
    }

    // Fungsi untuk menghapus soal
    window.deleteQuestion = function (button) {
        const card = button.closest(".card");
        const questionId = card.getAttribute("data-question-id");

        // Konfirmasi sebelum menghapus
        if (confirm(`Apakah Anda yakin ingin menghapus Soal ${questionId}?`)) {
            // Hapus card dari DOM
            card.remove();

            // Update jumlah soal di hidden field dan display
            updateQuestionCount();

            // Reorder nomor soal yang tersisa
            reorderQuestions();
        }
    };

    // Fungsi untuk update jumlah soal setelah penghapusan
    function updateQuestionCount() {
        const remainingQuestions = document.querySelectorAll(
            "#questions-list .card"
        ).length;

        // Update hidden field
        document.getElementById("hidden-questions").value = remainingQuestions;

        // Update display
        document.getElementById("display-questions").textContent =
            remainingQuestions;
    }

    // Fungsi untuk mengurutkan ulang nomor soal setelah penghapusan
    function reorderQuestions() {
        const questionCards = document.querySelectorAll(
            "#questions-list .card"
        );

        questionCards.forEach((card, index) => {
            const newQuestionNumber = index + 1;
            const oldQuestionId = card.getAttribute("data-question-id");

            // Update data attribute
            card.setAttribute("data-question-id", newQuestionNumber);

            // Update header title
            const cardTitle = card.querySelector(".card-title");
            cardTitle.textContent = `Soal ${newQuestionNumber}`;

            // Update semua ID dan name attributes dalam card
            updateCardAttributes(card, oldQuestionId, newQuestionNumber);
        });

        // Update questionIndex untuk soal baru selanjutnya
        questionIndex = questionCards.length + 1;
    }

    // Fungsi helper untuk update attributes dalam card
    function updateCardAttributes(card, oldId, newId) {
        // Update textarea soal
        const questionTextarea = card.querySelector(`#question-${oldId}`);
        if (questionTextarea) {
            questionTextarea.id = `question-${newId}`;
            questionTextarea.name = `questions[${newId}][text]`;
        }

        // Update question type select
        const typeSelect = card.querySelector(`#question-type-${oldId}`);
        if (typeSelect) {
            typeSelect.id = `question-type-${newId}`;
            typeSelect.name = `questions[${newId}][type]`;
            typeSelect.setAttribute(
                "onchange",
                `handleQuestionTypeChange(${newId})`
            );
        }

        // Update weight input
        const weightInput = card.querySelector(`#question-weight-${oldId}`);
        if (weightInput) {
            weightInput.id = `question-weight-${newId}`;
            weightInput.name = `questions[${newId}][weight]`;
        }

        // Update options container
        const optionsContainer = card.querySelector(
            `#question-options-${oldId}`
        );
        if (optionsContainer) {
            optionsContainer.id = `question-options-${newId}`;

            // Update semua input dalam options container
            updateOptionsAttributes(optionsContainer, oldId, newId);
        }

        // Update label for attributes
        const labels = card.querySelectorAll("label");
        labels.forEach((label) => {
            const forAttr = label.getAttribute("for");
            if (forAttr && forAttr.includes(oldId)) {
                label.setAttribute("for", forAttr.replace(oldId, newId));
            }
        });
    }

    // Fungsi helper untuk update attributes dalam options
    function updateOptionsAttributes(container, oldId, newId) {
        // Update pilihan ganda options
        const optionInputs = container.querySelectorAll(
            `input[id*="option-"][id*="-${oldId}"]`
        );
        optionInputs.forEach((input) => {
            const newIdAttr = input.id.replace(`-${oldId}`, `-${newId}`);
            input.id = newIdAttr;
            input.name = input.name.replace(`[${oldId}]`, `[${newId}]`);
        });

        // Update radio buttons untuk correct answer
        const radioInputs = container.querySelectorAll(
            `input[name*="questions[${oldId}][correct_answer]"]`
        );
        radioInputs.forEach((input) => {
            input.name = `questions[${newId}][correct_answer]`;
            const newIdAttr = input.id.replace(`-${oldId}`, `-${newId}`);
            input.id = newIdAttr;
        });

        // Update checkbox options
        const checkboxOptionInputs = container.querySelectorAll(
            `input[name*="questions[${oldId}][checkbox_options]"]`
        );
        checkboxOptionInputs.forEach((input) => {
            input.name = `questions[${newId}][checkbox_options][]`;
        });

        const checkboxCorrectInputs = container.querySelectorAll(
            `input[name*="questions[${oldId}][checkbox_correct]"]`
        );
        checkboxCorrectInputs.forEach((input, index) => {
            input.name = `questions[${newId}][checkbox_correct][]`;
            const newIdAttr = `checkbox-correct-${newId}-${index}`;
            input.id = newIdAttr;
        });

        // Update essay answer
        const essayTextarea = container.querySelector(`#essay-answer-${oldId}`);
        if (essayTextarea) {
            essayTextarea.id = `essay-answer-${newId}`;
            essayTextarea.name = `questions[${newId}][correct_answer]`;
        }

        // Update checkbox container dan button
        const checkboxContainer = container.querySelector(
            `#checkbox-options-${oldId}`
        );
        if (checkboxContainer) {
            checkboxContainer.id = `checkbox-options-${newId}`;
        }

        const addCheckboxButton = container.querySelector(
            `button[onclick*="addCheckboxOption(${oldId})"]`
        );
        if (addCheckboxButton) {
            addCheckboxButton.setAttribute(
                "onclick",
                `addCheckboxOption(${newId})`
            );
        }
    }

    // Handle question type change
    window.handleQuestionTypeChange = function (questionNumber) {
        const typeSelect = document.getElementById(
            `question-type-${questionNumber}`
        );
        const optionsContainer = document.getElementById(
            `question-options-${questionNumber}`
        );
        const selectedType = typeSelect.value;

        optionsContainer.innerHTML = "";

        switch (selectedType) {
            case "pilihan_ganda":
                optionsContainer.innerHTML =
                    createMultipleChoiceOptions(questionNumber);
                break;
            case "essay":
                optionsContainer.innerHTML = createEssayOptions(questionNumber);
                break;
            case "benar_salah":
                optionsContainer.innerHTML =
                    createTrueFalseOptions(questionNumber);
                break;
            case "checkbox":
                optionsContainer.innerHTML =
                    createCheckboxOptions(questionNumber);
                break;
        }
    };

    // Create multiple choice options
    function createMultipleChoiceOptions(questionNumber) {
        return `
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="option-a-${questionNumber}" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="option-a-${questionNumber}" name="questions[${questionNumber}][option_a]" required placeholder="Masukkan pilihan A">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="option-b-${questionNumber}" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="option-b-${questionNumber}" name="questions[${questionNumber}][option_b]" required placeholder="Masukkan pilihan B">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="option-c-${questionNumber}" class="form-label">Pilihan C <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="option-c-${questionNumber}" name="questions[${questionNumber}][option_c]" required placeholder="Masukkan pilihan C">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="option-d-${questionNumber}" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="option-d-${questionNumber}" name="questions[${questionNumber}][option_d]" required placeholder="Masukkan pilihan D">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-a-${questionNumber}" value="A" required>
                        <label class="form-check-label" for="correct-a-${questionNumber}">A</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-b-${questionNumber}" value="B" required>
                        <label class="form-check-label" for="correct-b-${questionNumber}">B</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-c-${questionNumber}" value="C" required>
                        <label class="form-check-label" for="correct-c-${questionNumber}">C</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-d-${questionNumber}" value="D" required>
                        <label class="form-check-label" for="correct-d-${questionNumber}">D</label>
                    </div>
                </div>
            </div>
        `;
    }

    // Create essay options
    function createEssayOptions(questionNumber) {
        return `
            <div class="mb-3">
                <label for="essay-answer-${questionNumber}" class="form-label">Jawaban Model (Opsional)</label>
                <textarea class="form-control" id="essay-answer-${questionNumber}" name="questions[${questionNumber}][correct_answer]" rows="3" placeholder="Masukkan jawaban model untuk referensi penilaian (opsional)"></textarea>
                <small class="form-text text-muted">Jawaban model ini akan digunakan sebagai referensi untuk penilaian manual.</small>
            </div>
        `;
    }

    // Create true/false options
    function createTrueFalseOptions(questionNumber) {
        return `
            <div class="mb-3">
                <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-true-${questionNumber}" value="Benar" required>
                        <label class="form-check-label" for="correct-true-${questionNumber}">Benar</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-false-${questionNumber}" value="Salah" required>
                        <label class="form-check-label" for="correct-false-${questionNumber}">Salah</label>
                    </div>
                </div>
            </div>
        `;
    }

    // Modifikasi fungsi createCheckboxOptions untuk membuat struktur yang konsisten
    function createCheckboxOptions(questionNumber) {
        return `
        <div class="mb-3">
            <label class="form-label">Opsi Pilihan <span class="text-danger">*</span></label>
            <div id="checkbox-options-${questionNumber}">
                <div class="row mb-2">
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="questions[${questionNumber}][checkbox_options][]" placeholder="Masukkan opsi 1" required>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="questions[${questionNumber}][checkbox_correct][]" value="0" id="checkbox-correct-${questionNumber}-0">
                            <label class="form-check-label" for="checkbox-correct-${questionNumber}-0">Benar</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="questions[${questionNumber}][checkbox_options][]" placeholder="Masukkan opsi 2" required>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="questions[${questionNumber}][checkbox_correct][]" value="1" id="checkbox-correct-${questionNumber}-1">
                            <label class="form-check-label" for="checkbox-correct-${questionNumber}-1">Benar</label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCheckboxOption(${questionNumber})">
                <i class="ti ti-plus me-1"></i>Tambah Opsi
            </button>
        </div>
    `;
    }

    // Perbaikan fungsi addCheckboxOption - pastikan value checkbox sesuai dengan index yang benar
    window.addCheckboxOption = function (questionNumber) {
        const container = document.getElementById(
            `checkbox-options-${questionNumber}`
        );
        const optionCount = container.children.length;

        if (optionCount >= 10) {
            alert("Maksimal 10 opsi untuk setiap soal checkbox.");
            return;
        }

        const newOption = document.createElement("div");
        newOption.className = "row mb-2";
        newOption.innerHTML = `
        <div class="col-md-10">
            <input type="text" class="form-control" name="questions[${questionNumber}][checkbox_options][]" placeholder="Masukkan opsi ${
            optionCount + 1
        }" required>
        </div>
        <div class="col-md-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="questions[${questionNumber}][checkbox_correct][]" value="${optionCount}" id="checkbox-correct-${questionNumber}-${optionCount}">
                <label class="form-check-label" for="checkbox-correct-${questionNumber}-${optionCount}">Benar</label>
            </div>
        </div>
    `;

        container.appendChild(newOption);
    };

    document
        .getElementById("final-quiz-form")
        .addEventListener("submit", function (e) {
            const questions = document.querySelectorAll('[name*="[text]"]');
            let isValid = true;
            let errorMessage = "";

            // Validate each question
            questions.forEach((question, index) => {
                // Ambil questionNumber dari name attribute untuk handle indexing yang benar
                const nameAttr = question.getAttribute("name");
                const questionNumber = nameAttr.match(/\[(\d+)\]/)[1];

                const typeSelect = document.getElementById(
                    `question-type-${questionNumber}`
                );
                const weightInput = document.getElementById(
                    `question-weight-${questionNumber}`
                );

                if (!question.value.trim()) {
                    isValid = false;
                    errorMessage = `Harap isi teks untuk Soal ${questionNumber}.`;
                    return;
                }

                if (!typeSelect || !typeSelect.value) {
                    isValid = false;
                    errorMessage = `Harap pilih tipe soal untuk Soal ${questionNumber}.`;
                    return;
                }

                if (
                    !weightInput ||
                    !weightInput.value ||
                    weightInput.value < 1 ||
                    weightInput.value > 100
                ) {
                    isValid = false;
                    errorMessage = `Harap isi bobot soal (1-100) untuk Soal ${questionNumber}.`;
                    return;
                }

                // Validate based on question type
                const questionType = typeSelect.value;

                if (questionType === "pilihan_ganda") {
                    const options = [
                        document.getElementById(`option-a-${questionNumber}`),
                        document.getElementById(`option-b-${questionNumber}`),
                        document.getElementById(`option-c-${questionNumber}`),
                        document.getElementById(`option-d-${questionNumber}`),
                    ];

                    options.forEach((option, optIndex) => {
                        if (!option || !option.value.trim()) {
                            isValid = false;
                            errorMessage = `Harap isi Pilihan ${String.fromCharCode(
                                65 + optIndex
                            )} untuk Soal ${questionNumber}.`;
                            return;
                        }
                    });

                    const correctAnswer = document.querySelector(
                        `input[name="questions[${questionNumber}][correct_answer]"]:checked`
                    );
                    if (!correctAnswer) {
                        isValid = false;
                        errorMessage = `Harap pilih jawaban benar untuk Soal ${questionNumber}.`;
                        return;
                    }
                } else if (questionType === "benar_salah") {
                    const correctAnswer = document.querySelector(
                        `input[name="questions[${questionNumber}][correct_answer]"]:checked`
                    );
                    if (!correctAnswer) {
                        isValid = false;
                        errorMessage = `Harap pilih jawaban benar untuk Soal ${questionNumber}.`;
                        return;
                    }
                } else if (questionType === "checkbox") {
                    const checkboxOptions = document.querySelectorAll(
                        `input[name="questions[${questionNumber}][checkbox_options][]"]`
                    );
                    const correctAnswers = document.querySelectorAll(
                        `input[name="questions[${questionNumber}][checkbox_correct][]"]:checked`
                    );

                    // Validasi bahwa minimal ada 2 opsi
                    if (checkboxOptions.length < 2) {
                        isValid = false;
                        errorMessage = `Soal ${questionNumber} harus memiliki minimal 2 opsi.`;
                        return;
                    }

                    // Validasi bahwa semua opsi yang ada harus terisi
                    let hasEmptyOption = false;
                    checkboxOptions.forEach((option, index) => {
                        if (!option.value.trim()) {
                            hasEmptyOption = true;
                        }
                    });

                    if (hasEmptyOption) {
                        isValid = false;
                        errorMessage = `Harap isi semua opsi untuk Soal ${questionNumber}.`;
                        return;
                    }

                    // Validasi bahwa minimal 1 jawaban benar dipilih
                    if (correctAnswers.length === 0) {
                        isValid = false;
                        errorMessage = `Harap pilih minimal 1 jawaban benar untuk Soal ${questionNumber}.`;
                        return;
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
                return false;
            }
        });

    function debugCheckboxData(questionNumber) {
        const checkboxOptions = document.querySelectorAll(
            `input[name="questions[${questionNumber}][checkbox_options][]"]`
        );
        const correctAnswers = document.querySelectorAll(
            `input[name="questions[${questionNumber}][checkbox_correct][]"]:checked`
        );

        console.log(`=== DEBUG Soal ${questionNumber} ===`);
        console.log(`Total opsi: ${checkboxOptions.length}`);

        checkboxOptions.forEach((option, index) => {
            console.log(`Opsi ${index}: "${option.value}"`);
        });

        console.log(
            `Jawaban benar (index): [${Array.from(correctAnswers)
                .map((cb) => cb.value)
                .join(", ")}]`
        );
        console.log(`=====================================`);
    }
});
