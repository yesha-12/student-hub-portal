# StudentHub Portal

A modern PHP student hub with an academic SaaS design. Public pages and student sign-up work with PHP and local JSON storage; the SQL schema remains available for database practicals and future integrations.

## Overview

StudentHub Portal is a student hub built with PHP, featuring:
- Three roles: Guest, Student, and Admin
- Light blue "academic SaaS" design system
- No build tools required - runs on XAMPP PHP built-in server
- Passwords are stored as hashes and user-facing output is escaped

## Live Demo

Visit `http://localhost/studenthub/` after following the setup steps below.

## Quick Start

### 1. Install XAMPP
Download and install XAMPP from: https://apachefriends.org  
Start Apache from XAMPP Control Panel. MySQL is optional for the public portal.

### 2. Place Files
Move the `studenthub` folder to your web root:
- **XAMPP**: `C:\xampp\htdocs\studenthub\`

### 3. Run
Visit `http://localhost/studenthub/` and create a student account. Apache must be able to write to the project-level `data/` directory; it is created when the first account or form submission is saved. Apache blocks direct access to account data files.

### Optional: SQL Practicals
The SQL schema and seed files remain available for database exercises. Import `database/schema.sql` and `database/seed.sql` if you are using those practicals.

## Project Structure

```
studenthub/
├── .htaccess              # Apache rewrites
├── index.php              # Homepage
├── about.php
├── events.php
├── faq.php
├── contact.php
├── feedback.php
├── register.php           # Student registration
├── login.php              # Student login
├── logout.php             # Logout
├── forbidden.php          # 403 Forbidden
├── 404.php                # Page not found
├── includes/
│   ├── config.php         # PDO connection, session, BASE_URL
│   ├── auth.php           # login(), logout(), require_login(), require_role()
│   └── practical13-data.php # Fictional student records for the dashboard demo
├── assets/
│   ├── css/
│   │   ├── tokens.css     # Design tokens (--bg, --primary, etc.)
│   │   ├── base.css       # Page background + radial glow
│   │   └── components.css # Cards, buttons, badges, tables, forms, modals
│   └── js/
│       ├── theme.js       # Theme toggle with localStorage
│       ├── nav.js         # Mobile nav drawer
│       ├── faq.js         # FAQ accordion
│       ├── slider.js      # Image/content slider
│       ├── ui.js          # Toast, FocusTrap, debounce, truncate
│       └── bg-network.js  # 25-blue-dot constellation canvas
├── student/
│   ├── dashboard.php      # Stats + session timer
│   ├── profile.php        # Profile + change password
│   ├── timetable.php      # CSS grid weekly timetable
│   ├── material.php       # Course material cards
│   └── my_events.php      # Registered events
├── admin/
│   ├── dashboard.php      # Stats cards + Chart.js
│   ├── users.php          # User management
│   ├── events.php         # Event CRUD + poster upload
│   └── students.php       # Soft delete, CSV export, bulk actions
├── api/
│   ├── students.php       # CRUD + search+pagination+envelope
│   ├── events.php         # CRUD
│   ├── async_students.php # Async API with AbortController
│   └── practical13.php    # Read-only fictional records for the home-page demo
├── database/
│   ├── schema.sql         # 3NF with PK/FK/ON DELETE CASCADE
│   ├── seed.sql           # ~25 students, ~15 events, ~20 registrations
│   ├── pdo_demo.php       # PDO CRUD demo
│   └── procedures.sql     # Stored procedures
├── docs/
│   ├── requirements.md    # 90+ requirements, 3 roles, tech stack
│   ├── sitemap.md         # Mermaid flowchart
│   ├── api-routes.md      # API envelope + route definitions
│   ├── er-diagram.md      # Mermaid ER diagram
│   ├── PROGRESS.md        # Phase tracking log
│   ├── TEST_CASES.md      # All 15 practical test cases
│   └── DEPLOYMENT.md      # XAMPP setup, smoke test, checklist
├── legacy/                # All old files moved here (18 files)
└── uploads/               # Event poster uploads (if any)
```

## Roles and Access

| Role | URL | Features |
|------|-----|----------|
| **Guest** | `/` | Homepage, about, events, faq, contact, feedback, register, login |
| **Student** | `/student/dashboard.php` | Dashboard, account summary, sample timetable, materials guidance, and upcoming events |
| **Admin** | `/admin/dashboard.php` | Role-protected administration overview and read-only student/event pages |

Register a student account from the portal. Administrator access requires an administrator account provisioned by the deployment owner.

## API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/students.php` | GET | Get the signed-in student's own account |
| `/api/events.php` | GET | List upcoming campus events |
| `/api/async_students.php` | GET | Search student accounts (administrator only) |
| `/api/practical13.php` | GET | Read-only fictional records for the Practical 13 dashboard; dashboard writes are simulated in the browser |

## Design System

### Color Tokens
- `--bg`: Page background (#F4F7FA)
- `--primary`: Electric blue (#0066FF)
- `--secondary`: Secondary accent
- `--success`: Soft mint green
- `--warning`: Amber/orange
- `--error`: Light red
- `--radius`: Border radius (16px)
- `--shadow`: Box shadow

### Typography
- Plus Jakarta Sans (headers)
- JetBrains Mono (numbers, timestamps)

### Components
- Cards: white with var(--border) and var(--radius)
- Buttons: primary (electric blue gradient), outline, ghost, danger
- Badges: success (mint), warning, error, student, admin
- Tables: clean horizontal dividers
- Forms: labeled inputs, validation errors

## Requirements

This project satisfies 90+ requirements from docs/requirements.md including:

- **3 Roles**: Guest/Student/Admin with dynamic navigation menus
- **Design Tokens**: --bg, --primary, --secondary, --success, --warning, --error, --radius, --shadow, --gradient, --bg-network
- **Tech Stack**: PHP 8.0+, MySQL/MariaDB, utf8mb4 charset, No build tools
- **Page Inventory**: 15+ pages covering guest, student, and admin flows
- **Security**: Prepared statements, password_hash/password_verify, output escaping
- **Responsive**: Mobile-first, works at 360px, 768px, 1366px
- **Authentication**: password_hash/password_verify, session_regenerate_id, role redirects, 10-min timeout, remember-me

## Available Scripts

### PHP Lint Check
```bash
php -l *.php
```

### Smoke Test (via curl)
```bash
# Check homepage
curl -s -o /dev/null -w "%{http_code}" http://localhost/studenthub/

# Check API
curl -s http://localhost/studenthub/api/students.php | jq .

# Check all PHP syntax
find . -name "*.php" -exec php -l {} \;
```

## Deployment Checklist

- [ ] XAMPP installed, Apache & MySQL running
- [ ] Database `studenthub_db` created and imported
- [ ] `includes/config.php` has correct credentials
- [ ] `BASE_URL` set correctly for environment
- [ ] All PHP files pass `php -l` lint check
- [ ] Responsiveness tested at 360px, 768px, 1366px
- [ ] Dark mode verified on all pages
- [ ] Accessibility audit (contrast ≥4.5:1, semantic HTML)
- [ ] No exposed secrets or passwords
- [ ] Database backup created
- [ ] API smoke test script run successfully

## Available npm Scripts (If Using Build Tools)

*(Note: This project runs without build tools. If adding React/Tailwind, see AGENTS.md for build configuration.)*

## Git Information

- **Branch**: main
- **Commits**: 15+ practical-based commits
- **Origin**: git@github.com:yesha-12/student-hub-portal.git
- **.gitignore**: config.local.php, uploads/*, data/*, .DS_Store, *.log

## Contact

For support, visit the Contact page or check the FAQ at `/faq.php`.