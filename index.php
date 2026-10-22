<?php
if (!defined('BASE_URL')) {
    $base = dirname($_SERVER['PHP_SELF']);
    define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
}

$pageStatusCode = http_response_code();
if ($pageStatusCode === false) {
    $pageStatusCode = 200;
}
$pageStatusLabel = $pageStatusCode >= 200 && $pageStatusCode < 400 ? 'OK' : 'Error';
$escape = static function (string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f8fafc">
  <meta name="description" content="Campusly brings campus events, student resources, and support together in one helpful student hub.">
  <title>Campusly | Your student hub</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      color-scheme: light;
      --blue: #0066ff;
      --navy: #0f172a;
      --muted: #64748b;
      --faint: #94a3b8;
      --border: #e2e8f0;
      --page: #f8fafc;
      --green: #10b981;
      font-family: 'Plus Jakarta Sans', Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      color: var(--navy);
      background: var(--page);
      font-synthesis: none;
      text-rendering: optimizeLegibility;
    }
    * { box-sizing: border-box; }
    body {
      min-width: 320px;
      min-height: 100vh;
      margin: 0;
      background-color: var(--page);
      background-image:
        linear-gradient(to right, rgba(226, 232, 240, .5) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(226, 232, 240, .5) 1px, transparent 1px);
      background-size: 24px 24px;
    }
    a { color: inherit; }
    .topbar { position: sticky; z-index: 2; top: 0; border-bottom: 1px solid rgba(226, 232, 240, .88); background: rgba(255, 255, 255, .9); backdrop-filter: blur(14px); }
    .topbar-inner, .page-shell { width: min(1160px, calc(100% - 48px)); margin-inline: auto; }
    .topbar-inner { min-height: 76px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
    .brand-group, .brand, .nav-links, .status-pill, .brand-mark, .hero-icon, .feature-icon { display: flex; align-items: center; }
    .brand-group { gap: 14px; }
    .brand { gap: 10px; text-decoration: none; }
    .brand-mark { width: 36px; height: 36px; justify-content: center; border-radius: 12px; color: #fff; background: var(--blue); box-shadow: 0 5px 12px rgba(0, 102, 255, .2); }
    .brand-mark svg { width: 21px; height: 21px; }
    .brand-name { font-size: 19px; font-weight: 800; letter-spacing: -.7px; }
    .product-tag { padding: 7px 11px; border: 1px solid var(--border); border-radius: 999px; color: #475569; background: #f8fafc; font-size: 11px; font-weight: 600; white-space: nowrap; }
    .topbar-right { display: flex; align-items: center; justify-content: flex-end; gap: 24px; }
    .nav-links { gap: 21px; }
    .nav-links a { color: #475569; font-size: 13px; font-weight: 600; text-decoration: none; transition: color .18s ease; }
    .nav-links a:hover, .nav-links a[aria-current="page"] { color: var(--blue); }
    .status-pill { gap: 7px; padding: 7px 10px; border: 1px solid rgba(167, 243, 208, .8); border-radius: 999px; color: #047857; background: #ecfdf5; font-size: 11px; font-weight: 700; white-space: nowrap; }
    .status-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green); box-shadow: 0 0 0 3px rgba(16, 185, 129, .12); }
    .page-shell { padding: 28px 0 55px; }
    .hero { position: relative; display: grid; grid-template-columns: minmax(0, 1fr) 330px; gap: 36px; align-items: center; overflow: hidden; padding: 47px 48px; border: 1px solid #dbeafe; border-radius: 22px; background: linear-gradient(115deg, #fff 25%, #eff6ff 100%); box-shadow: 0 5px 20px rgba(15, 23, 42, .045); }
    .hero:after { position: absolute; top: -105px; right: 165px; width: 260px; height: 260px; border: 1px solid rgba(59, 130, 246, .12); border-radius: 50%; content: ""; box-shadow: 0 0 0 24px rgba(59, 130, 246, .035), 0 0 0 50px rgba(59, 130, 246, .025); pointer-events: none; }
    .hero-copy, .hero-card { position: relative; z-index: 1; }
    .eyebrow { margin: 0 0 10px; color: var(--blue); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; }
    h1 { max-width: 610px; margin: 0; font-size: clamp(32px, 5vw, 48px); line-height: 1.12; letter-spacing: -2px; }
    .hero-copy > p:not(.eyebrow) { max-width: 560px; margin: 15px 0 0; color: var(--muted); font-size: 14px; line-height: 1.8; }
    .hero-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 24px; }
    .button { min-height: 43px; display: inline-flex; align-items: center; justify-content: center; gap: 9px; padding: 0 16px; border: 1px solid transparent; border-radius: 11px; font-size: 12px; font-weight: 700; text-decoration: none; transition: background .18s ease, transform .18s ease; }
    .button svg { width: 15px; height: 15px; }
    .button-primary { color: #fff; background: var(--blue); box-shadow: 0 4px 10px rgba(0, 102, 255, .16); }
    .button-primary:hover { transform: translateY(-1px); background: #0052cc; }
    .button-secondary { border-color: var(--border); color: #334155; background: #fff; }
    .button-secondary:hover { background: #f8fafc; }
    .hero-card { padding: 20px; border: 1px solid rgba(226, 232, 240, .95); border-radius: 17px; background: rgba(255, 255, 255, .93); box-shadow: 0 12px 28px rgba(15, 23, 42, .07); }
    .hero-card-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
    .hero-card-head strong { font-size: 13px; }
    .live-pill { display: inline-flex; align-items: center; gap: 7px; padding: 6px 9px; border: 1px solid rgba(167, 243, 208, .8); border-radius: 999px; color: #047857; background: #ecfdf5; font-size: 9px; font-weight: 700; }
    .live-pill .status-dot { width: 6px; height: 6px; box-shadow: none; }
    .hub-item { display: flex; align-items: center; gap: 12px; padding: 14px 0 0; }
    .hub-item + .hub-item { margin-top: 13px; padding-top: 13px; border-top: 1px solid #f1f5f9; }
    .hub-item-icon { width: 36px; height: 36px; flex: 0 0 36px; display: grid; place-items: center; border-radius: 11px; color: #2563eb; background: #eff6ff; }
    .hub-item-icon svg { width: 18px; height: 18px; }
    .hub-item-copy { min-width: 0; }
    .hub-item-copy strong { display: block; font-size: 11px; }
    .hub-item-copy span { display: block; margin-top: 4px; color: var(--muted); font-size: 10px; }
    .hub-item-arrow { margin-left: auto; color: #94a3b8; font-size: 17px; }
    .section-heading { display: flex; align-items: end; justify-content: space-between; gap: 18px; margin: 37px 0 17px; }
    .section-heading h2 { margin: 0; font-size: 19px; letter-spacing: -.55px; }
    .section-heading p { margin: 6px 0 0; color: var(--muted); font-size: 11px; line-height: 1.6; }
    .section-link { color: var(--blue); font-size: 11px; font-weight: 700; text-decoration: none; white-space: nowrap; }
    .section-link:hover { color: #0052cc; }
    .feature-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }
    .feature-card { min-height: 176px; padding: 19px; border: 1px solid var(--border); border-radius: 16px; background: #fff; box-shadow: 0 2px 5px rgba(15, 23, 42, .03); text-decoration: none; transition: box-shadow .18s ease, transform .18s ease, border-color .18s ease; }
    .feature-card:hover { transform: translateY(-2px); border-color: #bfdbfe; box-shadow: 0 9px 22px rgba(15, 23, 42, .07); }
    .feature-icon { width: 38px; height: 38px; justify-content: center; border-radius: 12px; color: #2563eb; background: #eff6ff; }
    .feature-icon svg { width: 19px; height: 19px; }
    .feature-card:nth-child(2) .feature-icon { color: #7e22ce; background: #faf5ff; }
    .feature-card:nth-child(3) .feature-icon { color: #0e7490; background: #ecfeff; }
    .feature-card h3 { margin: 15px 0 6px; font-size: 13px; letter-spacing: -.2px; }
    .feature-card p { margin: 0; color: var(--muted); font-size: 10px; line-height: 1.7; }
    .feature-cta { display: inline-flex; align-items: center; gap: 5px; margin-top: 12px; color: var(--blue); font-size: 10px; font-weight: 700; }
    .feature-cta span { font-size: 14px; transition: transform .18s ease; }
    .feature-card:hover .feature-cta span { transform: translateX(3px); }
    .bottom-cta { display: flex; align-items: center; justify-content: space-between; gap: 22px; margin-top: 19px; padding: 20px 22px; border: 1px solid var(--border); border-radius: 16px; background: rgba(255, 255, 255, .92); }
    .bottom-cta h2 { margin: 0; font-size: 13px; }
    .bottom-cta p { margin: 5px 0 0; color: var(--muted); font-size: 10px; line-height: 1.6; }
    .bottom-cta .button { flex: 0 0 auto; min-height: 38px; font-size: 10px; }
    .page-footer { display: flex; justify-content: space-between; gap: 14px; padding-top: 23px; color: var(--faint); font-size: 10px; }
    .page-footer a { color: var(--muted); text-decoration: none; }
    .page-footer a:hover { color: var(--blue); }
    @media (max-width: 850px) {
      .hero { grid-template-columns: minmax(0, 1fr) 290px; gap: 22px; padding: 36px 30px; }
      .topbar-right { gap: 15px; }
      .nav-links { gap: 14px; }
      .product-tag { display: none; }
    }
    @media (max-width: 680px) {
      .topbar-inner, .page-shell { width: min(100% - 32px, 560px); }
      .topbar-inner { min-height: 66px; }
      .nav-links { display: none; }
      .topbar-right { gap: 0; }
      .page-shell { padding-top: 18px; }
      .hero { grid-template-columns: 1fr; gap: 24px; padding: 29px 22px; }
      .hero:after { right: -70px; }
      h1 { font-size: clamp(31px, 9vw, 42px); }
      .hero-card { max-width: 450px; }
      .feature-grid { grid-template-columns: 1fr; }
      .feature-card { min-height: 0; }
      .section-heading { align-items: start; }
    }
    @media (max-width: 440px) {
      .topbar-inner, .page-shell { width: calc(100% - 28px); }
      .status-pill { padding: 7px 8px; font-size: 9px; }
      .hero { padding: 25px 18px; }
      .hero-actions .button { flex: 1 1 100%; }
      .section-heading { flex-direction: column; }
      .bottom-cta { align-items: stretch; flex-direction: column; }
      .bottom-cta .button { width: 100%; }
      .page-footer { flex-direction: column; }
    }
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
    }
  </style>
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <div class="brand-group">
        <a class="brand" href="<?php echo $escape(BASE_URL); ?>" aria-label="Campusly home">
          <span class="brand-mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M4 7.5 12 4l8 3.5v9L12 20l-8-3.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 3.4 7.5-3.4M12 11.5V20" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
          </span>
          <span class="brand-name">Campusly</span>
        </a>
        <span class="product-tag">Practical Engine / Student Hub</span>
      </div>
      <div class="topbar-right">
        <nav class="nav-links" aria-label="Main navigation">
          <a href="<?php echo $escape(BASE_URL . 'events.php'); ?>">Events</a>
          <a href="<?php echo $escape(BASE_URL . 'about.php'); ?>">About</a>
          <a href="<?php echo $escape(BASE_URL . 'faq.php'); ?>">Help center</a>
          <a href="<?php echo $escape(BASE_URL . 'contact.php'); ?>">Contact</a>
        </nav>
        <span class="status-pill"><span class="status-dot" aria-hidden="true"></span>JSON API: <?php echo (int) $pageStatusCode; ?> <?php echo $escape($pageStatusLabel); ?></span>
      </div>
    </div>
  </header>

  <main class="page-shell">
    <section class="hero" aria-labelledby="welcome-title">
      <div class="hero-copy">
        <p class="eyebrow">Your campus, all in one place</p>
        <h1 id="welcome-title">Make the most of your student life.</h1>
        <p>Discover what’s happening, find the resources you need, and stay connected to your campus community with Campusly.</p>
        <div class="hero-actions">
          <a class="button button-primary" href="<?php echo $escape(BASE_URL . 'events.php'); ?>">
            Explore campus events
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a class="button button-secondary" href="<?php echo $escape(BASE_URL . 'login.php'); ?>">Sign in to your hub</a>
        </div>
      </div>
      <div class="hero-card" aria-label="Campusly features">
        <div class="hero-card-head">
          <strong>Your hub at a glance</strong>
          <span class="live-pill"><span class="status-dot" aria-hidden="true"></span>Ready to explore</span>
        </div>
        <div class="hub-item">
          <span class="hub-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="15" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 3v4m8-4v4M4 10h16m-12 4h3m-3 3h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
          <span class="hub-item-copy"><strong>Campus events</strong><span>Find your next campus moment</span></span><span class="hub-item-arrow" aria-hidden="true">›</span>
        </div>
        <div class="hub-item">
          <span class="hub-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21V5.5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20M8 7h8m-8 4h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
          <span class="hub-item-copy"><strong>Student resources</strong><span>Materials and portal information</span></span><span class="hub-item-arrow" aria-hidden="true">›</span>
        </div>
        <div class="hub-item">
          <span class="hub-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v8a2.5 2.5 0 0 1-2.5 2.5h-6l-4.5 3v-3h-.5A2.5 2.5 0 0 1 4 14.5v-8Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8 9h8m-8 3.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
          <span class="hub-item-copy"><strong>Campus support</strong><span>Get help when you need it</span></span><span class="hub-item-arrow" aria-hidden="true">›</span>
        </div>
      </div>
    </section>

    <section aria-labelledby="discover-title">
      <div class="section-heading">
        <div>
          <h2 id="discover-title">Explore Campusly</h2>
          <p>Everything you need to stay in the loop and make campus feel like yours.</p>
        </div>
        <a class="section-link" href="<?php echo $escape(BASE_URL . 'about.php'); ?>">About the portal <span aria-hidden="true">→</span></a>
      </div>
      <div class="feature-grid">
        <a class="feature-card" href="<?php echo $escape(BASE_URL . 'events.php'); ?>">
          <span class="feature-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="15" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 3v4m8-4v4M4 10h16m-12 4h3m-3 3h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
          <h3>Find campus events</h3>
          <p>Browse activities and discover the people, ideas, and experiences happening around campus.</p>
          <span class="feature-cta">Explore events <span aria-hidden="true">→</span></span>
        </a>
        <a class="feature-card" href="<?php echo $escape(BASE_URL . 'faq.php'); ?>">
          <span class="feature-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M9.1 9a3 3 0 1 1 4.7 2.45c-1 .68-1.8 1.25-1.8 2.8M12 18h.01" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
          <h3>Get quick answers</h3>
          <p>Check the help center for answers about your account, events, courses, and portal access.</p>
          <span class="feature-cta">Visit help center <span aria-hidden="true">→</span></span>
        </a>
        <a class="feature-card" href="<?php echo $escape(BASE_URL . 'contact.php'); ?>">
          <span class="feature-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v8a2.5 2.5 0 0 1-2.5 2.5h-6l-4.5 3v-3h-.5A2.5 2.5 0 0 1 4 14.5v-8Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8 9h8m-8 3.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
          <h3>Talk to our team</h3>
          <p>Reach out to the Campusly team when you need a hand with the student hub.</p>
          <span class="feature-cta">Contact support <span aria-hidden="true">→</span></span>
        </a>
      </div>
    </section>

    <section class="bottom-cta" aria-labelledby="bottom-cta-title">
      <div>
        <h2 id="bottom-cta-title">New to Campusly?</h2>
        <p>Create a student account to access your personal hub and campus resources.</p>
      </div>
      <a class="button button-primary" href="<?php echo $escape(BASE_URL . 'register.php'); ?>">Create your account</a>
    </section>

    <footer class="page-footer">
      <span>© <?php echo date('Y'); ?> Campusly · Made for campus life.</span>
      <span><a href="<?php echo $escape(BASE_URL . 'contact.php'); ?>">Contact</a> &nbsp;·&nbsp; <a href="<?php echo $escape(BASE_URL . 'feedback.php'); ?>">Feedback</a></span>
    </footer>
  </main>
</body>
</html>
