<?php
if (!defined('BASE_URL')) {
    $base = dirname($_SERVER['PHP_SELF']);
    define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
}
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main id="main" style="margin: 20px auto; max-width: 600px; padding: 0 20px;">
  <section style="max-width: 600px; margin: 0 auto; text-align: center;">
    <div style="width: 100px; height: 100px; border: 4px solid var(--border); border-radius: 50%; margin: 0 auto 32px; display: flex; align-items: center; justify-content: center; background: var(--surface);">
      <span style="font-size: 48px; color: var(--muted);">⚠️</span>
    </div>
    <h1 style="color: var(--text); font-weight: 800; border-left: 4px solid var(--warning); padding-left: 12px; margin-bottom: 24px;">Access Forbidden</h1>
    <p style="color: var(--muted); font-size: 1.1rem; margin-bottom: 32px;">You don't have permission to access this page.</p>
    
    <a href="<?php echo BASE_URL; ?>" class="btn btn-primary" style="font-size: 1rem;">Go Home</a>
  </section>
</main>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" style="margin-bottom: 24px; background: #f8fafc; padding: 12px 20px; border-radius: var(--radius);">
  <ol style="display: flex; flex-wrap: wrap; gap: 8px; list-style: none; margin: 0; padding: 0;">
    <li style="font-size: 12px; color: var(--muted);"><a href="<?php echo BASE_URL; ?>" style="color: var(--primary); text-decoration: none;">Home</a></li>
  </ol>
</nav>
</div>

<!-- Footer -->
<?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>
</html>