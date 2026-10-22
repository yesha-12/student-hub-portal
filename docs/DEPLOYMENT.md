# DEPLOYMENT.md

## StudentHub Portal - Deployment Guide

### Prerequisites

- **XAMPP** (version 8.2+) or **WAMP** or **MAMP**
  - Apache HTTP Server
  - PHP 8.0+
- Apache must be able to write to the project-level `data/` directory for accounts and form submissions.

### Local Development Setup

#### 1. Install XAMPP
Download and install XAMPP from https://apachefriends.org  
Start the Apache and MySQL services via XAMPP Control Panel

#### 2. Open the Portal

Visit `http://localhost/studenthub/` and create a student account from the registration page. The portal stores account and form data as JSON files under `data/`; Apache denies direct requests for those files.

#### Optional: Create a MySQL Database

The SQL schema is retained for database practicals and optional integrations:
```bash
mysql -u root -p
# Enter MySQL root password (default: empty)
CREATE DATABASE studenthub_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE studenthub_db;
```

#### Optional: Import Schema and Seed Data
```bash
mysql -u root studenthub_db < database/schema.sql
mysql -u root studenthub_db < database/seed.sql
```

#### 4. Place Project Files
Move the entire `studenthub` folder to your web server root:

- **XAMPP**: `C:\xampp\htdocs\studenthub\`
- **WAMP**: `C:\wamp\www\studenthub\`
- **MAMP**: `/Applications/MAMP/htdocs/studenthub/`

#### Optional: Configure Database Credentials
Edit `includes/config.php`:
```php
$host = 'localhost';
$db   = 'studenthub_db';
$user = 'root';
$pass = '';  // XAMPP default is empty password
```

#### 6. Run the Project

**Option A: PHP Built-in Server**
```bash
cd c:\xampp\htdocs\studenthub
php -S localhost:8000
```
Visit: `http://localhost:8000`

**Option B: Apache Web Server**
Visit: `http://localhost/studenthub/`

### Default Accounts

| Role | Student ID | Email | Password |
|------|-----------|-------|----------|
Register a student account from the portal. Registration assigns the student role and stores a password hash. Administrator access requires an administrator account provisioned by the deployment owner.

### API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/students.php` | GET | Get the signed-in student's own account |
| `/api/events.php` | GET | List upcoming campus events |
| `/api/async_students.php` | GET | Search student accounts (administrator only) |

### XAMPP Configuration Notes

1. **Data Storage**: Ensure Apache can create and write JSON files in the project-level `data/` directory.
2. **Sessions**: Signed-in pages use a `studenthub` PHP session.
3. **Database Practicals**: Enable `extension=pdo_mysql` and import the SQL schema only if using the optional MySQL practicals.
4. **Error Reporting**: Set `display_errors = Off` in production `php.ini`.

### Troubleshooting

| Issue | Solution |
|-------|----------|
| "No such file or directory" error | Ensure you're in the project root for `php -S` |
| Database connection error | MySQL is only required for optional SQL practicals; verify `includes/config.php` if using them |
| 404 on pages | Ensure `.htaccess` is present and `BASE_URL` is correct |
| Login fails | Verify password matches hashed value in DB |
| API returns 500 | Check Apache/PHP error log for details |
| Styles not loading | Verify `BASE_URL` constant is defined correctly |

### Production Checklist

- [ ] All PHP files pass `php -l` lint check
- [ ] Apache can write to the project-level `data/` directory
- [ ] SQL database imported if database practicals are being used
- [ ] `BASE_URL` is set correctly for the production domain
- [ ] SSL certificate installed (HTTPS recommended)
- [ ] Session cookie settings reviewed for production
- [ ] Error logging enabled (error_log in php.ini)
- [ ] No exposed secrets or passwords in PHP files
- [ ] Cross-origin resource sharing (CORS) configured if needed
- [ ] Backup of database created
- [ ] Responsiveness tested at 360px, 768px, 1366px
- [ ] Accessibility audit completed (contrast, landmarks, focus states)
- [ ] Dark mode compatibility verified
- [ ] All 15 practicals verified working

### git Deployment (If Using Version Control)

```bash
# Initialize git (if not already)
git init

# Add all files
git add -

# Create initial commit
git commit -m "P08: Initial StudentHub Portal deployment"

# Add remote (if GitHub)
git remote add origin git@github.com:username/student-hub-portal.git

# Push to main branch
git push -u origin main
```

### Smoke Test Script

Run these tests after deployment:

```bash
# 1. Check PHP lint on all files
find . -name "*.php" -exec php -l {} \; 2>/dev/null | grep -v "No syntax errors"

# 2. Test homepage loads
curl -s -o /dev/null -w "%{http_code}" http://localhost/studenthub/
# Expected: 200

# 3. Test login page
curl -s -o /dev/null -w "%{http_code}" http://localhost/studenthub/login.php
# Expected: 200

# 4. Test API students endpoint
curl -s http://localhost/studenthub/api/students.php | jq .
# Expected: JSON with success status

# 5. Test registration form loads
curl -s -o /dev/null -w "%{http_code}" http://localhost/studenthub/register.php
# Expected: 200

# 6. Test admin dashboard loads (as admin)
curl -s -o /dev/null -w "%{http_code}" http://localhost/studenthub/admin/dashboard.php
# Expected: 200

# 7. Verify all pages have proper DOCTYPE and html structure
php -l *.php
```