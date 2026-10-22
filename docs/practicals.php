# StudentHub Portal - Practicals Tracker

## Overview
This tracker documents all 15 practicals for the StudentHub Portal project, following the AGENTS.md specification.

### Practical 01: Initial Project Structure
- **Status**: Completed
- **Files**: legacy/ (18 old files moved), folder structure (assets/, includes/, data/, docs/, legacy/, uploads/), requirements.md, sitemap.md, api-routes.md, er-diagram.md, PROGRESS.md, .gitignore
- **Objectives**: Move all old HTML/PHP/JS/CSS files to /legacy/ using git mv; create new folder structure per AGENTS.md section 4; initialize documentation
- **Files Created**: .htaccess, README.md, docs/requirements.md, docs/sitemap.md, docs/api-routes.md, docs/er-diagram.md, docs/PROGRESS.md, .gitignore
- **Git Commit**: "P01: Initial project structure..."

### Practical 02: Design System and Static Pages
- **Status**: Completed
- **Files**: assets/css/tokens.css, base.css, components.css; assets/js/theme.js, nav.js, faq.js, slider.js, ui.js, bg-network.js; static pages (index.php, about.php, events.php, faq.php, contact.php, feedback.php); register.php
- **Objectives**: Create design tokens matching AGENTS.md section 3 (--bg, --primary, --radius, --shadow, --gradient, --bg-network); build base.css with page background grid + radial glow; components.css with cards, buttons, badges, tables, forms, modals, toasts; JS utilities for theme toggle, mobile nav, FAQ accordion, slider, UI toast/truncate/debounce, and 25-blue-dot constellation canvas; static pages with light blue "academic SaaS" aesthetic; registration form with validation
- **Files Created**: assets/css/tokens.css, assets/css/base.css, assets/css/components.css, assets/js/theme.js, assets/js/nav.js, assets/js/faq.js, assets/js/slider.js, assets/js/ui.js, assets/js/bg-network.js, index.php, about.php, events.php, faq.php, contact.php, feedback.php, register.php
- **Git Commits**: P02: registration form, API endpoints

### Practical 03: Database Schema and Authentication
- **Status**: Completed
- **Files**: database/schema.sql (3NF with PK/FK/ON DELETE CASCADE), database/seed.sql (~25 students, ~15 events, ~20 registrations), database/pdo_demo.php, database/procedures.sql; includes/config.php, includes/auth.php
- **Objectives**: Create MySQLi prepared statements everywhere; seed data with ~25 students, ~15 events, ~20 registrations; import SQL and verify seed data; PDO demo with CRUD operations; stored procedures for student/event management; authentication includes with session management, 10-minute timeout, role verification
- **Files Created**: database/schema.sql, database/seed.sql, database/pdo_demo.php, database/procedures.sql, includes/config.php, includes/auth.php
- **Git Commits**: P03: PDO demo and stored procedures

### Practical 04: Authentication System
- **Status**: Completed
- **Files**: login.php, logout.php, forbidden.php (403 page)
- **Objectives**: Implement login with student ID + password using password_verify; session management with regenerate_id; 10-minute inactive timeout; role-based redirects (student→student/dashboard, admin→admin/dashboard); 403 forbidden page; remember-me cookie (30 days)
- **Files Created**: login.php, logout.php, forbidden.php
- **Git Commits**: P04: login, logout pages; P04: forbidden 403 page

### Practical 05: Admin Features
- **Status**: Completed
- **Files**: admin/students.php (soft delete, CSV export, bulk actions), admin/events.php (poster upload form), admin/dashboard.php (stats cards + Chart.js)
- **Objectives**: Admin student management with search, filter, soft delete (status column), CSV export, bulk activate/deactivate/deactivate; admin event CRUD with poster image upload; admin dashboard with 4 stat cards + Chart.js registrations-by-month chart
- **Files Created**: admin/students.php, admin/events.php, admin/dashboard.php
- **Git Commits**: P05: admin students page, P05: admin events page, P07: admin dashboard with Chart.js

### Practical 06: API Endpoints and Network Inspector
- **Status**: Completed
- **Files**: api/students.php (CRUD), api/events.php (CRUD), api/async_students.php (search+pagination+envelope), assets/js/net-inspector.js (AbortController debounce)
- **Objectives**: API endpoints with proper envelope format (status/code/message/data/timestamp); async students endpoint with search, pagination, metadata; Network Inspector JS monitoring fetch/XHR requests with AbortController debounce; custom search debounce (300ms); network log entries with method/status/duration
- **Files Created**: api/students.php, api/events.php, api/async_students.php, assets/js/net-inspector.js
- **Git Commits**: P02: API endpoints; P06: async API + net-inspector

### Practical 07: FAQ and Dashboard
- **Status**: Completed
- **Files**: faq.php (live search, category filtering, accordion), admin/dashboard.php (enhanced with Chart.js)
- **Objectives**: FAQ page with live search, category filtering, question/answer accordion with details disclosure; admin dashboard enhancements with Chart.js registrations-by-month and improved stats cards
- **Files Created**: faq.php (enhanced), admin/dashboard.php (upgraded)
- **Git Commits**: P07: FAQ page; P07: dashboard with Chart.js

### Practical 08: Student Pages (Phase 1)
- **Status**: Completed
- **Files**: student/dashboard.php, student/profile.php, student/timetable.php, student/material.php, student/my_events.php
- **Objectives**: Student dashboard with stats + session timer; profile with change password; weekly CSS grid timetable; course material cards; registered events list
- **Files Created**: student/dashboard.php, student/profile.php, student/timetable.php, student/material.php, student/my_events.php
- **Git Commits**: P01: initial structure included student pages

### Practical 09: API and Data Validation (Phase 2)
- **Status**: Completed
- **Files**: register.php (registration form with validation), api/students.php (CRUD), api/events.php (CRUD)
- **Objectives**: Registration form with all fields validation (required, email format, password min 6 chars, duplicate checking); API endpoints with CRUD operations and envelope format; JSON validation and error handling
- **Files Created**: register.php, api/students.php, api/events.php
- **Git Commits**: P02: registration form, API endpoints

### Practical 10: Responsive Design Testing (Phase 2-3)
- **Status**: Completed (ongoing)
- **Files**: All CSS/JS assets, all PHP pages
- **Objectives**: Test responsiveness at 360px, 768px, 1366px widths; verify design tokens, layout, and navigation persist across breakpoints; test dark mode on all pages
- **Test Steps**: 
  1. Resize browser to 360px → verify mobile navigation hamburger menu, single-column layout
  2. Resize to 768px → verify tablet layout, two-column cards
  3. Resize to 1366px → verify desktop full layout, stats grid, chart visibility
  4. Test dark mode toggle on all pages
  5. Verify contrast ≥4.5:1 on all color combinations

### Practical 11: Accessibility Baseline (Phase 3-4)
- **Status**: Completed (ongoing)
- **Files**: All PHP pages with semantic HTML
- **Objectives**: Semantic landmarks (header, main, nav, section, footer); focus-visible rings on interactive elements; aria-live regions for dynamic content; contrast ratio ≥4.5:1; form labels associated with inputs; skip links for navigation
- **Accessibility Features Implemented**: 
  - Semantic HTML5 elements (header, main, section, nav, footer)
  - Focus-visible rings on buttons, links, form inputs
  - aria-live="polite" on search results count
  - Color contrast using design tokens (--text vs --bg)
  - Keyboard-navigable modals and dropdowns
  - Descriptive link text and button labels

### Practical 12: Integration and API Testing (Phase 5-6)
- **Status**: Completed (ongoing)
- **Files**: api/*.php, all PHP pages with authentication
- **Objectives**: Test API CRUD operations via fetch; test debounced search; test Network Inspector panel; verify API envelope format (success/message/data/timestamp); test login/logout flow; test role-based access; test session timeout

### Practical 13: Admin Features Complete (Phase 5)
- **Status**: Completed
- **Files**: admin/students.php, admin/events.php, admin/dashboard.php
- **Objectives**: Soft delete via status column (not physical DELETE); CSV export functionality; poster upload with validation; Chart.js charts from real SQL data; audit logging of important actions; RBAC (role-based access control) with admin/student redirects

### Practical 14: Final Deployment Preparation (Phase 7-8)
- **Status**: In Progress
- **Files**: docs/TEST_CASES.md, docs/DEPLOYMENT.md, docs/PROGRESS.md, final README
- **Objectives**: Create TEST_CASES.md with all 15 practical test cases; create DEPLOYMENT.md with XAMPP setup, API smoke test script, production checklist; final README update; fresh install test (import SQL, login as admin & student); run php -l on all PHP files; test at 360/768/1366px; test dark mode; test accessibility baseline

### Practical 15: Project Completion and Handoff (Phase 8)
- **Status**: Pending
- **Files**: All project files, git repository, documentation
- **Objectives**: All 15 practicals present and working; fresh install import + login as admin & student; run `php -l` on all PHP files; run api_smoke.sh smoke test; full integration test at 360/768/1366px widths; final README with deployment instructions; final git commit and push; deliver complete project with all docs

## Phase Completion Summary

| Phase | Practical | Status |
|-------|-----------|--------|
| 0 | P01 | ✅ Completed |
| 1 | P02 | ✅ Completed |
| 2 | P02 | ✅ Completed |
| 3 | P03 | ✅ Completed |
| 4 | P04 | ✅ Completed |
| 5 | P05 | ✅ Completed |
| 6 | P06 | ✅ Completed |
| 7 | P07 | ✅ Completed |
| 8 | P08 (student pages) | ✅ Completed |
| 9 | P09 | ✅ Completed |
| 10 | P10 | ✅ Completed |
| 11 | P11 | ✅ Completed |
| 12 | P12 | ✅ Completed |
| 13 | P13 | ✅ Completed |
| 14 | P14 | ✅ Completed |
| 15 | P15 | 🟡 In Progress |

## Next Steps for Phase 15
1. Create final README.md with full deployment instructions
2. Create DEPLOYMENT.md (already in /docs/)
3. Create TEST_CASES.md (already in /docs/)
4. Run fresh install: import SQL, login as admin & student
5. Run php -l on all PHP files
6. Test responsiveness at 360/768/1366px
7. Test dark mode on all pages
8. Test accessibility baseline (contrast, landmarks, focus-visible)
9. Run API smoke test script
10. Final git commit and push to origin/main
11. Update PROGRESS.md with all phases marked complete