# StudentHub

## Run locally with XAMPP

1. Start MySQL in the XAMPP Control Panel.
2. Open phpMyAdmin and import `database.sql` (or run it with the MySQL client). The script creates the `studenthub` database, role-aware academic tables, sample courses/enrollments, and notices.
3. Put this project folder under `C:\xampp\htdocs\studenthub` and start Apache, then open `http://localhost/studenthub/`.
4. If the MySQL account is not XAMPP's default `root` account with an empty password, set `STUDENTHUB_DB_HOST`, `STUDENTHUB_DB_USER`, `STUDENTHUB_DB_PASSWORD`, and `STUDENTHUB_DB_NAME` in the PHP server environment. Do not commit production credentials.

The PHP server and MySQL must both be running; opening the HTML files directly with `file://` will not run the PHP-backed workflows.

## Demo accounts

- Administrator: username `admin`, password `Admin@123`
- Faculty: username `faculty`, password `Faculty@123`
- Student: username `learner`, password `Student@123`

Change or remove these development accounts before deploying the application publicly.

## Database-backed workflows

- Student registration checks unique student ID, username, and email, hashes passwords, and creates a session.
- Login accepts username, student ID, or email. Sessions regenerate on authentication, use HTTP-only/SameSite cookies, expire after 30 minutes of inactivity, and require CSRF tokens for mutations.
- Admin users can manage students, faculty, departments, courses, faculty-course assignments, enrollments, assignments, attendance, and notices.
- Faculty users are limited to their assigned courses and can create assignments, view enrolled students, and manage attendance for those courses.
- Students can view only their enrolled courses, their own attendance and assignments, submit assignment text, update their profile, and register once per event.
- Attendance percentages, dashboard counts, reports, and assignment states are calculated from database records.
- Important administrative and academic changes are recorded in the activity log.
- Contact submissions and notices are stored in MySQL.

Database connection settings are read in `db.php`; the default values are for a local XAMPP installation only.

For PHP's built-in development server, run `php -S 127.0.0.1:8000 router.php` from the project folder. The router applies the same server-side role checks to protected `.html` page URLs as the XAMPP Apache rewrite rules.
