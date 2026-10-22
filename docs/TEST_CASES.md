# TEST_CASES.md

## StudentHub Portal - Test Cases

### Phase 0: Foundation
- [x] P01: Initial project structure - moved old files to legacy/, created folder structure
- [x] P01: Documentation files - requirements.md, sitemap.md, api-routes.md, er-diagram.md, README.md, PROGRESS.md

### Phase 1: Design System
- [x] P02: Design tokens (tokens.css) with --bg, --primary, --secondary, --success, --warning, --error
- [x] P02: Base styles (base.css) with grid background and radial glow
- [x] P02: Components (components.css) - cards, buttons, badges, tables, forms, modals
- [x] P02: JS utilities - theme.js, nav.js, faq.js, slider.js, ui.js, bg-network.js
- [x] P02: Static pages - index.php, about.php, events.php, faq.php, contact.php, feedback.php

### Phase 2: Registration and API
- [x] P02: Registration form with validation (name, student ID, email, password, department, semester)
- [x] P02: API endpoints - api/students.php (GET list/create, GET by ID)
- [x] P02: API endpoints - api/events.php (GET list/create, GET by ID)

### Phase 3: Database and Authentication
- [x] P03: Database schema (schema.sql) with 3NF design, PK/FK/ON DELETE CASCADE rules
- [x] P03: Seed data (seed.sql) - ~25 students, ~15 events, ~20 registrations
- [x] P03: PDO demo (pdo_demo.php) with CRUD operations
- [x] P03: Stored procedures (procedures.sql) - sp_register_student, sp_login_student, sp_register_event, sp_toggle_student_status
- [x] P04: Authentication system - login.php, logout.php with password_hash/password_verify
- [x] P04: Session management - 10-minute timeout, session_regenerate_id, role-based redirects
- [x] P04: Forbidden page (403 - forbidden.php)

### Phase 4: Admin Features
- [x] P05: Admin students page with soft delete, CSV export, and bulk actions
- [x] P05: Admin events page with poster upload form
- [x] P05: Admin dashboard with stats cards and Chart.js

### Phase 5: API Enhancements
- [x] P06: Async API students endpoint with search, pagination, and API envelope format
- [x] P06: Network inspector JS (net-inspector.js) with AbortController debounce
- [x] P06: FAQ page with search, category filtering, and accordion

### Phase 6: Dashboard and Audit
- [x] P07: Admin dashboard with Chart.js registrations-by-month and stats cards
- [x] P07: FAQ page with live search, category filtering, and question/answer accordion

### Phase 7: Final Integration
- [ ] P08: practicals.php tracker - all 15 practicals verified and working
- [ ] P08: Final integration test - fresh install, login as admin & student
- [ ] P08: TEST_CASES.md completed
- [ ] P08: Final README updated with deployment instructions
- [ ] P08: DEPLOYMENT.md created with XAMPP setup steps

### Phase 8: Deployment
- [ ] P08: XAMPP setup and database import steps documented
- [ ] P08: PHP lint check (php -l) on all PHP files
- [ ] P08: Responsiveness testing at 360px, 768px, 1366px
- [ ] P08: Dark mode testing on all pages
- [ ] P08: Accessibility baseline (contrast ≥4.5:1, semantic landmarks, focus-visible rings)
- [ ] P08: API smoke test script run
- [ ] P08: Final git commit and push to origin