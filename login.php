<?php
if (!defined('BASE_URL')) {
    $base = dirname($_SERVER['PHP_SELF']);
    define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
}
?>
<?php
// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = trim($_POST['student_id'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = !empty($_POST['remember_me']);
    
    require_once __DIR__ . '/includes/config.php';
    
    global $pdo;
    
    // Look up student by ID
    $stmt = $pdo->prepare('SELECT student_id, name, email, password, role FROM students WHERE student_id = ?');
    $stmt->execute([$studentId]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_logged_in'] = true;
        $_SESSION['student_id'] = $user['student_id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        
        // Regenerate session ID to prevent fixation
        session_regenerate_id(true);
        
        // Remember me cookie (30 days)
        if ($remember) {
            setcookie('studenthub_' . $user['student_id'], $user['password'], time() + (30 * 24 * 60 * 60), '/');
            // Note: In production, store a random token, not the password
        }
        
        // Determine redirect based on role
        if ($user['role'] === 'admin') {
            header('Location: ' . BASE_URL . 'admin/dashboard.php');
        } else {
            header('Location: ' . BASE_URL . 'student/dashboard.php');
        }
        exit;
    } else {
        $login_error = 'Invalid student ID or password';
    }
}
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main id="main" style="margin: 20px auto; max-width: 400px; padding: 0 20px;">
  <section style="max-width: 400px; margin: 0 auto;">
    <h1 style="color: var(--text); font-weight: 800; border-left: 4px solid var(--primary); padding-left: 12px; margin-bottom: 32px;">
      StudentHub Login
    </h1>
    
    <p style="color: var(--muted); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 24px;">
      Sign in to your account
    </p>
    
    <?php if (isset($login_error)): ?>
    <div style="background: var(--surface-error); border: 1px solid var(--border-error); border-radius: var(--radius); padding: 16px; margin-bottom: 24px; color: var(--error);">
      <strong>Login failed:</strong> <?php echo htmlspecialchars($login_error); ?>
    </div>
    <?php endif; ?>
    
    <form style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 32px; box-shadow: var(--shadow);">
      <div style="display: grid; gap: 24px;">
        <div>
          <label style="display: block; color: var(--muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Student ID</label>
          <input type="text" name="student_id" class="form-input" placeholder="25CS032" required
                 style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 14px;">
        </div>
        <div>
          <label style="display: block; color: var(--muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Password</label>
          <input type="password" name="password" class="form-input" placeholder="••••••" required
                 style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 14px;">
        </div>
        <div>
          <div style="margin-bottom: 12px;">
            <input type="checkbox" id="remember_me" name="remember_me" class="form-checkbox"
                   style="margin-right: 8px; width: 18px; height: 18px;" checked>
            <label for="remember_me" style="color: var(--muted); font-size: 0.875rem; cursor: picker;">Remember me for 30 days</label>
          </div>
          <a href="<?php echo BASE_URL; ?>/forbidden.php" style="color: var(--muted); font-size: 0.875rem; text-decoration: none; float: right;">Forgot password?</a>
        </div>
      </div>
      <div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid var(--border);">
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px 16px; font-size: 14px; font-weight: 700;">Sign In</button>
      </div>
    </form>
    
    <p style="color: var(--muted); margin-top: 32px; font-size: 0.9rem;">
      New to StudentHub? <a href="<?php echo BASE_URL; ?>/register.php" style="color: var(--primary); text-decoration: none; font-weight: 600;">Create account</a>
    </p>
  </section>
</main>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" style="margin-bottom: 24px; background: #f8fafc; padding: 12px 20px; border-radius: var(--radius);">
  <ol style="display: flex; flex-wrap: wrap; gap: 8px; list-style: none; margin: 0; padding: 0;">
    <li style="font-size: 12px; color: var(--muted);"><a href="<?php echo BASE_URL; ?>" style="color: var(--primary); text-decoration: none;">Home</a></li>
    <li style="font-size: 12px; color: var(--text);">Login</li>
  </ol>
</nav>
</div>

<!-- Footer -->
<?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>
</html>