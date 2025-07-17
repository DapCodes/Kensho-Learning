<?php
// database/seeders/SoalSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;

class SoalSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Soal Pilihan_Ganda (5 Soal) =====
        Soal::insert([
            [
                'quiz_id' => 1,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Apa itu variabel dalam pemrograman?',
                'pilihan_a' => 'Tempat menyimpan data',
                'pilihan_b' => 'Perintah untuk mencetak output',
                'pilihan_c' => 'Tipe data',
                'pilihan_d' => 'Fungsi bawaan',
                'jawaban_benar' => 'A',
                'bobot' => 20,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Bahasa pemrograman manakah yang digunakan untuk web frontend?',
                'pilihan_a' => 'Python',
                'pilihan_b' => 'JavaScript',
                'pilihan_c' => 'C++',
                'pilihan_d' => 'Java',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Manakah yang merupakan struktur kontrol?',
                'pilihan_a' => 'if',
                'pilihan_b' => 'print',
                'pilihan_c' => 'int',
                'pilihan_d' => 'return',
                'jawaban_benar' => 'A',
                'bobot' => 20,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Apakah output dari 2 + 3 * 4 dalam bahasa pemrograman?',
                'pilihan_a' => '20',
                'pilihan_b' => '14',
                'pilihan_c' => '18',
                'pilihan_d' => '24',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Apa fungsi dari perulangan (loop)?',
                'pilihan_a' => 'Menghentikan program',
                'pilihan_b' => 'Menyimpan data',
                'pilihan_c' => 'Menjalankan kode berulang',
                'pilihan_d' => 'Mendeklarasikan variabel',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
        ]);

        // ===== Soal Benar / Salah (5 Soal) =====
        Soal::insert([
            [
                'quiz_id' => 1,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Python adalah bahasa pemrograman yang diketik secara dinamis.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Variabel di JavaScript harus diawali dengan angka.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'C++ adalah bahasa pemrograman berbasis objek.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'HTML merupakan bahasa pemrograman.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Fungsi digunakan untuk membuat blok kode yang dapat dipanggil.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
        ]);

        // ===== Soal Checkbox (3 Soal) =====
        Soal::insert([
            [
                'quiz_id' => 1,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Manakah dari berikut ini termasuk bahasa pemrograman?',
                'pilihan_a' => 'Python',
                'pilihan_b' => 'HTML',
                'pilihan_c' => 'CSS',
                'pilihan_d' => 'Java',
                'pilihan_e' => 'MySQL',
                'jawaban_benar' => '0,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih fitur dari paradigma OOP:',
                'pilihan_a' => 'Encapsulation',
                'pilihan_b' => 'Inheritance',
                'pilihan_c' => 'Compilation',
                'pilihan_d' => 'Polymorphism',
                'pilihan_e' => 'Looping',
                'jawaban_benar' => '0,1,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Fungsi utama dari IDE adalah:',
                'pilihan_a' => 'Menulis kode',
                'pilihan_b' => 'Debugging',
                'pilihan_c' => 'Rendering gambar',
                'pilihan_d' => 'Menjalankan program',
                'pilihan_e' => 'Mengelola database',
                'jawaban_benar' => '0,1,3',
                'bobot' => 25,
            ],
        ]);

        // ===== Soal Essay (2 Soal) =====
        Soal::insert([
            [
                'quiz_id' => 1,
                'tipe' => 'essay',
                'pertanyaan' => 'Jelaskan perbedaan antara compiler dan interpreter!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
            [
                'quiz_id' => 1,
                'tipe' => 'essay',
                'pertanyaan' => 'Sebutkan dan jelaskan 3 struktur dasar pemrograman!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
        ]);




        $quizId = 2;
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Berapakah hasil dari 4 + 5?',
                'pilihan_a' => '7',
                'pilihan_b' => '8',
                'pilihan_c' => '9',
                'pilihan_d' => '10',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Berapakah hasil dari 10 - 6?',
                'pilihan_a' => '5',
                'pilihan_b' => '4',
                'pilihan_c' => '3',
                'pilihan_d' => '6',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => '2 + 2 + 2 = ?',
                'pilihan_a' => '4',
                'pilihan_b' => '6',
                'pilihan_c' => '8',
                'pilihan_d' => '10',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Berapakah 15 dikurangi 5?',
                'pilihan_a' => '5',
                'pilihan_b' => '10',
                'pilihan_c' => '20',
                'pilihan_d' => '0',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Berapakah 9 + 1?',
                'pilihan_a' => '11',
                'pilihan_b' => '10',
                'pilihan_c' => '9',
                'pilihan_d' => '12',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
        ]);

        // ===== Soal Benar / Salah (5 Soal) =====
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => '5 + 5 = 10',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => '7 - 2 = 6',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => '3 + 4 = 7',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => '0 adalah angka ganjil.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => '6 - 6 = 0',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
        ]);

        // ===== Soal Checkbox (3 Soal) =====
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih bilangan genap:',
                'pilihan_a' => '1',
                'pilihan_b' => '2',
                'pilihan_c' => '3',
                'pilihan_d' => '4',
                'pilihan_e' => '5',
                'jawaban_benar' => '1,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih hasil penjumlahan yang benar:',
                'pilihan_a' => '2 + 2 = 4',
                'pilihan_b' => '3 + 3 = 5',
                'pilihan_c' => '4 + 1 = 5',
                'pilihan_d' => '5 + 0 = 5',
                'pilihan_e' => '1 + 1 = 3',
                'jawaban_benar' => '0,2,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih angka yang lebih dari 5:',
                'pilihan_a' => '3',
                'pilihan_b' => '6',
                'pilihan_c' => '7',
                'pilihan_d' => '4',
                'pilihan_e' => '8',
                'jawaban_benar' => '1,2,4',
                'bobot' => 25,
            ],
        ]);

        // ===== Soal Essay (2 Soal) =====
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Tuliskan hasil dari 6 + 7 dan jelaskan bagaimana kamu menghitungnya!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Apa itu bilangan genap? Berikan contohnya!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
        ]);

        // Quiz 3: Bahasa Indonesia Dasar
        $this->createBahasaIndonesiaQuiz();

        // Quiz 4: Bahasa Inggris Elementary
        $this->createBahasaInggrisQuiz();

        // Quiz 5: Biologi Dasar
        $this->createBiologiQuiz();

        // Quiz 6: Sejarah Indonesia
        $this->createSejarahQuiz();

        // Quiz 7: Fisika Dasar
        $this->createFisikaQuiz();

        // Quiz 8: Geografi Indonesia
        $this->createGeografiQuiz();

        // Quiz 9: Seni Budaya
        $this->createSeniBudayaQuiz();
    }

    private function createBahasaIndonesiaQuiz()
    {
        $quizId = 3;

        // Pilihan Ganda (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Kata "berlari" termasuk jenis kata...',
                'pilihan_a' => 'Kata benda',
                'pilihan_b' => 'Kata kerja',
                'pilihan_c' => 'Kata sifat',
                'pilihan_d' => 'Kata keterangan',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Manakah yang merupakan kalimat aktif?',
                'pilihan_a' => 'Buku dibaca oleh Ani',
                'pilihan_b' => 'Kue dimakan oleh adik',
                'pilihan_c' => 'Ani membaca buku',
                'pilihan_d' => 'Mobil dikendarai ayah',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Sinonim kata "cantik" adalah...',
                'pilihan_a' => 'Jelek',
                'pilihan_b' => 'Indah',
                'pilihan_c' => 'Buruk',
                'pilihan_d' => 'Kotor',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Pengarang novel "Laskar Pelangi" adalah...',
                'pilihan_a' => 'Pramoedya Ananta Toer',
                'pilihan_b' => 'Andrea Hirata',
                'pilihan_c' => 'Tere Liye',
                'pilihan_d' => 'Habiburrahman El Shirazy',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Huruf kapital digunakan pada awal...',
                'pilihan_a' => 'Setiap kata',
                'pilihan_b' => 'Nama orang dan tempat',
                'pilihan_c' => 'Kata kerja',
                'pilihan_d' => 'Kata sifat',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
        ]);

        // Benar/Salah (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Kata "merah" termasuk kata sifat.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Kalimat "Ayah pergi ke kantor" adalah kalimat pasif.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Pantun memiliki pola rima a-b-a-b.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Ejaan Yang Disempurnakan (EYD) sudah tidak berlaku lagi.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Gugur Bunga karya Chairil Anwar adalah sebuah puisi.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
        ]);

        // Checkbox (3 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Manakah yang termasuk unsur intrinsik cerpen?',
                'pilihan_a' => 'Tema',
                'pilihan_b' => 'Biografi pengarang',
                'pilihan_c' => 'Tokoh',
                'pilihan_d' => 'Alur',
                'pilihan_e' => 'Kondisi sosial',
                'jawaban_benar' => '0,2,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih kata yang menggunakan imbuhan me-:',
                'pilihan_a' => 'Membaca',
                'pilihan_b' => 'Berlari',
                'pilihan_c' => 'Menulis',
                'pilihan_d' => 'Berjalan',
                'pilihan_e' => 'Melompat',
                'jawaban_benar' => '0,2,4',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Manakah yang termasuk jenis-jenis puisi lama?',
                'pilihan_a' => 'Pantun',
                'pilihan_b' => 'Sonnet',
                'pilihan_c' => 'Syair',
                'pilihan_d' => 'Balada',
                'pilihan_e' => 'Gurindam',
                'jawaban_benar' => '0,2,4',
                'bobot' => 25,
            ],
        ]);

        // Essay (2 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Jelaskan perbedaan antara kalimat aktif dan kalimat pasif! Berikan masing-masing contoh!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Sebutkan dan jelaskan struktur teks eksposisi!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
        ]);
    }

    private function createBahasaInggrisQuiz()
    {
        $quizId = 4;

        // Pilihan Ganda (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'What is the past tense of "go"?',
                'pilihan_a' => 'Goed',
                'pilihan_b' => 'Went',
                'pilihan_c' => 'Gone',
                'pilihan_d' => 'Going',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Choose the correct sentence:',
                'pilihan_a' => 'She are a teacher',
                'pilihan_b' => 'She is a teacher',
                'pilihan_c' => 'She am a teacher',
                'pilihan_d' => 'She be a teacher',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'What does "beautiful" mean?',
                'pilihan_a' => 'Jelek',
                'pilihan_b' => 'Cantik',
                'pilihan_c' => 'Besar',
                'pilihan_d' => 'Kecil',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Which article is used before "apple"?',
                'pilihan_a' => 'A',
                'pilihan_b' => 'An',
                'pilihan_c' => 'The',
                'pilihan_d' => 'No article',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'What is the plural form of "child"?',
                'pilihan_a' => 'Childs',
                'pilihan_b' => 'Childes',
                'pilihan_c' => 'Children',
                'pilihan_d' => 'Childrens',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
        ]);

        // Benar/Salah (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => '"I am happy" is correct English grammar.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => '"He don\'t like apples" is grammatically correct.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'The word "dog" is a noun.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Present continuous tense uses "to be + verb-ing".',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => '"Good" and "well" can always be used interchangeably.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
        ]);

        // Checkbox (3 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Which of these are pronouns?',
                'pilihan_a' => 'I',
                'pilihan_b' => 'Book',
                'pilihan_c' => 'They',
                'pilihan_d' => 'Run',
                'pilihan_e' => 'We',
                'jawaban_benar' => '0,2,4',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Select the correct forms of "to be":',
                'pilihan_a' => 'Am',
                'pilihan_b' => 'Been',
                'pilihan_c' => 'Is',
                'pilihan_d' => 'Are',
                'pilihan_e' => 'Was',
                'jawaban_benar' => '0,2,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Which sentences use present tense?',
                'pilihan_a' => 'She reads a book',
                'pilihan_b' => 'He went to school',
                'pilihan_c' => 'They are playing',
                'pilihan_d' => 'I will come tomorrow',
                'pilihan_e' => 'We eat breakfast',
                'jawaban_benar' => '0,2,4',
                'bobot' => 25,
            ],
        ]);

        // Essay (2 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Write a short paragraph (5 sentences) about your daily routine using present tense!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Explain the difference between "a" and "an" with examples!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
        ]);
    }

    private function createBiologiQuiz()
    {
        $quizId = 5;

        // Pilihan Ganda (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Organel yang berfungsi untuk fotosintesis adalah...',
                'pilihan_a' => 'Mitokondria',
                'pilihan_b' => 'Kloroplas',
                'pilihan_c' => 'Ribosom',
                'pilihan_d' => 'Nukleus',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Satuan terkecil dari makhluk hidup adalah...',
                'pilihan_a' => 'Organ',
                'pilihan_b' => 'Jaringan',
                'pilihan_c' => 'Sel',
                'pilihan_d' => 'Organisme',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Proses pernapasan pada tumbuhan terjadi melalui...',
                'pilihan_a' => 'Stomata',
                'pilihan_b' => 'Akar',
                'pilihan_c' => 'Batang',
                'pilihan_d' => 'Bunga',
                'jawaban_benar' => 'A',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Sistem peredaran darah pada manusia termasuk sistem...',
                'pilihan_a' => 'Terbuka',
                'pilihan_b' => 'Tertutup',
                'pilihan_c' => 'Campuran',
                'pilihan_d' => 'Sederhana',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Hormon yang mengatur kadar gula darah adalah...',
                'pilihan_a' => 'Adrenalin',
                'pilihan_b' => 'Insulin',
                'pilihan_c' => 'Tiroksin',
                'pilihan_d' => 'Testosteron',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
        ]);

        // Benar/Salah (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Sel tumbuhan memiliki dinding sel, sedangkan sel hewan tidak.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Fotosintesis menghasilkan karbondioksida dan air.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'DNA terdapat di dalam nukleus sel.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Semua makhluk hidup memerlukan oksigen untuk bernapas.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Ekosistem terdiri dari komponen biotik dan abiotik.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
        ]);

        // Checkbox (3 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Manakah yang termasuk organel sel?',
                'pilihan_a' => 'Mitokondria',
                'pilihan_b' => 'Membran sel',
                'pilihan_c' => 'Ribosom',
                'pilihan_d' => 'Kloroplas',
                'pilihan_e' => 'Sitoplasma',
                'jawaban_benar' => '0,2,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih yang termasuk sistem organ pada manusia:',
                'pilihan_a' => 'Sistem pencernaan',
                'pilihan_b' => 'Sistem pernapasan',
                'pilihan_c' => 'Sistem fotosintesis',
                'pilihan_d' => 'Sistem peredaran darah',
                'pilihan_e' => 'Sistem transportasi',
                'jawaban_benar' => '0,1,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Komponen abiotik dalam ekosistem meliputi:',
                'pilihan_a' => 'Suhu',
                'pilihan_b' => 'Tumbuhan',
                'pilihan_c' => 'Cahaya',
                'pilihan_d' => 'Hewan',
                'pilihan_e' => 'Air',
                'jawaban_benar' => '0,2,4',
                'bobot' => 25,
            ],
        ]);

        // Essay (2 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Jelaskan proses fotosintesis dan tuliskan persamaan reaksinya!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Sebutkan dan jelaskan 5 ciri-ciri makhluk hidup!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
        ]);
    }

    private function createSejarahQuiz()
    {
        $quizId = 6;

        // Pilihan Ganda (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Proklamasi kemerdekaan Indonesia dibacakan pada tanggal...',
                'pilihan_a' => '16 Agustus 1945',
                'pilihan_b' => '17 Agustus 1945',
                'pilihan_c' => '18 Agustus 1945',
                'pilihan_d' => '19 Agustus 1945',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Kerajaan Hindu pertama di Indonesia adalah...',
                'pilihan_a' => 'Majapahit',
                'pilihan_b' => 'Sriwijaya',
                'pilihan_c' => 'Kutai',
                'pilihan_d' => 'Mataram',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Perang Diponegoro terjadi pada tahun...',
                'pilihan_a' => '1825-1830',
                'pilihan_b' => '1826-1830',
                'pilihan_c' => '1825-1829',
                'pilihan_d' => '1824-1829',
                'jawaban_benar' => 'A',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'VOC didirikan pada tahun...',
                'pilihan_a' => '1600',
                'pilihan_b' => '1602',
                'pilihan_c' => '1605',
                'pilihan_d' => '1610',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Siapa yang memimpin perlawanan rakyat Aceh terhadap Belanda?',
                'pilihan_a' => 'Cut Nyak Dhien',
                'pilihan_b' => 'Teuku Umar',
                'pilihan_c' => 'Imam Bonjol',
                'pilihan_d' => 'Diponegoro',
                'jawaban_benar' => 'A',
                'bobot' => 20,
            ],
        ]);

        // Benar/Salah (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Soekarno dan Hatta adalah proklamator kemerdekaan Indonesia.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Kerajaan Sriwijaya terletak di Sumatera Selatan.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Sistem tanam paksa diterapkan oleh Raffles.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Candi Borobudur dibangun pada masa Kerajaan Majapahit.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Konferensi Meja Bundar diadakan di Den Haag.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
        ]);

        // Checkbox (3 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Manakah yang termasuk kerajaan bercorak Hindu-Buddha?',
                'pilihan_a' => 'Majapahit',
                'pilihan_b' => 'Demak',
                'pilihan_c' => 'Sriwijaya',
                'pilihan_d' => 'Mataram Islam',
                'pilihan_e' => 'Sailendra',
                'jawaban_benar' => '0,2,4',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih tokoh perjuangan melawan penjajah:',
                'pilihan_a' => 'Diponegoro',
                'pilihan_b' => 'Van den Bosch',
                'pilihan_c' => 'Imam Bonjol',
                'pilihan_d' => 'Daendels',
                'pilihan_e' => 'Pattimura',
                'jawaban_benar' => '0,2,4',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Organisasi pergerakan nasional meliputi:',
                'pilihan_a' => 'Budi Utomo',
                'pilihan_b' => 'VOC',
                'pilihan_c' => 'Sarekat Islam',
                'pilihan_d' => 'Indische Partij',
                'pilihan_e' => 'Cultuur Stelsel',
                'jawaban_benar' => '0,2,3',
                'bobot' => 25,
            ],
        ]);

        // Essay (2 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Jelaskan latar belakang terjadinya Perang Diponegoro dan dampaknya!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Sebutkan dan jelaskan 3 faktor internal penyebab kemunduran VOC!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
        ]);
    }

    private function createFisikaQuiz()
    {
        $quizId = 7;

        // Pilihan Ganda (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Satuan SI untuk gaya adalah...',
                'pilihan_a' => 'Joule',
                'pilihan_b' => 'Newton',
                'pilihan_c' => 'Watt',
                'pilihan_d' => 'Pascal',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Hukum Newton I menyatakan bahwa...',
                'pilihan_a' => 'F = ma',
                'pilihan_b' => 'Aksi = reaksi',
                'pilihan_c' => 'Benda akan tetap diam atau bergerak lurus beraturan',
                'pilihan_d' => 'Energi tidak dapat diciptakan atau dimusnahkan',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Kecepatan cahaya di ruang hampa adalah...',
                'pilihan_a' => '3 × 10⁸ m/s',
                'pilihan_b' => '3 × 10⁷ m/s',
                'pilihan_c' => '3 × 10⁹ m/s',
                'pilihan_d' => '3 × 10⁶ m/s',
                'jawaban_benar' => 'A',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Energi kinetik bergantung pada...',
                'pilihan_a' => 'Massa dan tinggi',
                'pilihan_b' => 'Massa dan kecepatan',
                'pilihan_c' => 'Volume dan massa',
                'pilihan_d' => 'Gaya dan perpindahan',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Bunyi merambat paling cepat melalui...',
                'pilihan_a' => 'Gas',
                'pilihan_b' => 'Cairan',
                'pilihan_c' => 'Padat',
                'pilihan_d' => 'Vakum',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
        ]);

        // Benar/Salah (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Massa dan berat adalah besaran yang sama.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Energi tidak dapat diciptakan atau dimusnahkan.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Percepatan gravitasi di bumi adalah 9,8 m/s².',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Bunyi dapat merambat dalam ruang hampa.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Hukum Ohm menyatakan V = I × R.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
        ]);

        // Checkbox (3 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Manakah yang termasuk besaran pokok?',
                'pilihan_a' => 'Panjang',
                'pilihan_b' => 'Kecepatan',
                'pilihan_c' => 'Massa',
                'pilihan_d' => 'Gaya',
                'pilihan_e' => 'Waktu',
                'jawaban_benar' => '0,2,4',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih sifat-sifat gelombang:',
                'pilihan_a' => 'Refleksi',
                'pilihan_b' => 'Refraksi',
                'pilihan_c' => 'Konveksi',
                'pilihan_d' => 'Interferensi',
                'pilihan_e' => 'Konduksi',
                'jawaban_benar' => '0,1,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Jenis-jenis energi meliputi:',
                'pilihan_a' => 'Energi kinetik',
                'pilihan_b' => 'Energi potensial',
                'pilihan_c' => 'Energi massa',
                'pilihan_d' => 'Energi termal',
                'pilihan_e' => 'Energi listrik',
                'jawaban_benar' => '0,1,3,4',
                'bobot' => 25,
            ],
        ]);

        // Essay (2 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Jelaskan bunyi Hukum Newton II dan berikan contoh penerapannya dalam kehidupan sehari-hari!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Sebutkan dan jelaskan 3 cara perpindahan kalor beserta contohnya!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
        ]);
    }

    private function createGeografiQuiz()
    {
        $quizId = 8;

        // Pilihan Ganda (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Indonesia terletak di antara dua benua, yaitu...',
                'pilihan_a' => 'Asia dan Afrika',
                'pilihan_b' => 'Asia dan Australia',
                'pilihan_c' => 'Australia dan Amerika',
                'pilihan_d' => 'Asia dan Eropa',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Gunung tertinggi di Indonesia adalah...',
                'pilihan_a' => 'Gunung Semeru',
                'pilihan_b' => 'Gunung Kerinci',
                'pilihan_c' => 'Puncak Jaya',
                'pilihan_d' => 'Gunung Rinjani',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Iklim Indonesia adalah...',
                'pilihan_a' => 'Iklim subtropis',
                'pilihan_b' => 'Iklim tropis',
                'pilihan_c' => 'Iklim sedang',
                'pilihan_d' => 'Iklim kutub',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Selat yang memisahkan Pulau Jawa dan Sumatra adalah...',
                'pilihan_a' => 'Selat Malaka',
                'pilihan_b' => 'Selat Sunda',
                'pilihan_c' => 'Selat Lombok',
                'pilihan_d' => 'Selat Makassar',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Provinsi dengan jumlah penduduk terbanyak di Indonesia adalah...',
                'pilihan_a' => 'Jawa Tengah',
                'pilihan_b' => 'Jawa Timur',
                'pilihan_c' => 'Jawa Barat',
                'pilihan_d' => 'Sumatera Utara',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
        ]);

        // Benar/Salah (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Indonesia memiliki 2 musim yaitu musim hujan dan musim kemarau.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Pulau Kalimantan seluruhnya milik Indonesia.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Indonesia dilalui oleh garis khatulistiwa.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Danau Toba terletak di Sumatera Barat.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Indonesia terletak di antara dua samudra yaitu Hindia dan Pasifik.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
        ]);

        // Checkbox (3 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Manakah yang termasuk pulau besar di Indonesia?',
                'pilihan_a' => 'Sumatra',
                'pilihan_b' => 'Bali',
                'pilihan_c' => 'Kalimantan',
                'pilihan_d' => 'Papua',
                'pilihan_e' => 'Lombok',
                'jawaban_benar' => '0,2,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih sumber daya alam Indonesia:',
                'pilihan_a' => 'Minyak bumi',
                'pilihan_b' => 'Emas',
                'pilihan_c' => 'Gas alam',
                'pilihan_d' => 'Batu bara',
                'pilihan_e' => 'Uranium',
                'jawaban_benar' => '0,1,2,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Karakteristik iklim tropis meliputi:',
                'pilihan_a' => 'Suhu tinggi sepanjang tahun',
                'pilihan_b' => 'Curah hujan tinggi',
                'pilihan_c' => 'Salju turun rutin',
                'pilihan_d' => 'Kelembaban tinggi',
                'pilihan_e' => 'Musim dingin yang panjang',
                'jawaban_benar' => '0,1,3',
                'bobot' => 25,
            ],
        ]);

        // Essay (2 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Jelaskan keuntungan letak geografis Indonesia bagi perekonomian!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Sebutkan dan jelaskan 4 faktor yang mempengaruhi persebaran penduduk di Indonesia!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
        ]);
    }

    private function createSeniBudayaQuiz()
    {
        $quizId = 9;

        // Pilihan Ganda (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Tari Kecak berasal dari daerah...',
                'pilihan_a' => 'Jawa Tengah',
                'pilihan_b' => 'Bali',
                'pilihan_c' => 'Sumatera Utara',
                'pilihan_d' => 'Kalimantan Timur',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Alat musik tradisional Angklung berasal dari provinsi...',
                'pilihan_a' => 'Jawa Timur',
                'pilihan_b' => 'Jawa Tengah',
                'pilihan_c' => 'Jawa Barat',
                'pilihan_d' => 'Yogyakarta',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Batik Mega Mendung merupakan motif batik khas dari...',
                'pilihan_a' => 'Solo',
                'pilihan_b' => 'Yogyakarta',
                'pilihan_c' => 'Pekalongan',
                'pilihan_d' => 'Cirebon',
                'jawaban_benar' => 'D',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Rumah adat Toraja yang terkenal dengan atap melengkung ke atas disebut...',
                'pilihan_a' => 'Rumah Gadang',
                'pilihan_b' => 'Tongkonan',
                'pilihan_c' => 'Honai',
                'pilihan_d' => 'Joglo',
                'jawaban_benar' => 'B',
                'bobot' => 20,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => 'Wayang Kulit merupakan seni pertunjukan tradisional yang berasal dari...',
                'pilihan_a' => 'Bali',
                'pilihan_b' => 'Sumatera',
                'pilihan_c' => 'Jawa',
                'pilihan_d' => 'Kalimantan',
                'jawaban_benar' => 'C',
                'bobot' => 20,
            ],
        ]);

        // Benar/Salah (5 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Gamelan adalah alat musik tradisional dari Jawa dan Bali.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Tari Saman berasal dari Sumatera Barat.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Batik telah diakui UNESCO sebagai warisan budaya dunia.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Rumah Gadang adalah rumah adat dari Sumatra Selatan.',
                'jawaban_benar' => 'Salah',
                'bobot' => 10,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'benar_salah',
                'pertanyaan' => 'Reog Ponorogo adalah kesenian tradisional dari Jawa Timur.',
                'jawaban_benar' => 'Benar',
                'bobot' => 10,
            ],
        ]);

        // Checkbox (3 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Manakah yang termasuk alat musik tradisional Indonesia?',
                'pilihan_a' => 'Angklung',
                'pilihan_b' => 'Gitar',
                'pilihan_c' => 'Sasando',
                'pilihan_d' => 'Kolintang',
                'pilihan_e' => 'Piano',
                'jawaban_benar' => '0,2,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Pilih tarian tradisional dari Bali:',
                'pilihan_a' => 'Tari Kecak',
                'pilihan_b' => 'Tari Saman',
                'pilihan_c' => 'Tari Legong',
                'pilihan_d' => 'Tari Barong',
                'pilihan_e' => 'Tari Jaipong',
                'jawaban_benar' => '0,2,3',
                'bobot' => 25,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'checkbox',
                'pertanyaan' => 'Ciri-ciri batik tradisional meliputi:',
                'pilihan_a' => 'Dibuat dengan teknik tutup celup',
                'pilihan_b' => 'Menggunakan lilin (malam)',
                'pilihan_c' => 'Dibuat dengan mesin printing',
                'pilihan_d' => 'Memiliki motif yang bermakna',
                'pilihan_e' => 'Diproduksi massal',
                'jawaban_benar' => '0,1,3',
                'bobot' => 25,
            ],
        ]);

        // Essay (2 soal)
        Soal::insert([
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Jelaskan pentingnya melestarikan seni dan budaya tradisional Indonesia di era globalisasi!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
            [
                'quiz_id' => $quizId,
                'tipe' => 'essay',
                'pertanyaan' => 'Sebutkan dan jelaskan 4 jenis kesenian tradisional Indonesia beserta daerah asalnya!',
                'jawaban_benar' => '',
                'bobot' => 35,
            ],
        ]);
    }
}
