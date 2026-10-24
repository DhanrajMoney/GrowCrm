# Grow CRM (v1.11)

A modular, multi-tenant capable Customer Relationship Management (CRM), Project Management, and Invoicing web application built on **Laravel 8** and a Server-Driven UI / Hypermedia AJAX architecture.

---

## 📑 Table of Contents
- [Overview](#-overview)
- [Key Features](#-key-features)
- [Tech Stack & Architecture](#-tech-stack--architecture)
- [System Requirements](#-system-requirements)
- [Installation & Setup](#-installation--setup)
- [Environment Configuration](#-environment-configuration)
- [Cron Job Configuration](#-cron-job-configuration)
- [Directory Permissions](#-directory-permissions)
- [Useful Commands](#-useful-commands)
- [Documentation & Roadmap](#-documentation--roadmap)

---

## 🚀 Overview

Grow CRM provides an end-to-end operational suite for service businesses, agencies, and freelancers. It bridges client management, project execution, time tracking, billing, contracts, and customer support into a single unified platform.

Unlike typical monolithic or heavy single-page apps, Grow CRM uses **NXAJAX**—a server-driven UI layer that renders Blade components on the server and applies declarative DOM mutations dynamically without full-page reloads.

For deep architectural details, see [architecture.md](architecture.md).

---

## 🌟 Key Features

### 1. Client & Contact Management
- Comprehensive client profiles with custom fields, documents, and history timeline.
- Multi-contact support per client account with role-based portal access.
- Dedicated client portal view for invoices, projects, tasks, and support tickets.

### 2. Lead Management & Sales Pipeline
- Visual Kanban boards and list views for lead stages.
- Embeddable web-to-lead forms with custom fields.
- Direct lead conversion into clients and projects with full activity history transfer.

### 3. Project & Task Management
- Project milestones, task lists, and visual progress tracking.
- Interactive Gantt and Kanban views for tasks.
- Task assignees, checklists, file attachments, and activity comment streams.
- Integrated time tracking (timer widget and manual timesheets).

### 4. Billing, Invoicing & Subscriptions
- One-time and recurring invoices with automated PDF generation (DomPDF).
- Estimates & Quotations with one-click conversion to invoices.
- Payment gateway integrations: **Stripe**, **Razorpay**, **Mollie**, and offline payment tracking.
- Expense tracking with billable client rebilling and receipt uploads.

### 5. Contracts & Proposals
- Digital signatures and legally binding contract agreements.
- Rich text proposal builder with dynamic placeholder tags and client acceptance tracking.

### 6. Support Tickets & Knowledgebase
- Multi-department ticketing system with priority levels and canned responses.
- Public and client-only knowledgebase article repositories.

---

## 🛠 Tech Stack & Architecture

- **Backend Framework**: [Laravel 8.x](https://laravel.com/) (PHP `>= 7.2.5`, supports PHP 7.4 / 8.0)
- **Database**: MySQL 5.7+ / MariaDB 10.2+
- **Frontend Layer**: Blade Templates, Bootstrap 4, jQuery, Noty.js, Pickadate, Dropzone, Select2
- **Dynamic Engine**: Proprietary `NXAJAX` Server-Driven UI engine (`public/js/core/ajax.js`)
- **Modularity**: `nwidart/laravel-modules` for pluggable modules (`application/Modules/`)
- **PDF Engine**: `barryvdh/laravel-dompdf`

---

## 📋 System Requirements

### Server & PHP
- **PHP**: `^7.2.5 || ^8.0`
- **Required PHP Extensions**:
  - `BCMath`
  - `Ctype`
  - `cURL`
  - `DOM / XML`
  - `Fileinfo`
  - `GD` or `Imagick`
  - `JSON`
  - `Mbstring`
  - `OpenSSL`
  - `PDO` & `pdo_mysql`
  - `Tokenizer`
  - `Zip`
- **Web Server**: Apache (`mod_rewrite` enabled) or Nginx

---

## 💾 Installation & Setup

### 1. Clone or Extract the Project
Ensure the project is placed in your web server root (or configured virtual host directory):
```bash
cd /var/www/growcrm
# or your local web directory
```

### 2. Configure Environment (`.env`)
Copy or verify the configuration in `application/.env`:
```ini
APP_NAME="Grow CRM"
APP_ENV=production
APP_KEY=base64:your_generated_app_key
APP_DEBUG=false
APP_URL=https://your-crm-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=growcrm_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 3. Database Initialization
You can initialize the database using either method:
- **Option A (SQL Import)**: Import `setup.sql` directly into your MySQL database:
  ```bash
  mysql -u your_db_user -p growcrm_db < setup.sql
  ```
- **Option B (Web Installer)**: If accessing a fresh installation in your browser, navigate to:
  ```
  http://your-domain.com/setup
  ```
  Follow the on-screen installer to verify directory permissions and establish the database connection.

---

## 🔒 Directory Permissions

The following directories must be writable by the web server (`chmod -R 775` or `chmod -R 777` depending on environment):

```bash
chmod -R 775 updates
chmod -R 775 storage
chmod -R 775 application/storage
chmod -R 775 application/bootstrap/cache
```

Specifically:
- `/updates`
- `/storage` (including `avatars`, `logos`, `files`, `temp`)
- `/application/storage` (including `framework`, `logs`, `app/purifier`)
- `/application/bootstrap/cache`

---

## ⏰ Cron Job Configuration

Grow CRM requires a single background cron job running every minute to process email queues, invoice generation, task recurring schedules, and automated reminders.

Add the following entry to your server's crontab (`crontab -e`):

```cron
* * * * * cd /path/to/growcrm/application && php artisan schedule:run >> /dev/null 2>&1
```

### What the scheduler runs:
- `App\Cronjobs\EmailCron`: Sends queued notification emails.
- `App\Cronjobs\EmailBillsCron`: Compiles and delivers PDF invoices and estimates.
- `App\Cronjobs\RecurringInvoicesCron`: Generates recurring invoices on scheduled dates.
- `App\Cronjobs\RecurringTasksCron`: Creates recurring project tasks.
- `App\Cronjobs\OverdueInvoicesCron`: Flags overdue accounts and updates statuses.
- `App\Cronjobs\ReminderCron`: Dispatches user and client reminders.
- `App\Cronjobs\Stripe\SubscriptionPayment`: Syncs recurring Stripe subscriptions.

---

## ⚡ Useful Commands

All Artisan commands must be executed from inside the `application` directory:

```bash
cd application

# Clear application configuration cache
php artisan config:clear

# Clear application route cache
php artisan route:clear

# Clear compiled view cache
php artisan view:clear

# Clear application general cache
php artisan cache:clear

# Run scheduler manually for testing
php artisan schedule:run
```

---

## 📖 Documentation & Roadmap

- Detailed Architecture & Design Patterns: [architecture.md](architecture.md)
- Development Roadmap & Maintenance Plan: [plan.md](plan.md)

