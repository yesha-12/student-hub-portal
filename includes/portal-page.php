<?php
declare(strict_types=1);

$pageTitle = $pageTitle ?? 'Campusly';
$pageSubtitle = $pageSubtitle ?? '';
$pageEyebrow = $pageEyebrow ?? 'Campusly student hub';
$pageStats = $pageStats ?? [];
$pageCards = $pageCards ?? [];
$pageEvents = $pageEvents ?? [];
$pageNotice = $pageNotice ?? '';
$pagePrimaryAction = $pagePrimaryAction ?? ['href' => 'events.php', 'label' => 'Explore events', 'dialog' => false];
$escape = static function (string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};
$pageStatusCode = http_response_code();
if ($pageStatusCode === false) {
    $pageStatusCode = 200;
}
$pageStatusLabel = $pageStatusCode >= 200 && $pageStatusCode < 400 ? 'OK' : 'Error';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f8fafc">
  <title><?php echo $escape($pageTitle); ?> | Campusly</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root{color-scheme:light;--blue:#0066ff;--navy:#0f172a;--muted:#64748b;--faint:#94a3b8;--border:#e2e8f0;--page:#f8fafc;--green:#10b981;font-family:'Plus Jakarta Sans',Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;color:var(--navy);background:var(--page);font-synthesis:none;text-rendering:optimizeLegibility}
    *{box-sizing:border-box}body{min-width:320px;min-height:100vh;margin:0;background-color:var(--page);background-image:linear-gradient(to right,rgba(226,232,240,.5) 1px,transparent 1px),linear-gradient(to bottom,rgba(226,232,240,.5) 1px,transparent 1px);background-size:24px 24px}a{color:inherit}
    .topbar{position:sticky;z-index:3;top:0;border-bottom:1px solid rgba(226,232,240,.88);background:rgba(255,255,255,.92);backdrop-filter:blur(14px)}.topbar-inner,.shell{width:min(1080px,calc(100% - 48px));margin-inline:auto}.topbar-inner{min-height:70px;display:flex;align-items:center;justify-content:space-between;gap:20px}
    .brand{display:flex;align-items:center;gap:10px;text-decoration:none}.brand-mark{width:35px;height:35px;display:grid;place-items:center;border-radius:11px;color:#fff;background:var(--blue)}.brand-mark svg{width:20px;height:20px}.brand-name{font-size:18px;font-weight:800;letter-spacing:-.6px}.topbar-right{display:flex;align-items:center;gap:19px}.nav{display:flex;align-items:center;gap:17px}.nav a{color:#475569;font-size:11px;font-weight:600;text-decoration:none}.nav a:hover{color:var(--blue)}.status{display:inline-flex;align-items:center;gap:7px;padding:7px 9px;border:1px solid #a7f3d0;border-radius:999px;color:#047857;background:#ecfdf5;font-size:9px;font-weight:700;white-space:nowrap}.dot{width:6px;height:6px;border-radius:50%;background:var(--green)}
    .shell{padding:28px 0 60px}.crumbs{display:flex;gap:8px;margin:0 0 23px;color:var(--faint);font-size:11px}.crumbs a{color:var(--muted);text-decoration:none}.crumbs a:hover{color:var(--blue)}.crumbs .sep{color:#cbd5e1}
    .hero{display:flex;align-items:flex-start;justify-content:space-between;gap:28px;margin-bottom:22px}.hero-copy{display:flex;gap:14px;max-width:650px}.hero-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border:1px solid #dbeafe;border-radius:14px;color:var(--blue);background:#eff6ff}.hero-icon svg{width:22px;height:22px}.eyebrow{margin:0 0 6px;color:var(--blue);font-size:9px;font-weight:800;letter-spacing:1.4px;text-transform:uppercase}h1{margin:0;font-size:clamp(24px,3vw,31px);line-height:1.2;letter-spacing:-1px}.subtitle{max-width:600px;margin:8px 0 0;color:var(--muted);font-size:12px;line-height:1.8}
    .stats{display:flex;gap:8px}.stat{min-width:85px;padding:11px 12px;border:1px solid var(--border);border-radius:14px;background:#fff}.stat strong{display:block;font-size:18px;letter-spacing:-.6px}.stat span{display:block;margin-top:3px;color:var(--muted);font-size:9px;font-weight:600;white-space:nowrap}
    .panel{padding:21px;border:1px solid var(--border);border-radius:17px;background:#fff;box-shadow:0 2px 6px rgba(15,23,42,.035)}.panel + .panel{margin-top:14px}.panel h2{margin:0;font-size:15px;letter-spacing:-.3px}.panel-intro{margin:6px 0 15px;color:var(--muted);font-size:11px;line-height:1.7}
    .card-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:13px}.info-card{min-height:145px;padding:17px;border:1px solid var(--border);border-radius:15px;background:#fff;box-shadow:0 1px 3px rgba(15,23,42,.025);text-decoration:none;transition:transform .18s ease,border-color .18s ease,box-shadow .18s ease}.info-card:hover{transform:translateY(-2px);border-color:#bfdbfe;box-shadow:0 7px 18px rgba(15,23,42,.07)}.card-icon{width:34px;height:34px;display:grid;place-items:center;border-radius:11px;color:#2563eb;background:#eff6ff}.card-icon svg{width:18px;height:18px}.info-card:nth-child(3n+2) .card-icon{color:#7e22ce;background:#faf5ff}.info-card:nth-child(3n) .card-icon{color:#0e7490;background:#ecfeff}.info-card h3{margin:12px 0 5px;font-size:12px}.info-card p{margin:0;color:var(--muted);font-size:10px;line-height:1.7}.card-link{display:inline-block;margin-top:9px;color:var(--blue);font-size:10px;font-weight:700}
    .notice{margin-top:15px;padding:12px 14px;border:1px solid #bfdbfe;border-radius:12px;color:#1e40af;background:#eff6ff;font-size:11px;line-height:1.6}.event-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:13px}.event-card{padding:17px;border:1px solid var(--border);border-radius:15px;background:#fff}.event-top{display:flex;align-items:center;justify-content:space-between;gap:8px}.event-category{padding:5px 8px;border-radius:999px;color:#1d4ed8;background:#eff6ff;font-size:9px;font-weight:700}.event-date{color:var(--muted);font-size:9px;font-weight:600}.event-card h3{margin:13px 0 6px;font-size:12px}.event-card p{margin:0;color:var(--muted);font-size:10px;line-height:1.7}.event-meta{margin-top:12px;padding-top:10px;border-top:1px solid #f1f5f9;color:#475569;font-size:9px;line-height:1.8}
    .actions{display:flex;flex-wrap:wrap;gap:9px;margin-top:17px}.button{min-height:38px;display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:0 13px;border:1px solid var(--border);border-radius:11px;color:#334155;background:#fff;font-size:10px;font-weight:700;text-decoration:none;transition:background .18s ease}.button:hover{background:#f8fafc}.button.primary{border-color:var(--blue);color:#fff;background:var(--blue)}.button.primary:hover{background:#0052cc}
    .footer{display:flex;justify-content:space-between;gap:12px;margin-top:22px;color:var(--faint);font-size:9px}.footer a{color:var(--muted);text-decoration:none}.footer a:hover{color:var(--blue)}
    @media(max-width:850px){.hero{flex-direction:column}.stats{width:100%}.stat{flex:1}.card-grid,.event-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:650px){.topbar-inner,.shell{width:min(100% - 32px,560px)}.topbar-inner{min-height:64px}.nav{display:none}.shell{padding-top:20px}.hero{gap:16px}.card-grid,.event-grid{grid-template-columns:1fr}.info-card{min-height:unset}.footer{flex-direction:column}}
    @media(max-width:430px){.topbar-inner,.shell{width:calc(100% - 28px)}.topbar-right{gap:0}.status{font-size:8px}.hero-copy{gap:10px}.hero-icon{width:39px;height:39px;flex-basis:39px}.stats{gap:6px}.stat{min-width:0;padding:10px 8px}.stat strong{font-size:16px}.stat span{font-size:8px}}
    @media(prefers-reduced-motion:reduce){*,*::before,*::after{transition-duration:.01ms!important}}
  </style>
</head>
<body>
  <header class="topbar"><div class="topbar-inner">
    <a class="brand" href="<?php echo $escape(BASE_URL); ?>"><span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7.5 12 4l8 3.5v9L12 20l-8-3.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 3.4 7.5-3.4M12 11.5V20" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span><span class="brand-name">Campusly</span></a>
    <div class="topbar-right"><nav class="nav" aria-label="Main navigation">
      <a href="<?php echo $escape(BASE_URL); ?>">Home</a><a href="<?php echo $escape(BASE_URL . 'events.php'); ?>">Events</a><a href="<?php echo $escape(BASE_URL . 'about.php'); ?>">About</a><a href="<?php echo $escape(BASE_URL . 'faq.php'); ?>">Help</a><a href="<?php echo $escape(BASE_URL . 'contact.php'); ?>">Contact</a>
    </nav><span class="status"><span class="dot" aria-hidden="true"></span>JSON API: <?php echo (int) $pageStatusCode; ?> <?php echo $escape($pageStatusLabel); ?></span></div>
  </div></header>
  <main class="shell">
    <nav class="crumbs" aria-label="Breadcrumb"><a href="<?php echo $escape(BASE_URL); ?>">Home</a><span class="sep" aria-hidden="true">/</span><span aria-current="page"><?php echo $escape($pageTitle); ?></span></nav>
    <section class="hero" aria-labelledby="page-title">
      <div class="hero-copy"><span class="hero-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3v18M3 12h18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span><div><p class="eyebrow"><?php echo $escape($pageEyebrow); ?></p><h1 id="page-title"><?php echo $escape($pageTitle); ?></h1><p class="subtitle"><?php echo $escape($pageSubtitle); ?></p></div></div>
      <?php if ($pageStats !== []): ?><div class="stats" aria-label="Page highlights"><?php foreach ($pageStats as $stat): ?><div class="stat"><strong><?php echo $escape((string) $stat['value']); ?></strong><span><?php echo $escape((string) $stat['label']); ?></span></div><?php endforeach; ?></div><?php endif; ?>
    </section>
    <?php if ($pageNotice !== ''): ?><div class="notice" role="status"><?php echo $escape($pageNotice); ?></div><?php endif; ?>
    <?php if ($pageEvents !== []): ?>
      <section class="panel" aria-labelledby="events-title"><h2 id="events-title">Upcoming on campus</h2><p class="panel-intro">Find a new interest, meet your community, and make the most of campus life.</p>
        <div class="event-grid"><?php foreach ($pageEvents as $event): ?><article class="event-card"><div class="event-top"><span class="event-category"><?php echo $escape((string) $event['category']); ?></span><span class="event-date"><?php echo $escape(date('M j', strtotime((string) $event['date']))); ?></span></div><h3><?php echo $escape((string) $event['title']); ?></h3><p><?php echo $escape((string) $event['description']); ?></p><div class="event-meta"><?php echo $escape((string) $event['time']); ?> · <?php echo $escape((string) $event['location']); ?></div></article><?php endforeach; ?></div>
      </section>
    <?php endif; ?>
    <?php if ($pageCards !== []): ?>
      <section class="panel" aria-label="Page links"><div class="card-grid"><?php foreach ($pageCards as $card): ?><a class="info-card" href="<?php echo $escape(BASE_URL . ltrim((string) $card['href'], '/')); ?>"><span class="card-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span><h3><?php echo $escape((string) $card['title']); ?></h3><p><?php echo $escape((string) $card['description']); ?></p><span class="card-link"><?php echo $escape((string) ($card['label'] ?? 'Explore')); ?> →</span></a><?php endforeach; ?></div></section>
    <?php endif; ?>
    <?php if (!empty($pageExtraFile)) { require $pageExtraFile; } ?>
    <div class="actions"><a class="button primary" <?php echo !empty($pagePrimaryAction['dialog']) ? 'data-dialog-open="feedback-dialog"' : ''; ?> href="<?php echo !empty($pagePrimaryAction['dialog']) ? '#' . $escape((string) $pagePrimaryAction['dialog']) : $escape(BASE_URL . ltrim((string) $pagePrimaryAction['href'], '/')); ?>"><?php echo $escape((string) $pagePrimaryAction['label']); ?></a><a class="button" href="<?php echo $escape(BASE_URL . 'contact.php'); ?>">Contact support</a></div>
    <footer class="footer"><span>© <?php echo date('Y'); ?> Campusly · Made for campus life.</span><span><a href="<?php echo $escape(BASE_URL . 'contact.php'); ?>">Contact</a> &nbsp;·&nbsp; <a href="<?php echo $escape(BASE_URL . 'feedback.php'); ?>">Feedback</a></span></footer>
  </main>
</body>
</html>
