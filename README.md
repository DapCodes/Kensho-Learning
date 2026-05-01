# Dexa — Computer Based Test Platform

**A secure, transparent, and integrity-focused online examination system built for modern educational institutions.**

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-005C84?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

[Live Demo](https://kensho-learning.smkassalaambandung.sch.id/) &nbsp;|&nbsp; [Report a Bug](https://github.com/DapCodes/Kensho-Learning/issues) &nbsp;|&nbsp; [Discussions](https://github.com/DapCodes/Kensho-Learning/discussions)

---

## Overview

Dexa is a web-based Computer Based Test (CBT) application developed with **Laravel 12** and **Bootstrap 5**. It was designed to address a fundamental problem in modern digital examination: the widespread availability of tools and techniques that allow students to cheat during online tests.

Conventional web-based exam systems leave significant gaps — tab switching, browser automation, and scoring manipulation are all relatively easy to exploit. Dexa closes those gaps with a real-time activity monitoring system, a comprehensive audit log, and automated evaluation workflows that reduce the opportunity for human error or interference.

The platform is currently deployed and in active use at SMK Assalaam Bandung.

---

## Features

### Integrity and Anti-Cheating

- **Real-Time Activity Monitoring** — Tracks participant behavior throughout the examination session, flagging suspicious interactions as they occur.
- **Tab Switch Detection** — Records the number of times a participant navigates away from the exam window and surfaces this data to supervisors.
- **Comprehensive Audit Logs** — Every action taken during a session is logged with timestamps, providing a verifiable record of each participant's behavior.
- **Automated Supervisor Alerts** — Exam proctors receive immediate notifications when anomalous activity is detected.

### Exam Management

- **Multiple Question Types** — Supports multiple choice, essay, and other question formats to accommodate diverse assessment needs.
- **Scheduling and Time Controls** — Administrators can define exam windows, enforce per-question or per-exam time limits, and restrict access outside scheduled periods.
- **Question Bank** — Questions are organized by subject, topic, and difficulty, making it easy to assemble and reuse exam content across sessions.

### Scoring and Reporting

- **Automated Grading** — Objective question types are graded instantly upon submission.
- **Result Transparency** — Participants can review their results with clearly presented scores and, where applicable, answer breakdowns.
- **Export and Reporting** — Administrators can export exam results for further analysis or institutional record-keeping.

---

## Technology Stack

| Layer        | Technology         | Version | Purpose                                   |
|--------------|--------------------|---------|-------------------------------------------|
| Backend      | Laravel            | 12      | Application framework, routing, ORM       |
| Frontend     | Bootstrap          | 5       | Responsive UI components and layout       |
| Database     | MySQL / MariaDB    | 8.0+    | Relational data storage                   |
| Runtime      | PHP                | 8.2+    | Server-side scripting                     |
| Build Tools  | Node.js / NPM      | LTS     | Asset compilation via Vite                |

---

## Requirements

Before installing Dexa, ensure your environment meets the following prerequisites:

- PHP >= 8.2 with the following extensions: `BCMath`, `Ctype`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `Tokenizer`, `XML`
- Composer >= 2.x
- Node.js (LTS) and NPM
- MySQL >= 8.0 or MariaDB >= 10.4
- A web server such as Apache or Nginx (for production deployments)

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/DapCodes/Kensho-Learning.git
cd Kensho-Learning
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies and Compile Assets

```bash
npm install
npm run build
```

> For local development, use `npm run dev` instead to enable hot module replacement.

### 4. Configure the Environment

```bash
cp .env.example .env
php artisan key:generate
```

Open the `.env` file and update the following values to match your local environment:

```env
APP_NAME="Dexa CBT"
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dexa_cbt
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 5. Run Migrations and Seed the Database

```bash
php artisan migrate --seed
```

This will create all necessary tables and populate the database with default data, including an initial administrator account.

### 6. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

---

## Default Credentials

After running the database seeder, the following accounts are available for initial access:

| Role          | Email                       | Password   |
|---------------|-----------------------------|------------|
| Administrator | admin@example.com           | password   |
| Participant   | student@example.com         | password   |

> **Important:** Change all default passwords immediately before deploying to a production environment.

---

## Deployment

For production deployments, the following additional steps are recommended:

```bash
# Set the environment to production
APP_ENV=production
APP_DEBUG=false

# Optimize the application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compile production assets
npm run build
```

Ensure your web server is configured to point to the `/public` directory as the document root. Refer to the [Laravel deployment documentation](https://laravel.com/docs/deployment) for server-specific configuration examples.

---

## Project Structure

```
dexa-cbt/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Application controllers
│   │   └── Middleware/        # Request middleware (auth, proctoring)
│   ├── Models/                # Eloquent models
│   └── Services/              # Business logic and exam scoring services
├── database/
│   ├── migrations/            # Database schema definitions
│   └── seeders/               # Default data seeders
├── resources/
│   ├── views/                 # Blade templates
│   ├── css/                   # Stylesheets
│   └── js/                    # JavaScript modules (tab detection, timers)
├── routes/
│   ├── web.php                # Web routes
│   └── api.php                # API routes
└── public/                    # Publicly accessible files
```

---

## Contributing

Contributions are welcome and encouraged. To contribute:

1. Fork the repository.
2. Create a new feature branch: `git checkout -b feature/your-feature-name`
3. Commit your changes with a clear message: `git commit -m "Add: description of your change"`
4. Push the branch to your fork: `git push origin feature/your-feature-name`
5. Open a Pull Request against the `main` branch of this repository.

Please ensure your code follows the existing conventions and that any new functionality is accompanied by appropriate documentation. For significant changes, consider opening an issue first to discuss the proposed approach.

---

## Bug Reports and Support

If you encounter a bug or have a question, please use one of the following channels:

- **Bug Reports:** [Open an issue on GitHub](https://github.com/DapCodes/Kensho-Learning/issues)
- **General Discussion:** [GitHub Discussions](https://github.com/DapCodes/Kensho-Learning/discussions)
- **Direct Contact:** daffaramadhan929@gmail.com

When reporting a bug, please include your PHP version, Laravel version, a description of the problem, and steps to reproduce it.

---

## License

This project is licensed under the [MIT License](LICENSE).

---

## Acknowledgements

Developed by the **Tim Operasi Programmer Mengoding** team.  
Deployed at SMK Assalaam Bandung, West Java, Indonesia.

&copy; 2025 Dexa CBT. All rights reserved.
