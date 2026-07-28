# Job Board Platform - Employer Backoffice

Welcome to the **Job Backoffice** repository! This is the employer-facing administrative application for the Job Board Platform, where companies and admins can post jobs and review applications.

*Note: This is part of a decoupled architecture. The candidate-facing application can be found in the [job-app](https://github.com/kha640/job-app) repository, and the shared models in [job-shared](https://github.com/kha640/job-shared).*

## 🌟 Key Features

* **Job Management**: Create, edit, and archive job vacancies easily.
* **Application Review**: View candidate applications, their uploaded resumes, and the AI-generated evaluation score and feedback.
* **Analytics Dashboard**: Get insights into active users, total vacancies, most applied jobs, and conversion rates.

## 📋 System Requirements

* PHP 8.3 or higher
* Composer
* Node.js & NPM
* A supported database (MariaDB / MySQL)

## 🚀 Installation Guide

1. **Clone the repository:**
   ```bash
   git clone https://github.com/kha640/job-backoffice.git
   cd job-backoffice
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Environment Configuration:**
   Copy the `.env.example` file to `.env` and update the environment variables.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration & Migrations:**
   Create a database (e.g., `job_board`) and update your `.env` file with the database credentials.
   This repository contains the authoritative database migrations for the entire platform. Run them using:
   ```bash
   php artisan migrate --seed
   ```
   *Note: Seeders are provided to populate the database with initial sample data.*

## 🏗️ Architecture Note

The Eloquent models (e.g., `JobVacancy`, `JobApplication`, `Resume`) are maintained in the separate `kha640/job-shared` package. 
Database migrations are intentionally located here in the `job-backoffice` project to maintain loose coupling; the back-office controls the schema, while the `job-app` consumes it. 
If you prefer a different architecture, you are welcome to move the migrations directly into the `job-shared` package so that any consumer app can run them.

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guidelines](.github/CONTRIBUTING.md) for details on how to submit pull requests, report issues, and format your code (we use Laravel Pint).

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
