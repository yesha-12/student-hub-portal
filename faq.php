<?php
if (!defined('BASE_URL')) {
    $base = dirname($_SERVER['PHP_SELF']);
    define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
}

$faqItems = [
    [
        'category' => 'Getting started',
        'question' => 'What is Campusly?',
        'answer' => 'Campusly is your student hub for staying connected with campus life. Find events, keep up with important updates, and get to the information you need in one place.',
    ],
    [
        'category' => 'Getting started',
        'question' => 'How do I create an account?',
        'answer' => 'Choose Create account from the sign-in page and complete the registration form with your student details. Once your account is ready, you can sign in to explore the portal.',
    ],
    [
        'category' => 'Getting started',
        'question' => 'I am having trouble signing in. What should I do?',
        'answer' => 'Check that your student ID and password are entered correctly. If you still cannot sign in, contact the campus support team so they can help you regain access.',
    ],
    [
        'category' => 'Events',
        'question' => 'Where can I find upcoming campus events?',
        'answer' => 'Open Events from the main navigation to browse campus activities. Event details include the date, time, location, and any registration information shared by the organizer.',
    ],
    [
        'category' => 'Events',
        'question' => 'How do I register for an event?',
        'answer' => 'Open an event and use its registration action if one is available. You should see a confirmation on the event page after your registration is recorded.',
    ],
    [
        'category' => 'Events',
        'question' => 'Can I see the events I have joined?',
        'answer' => 'Sign in and visit My Events to review the events associated with your account.',
    ],
    [
        'category' => 'Courses & materials',
        'question' => 'Where are my course materials?',
        'answer' => 'Sign in to your student account and open Materials to view resources shared for your courses.',
    ],
    [
        'category' => 'Courses & materials',
        'question' => 'I cannot see one of my courses. What should I check?',
        'answer' => 'Course access depends on your current enrollment. If a course is missing, check with your department or campus administrator to confirm your enrollment details.',
    ],
    [
        'category' => 'Courses & materials',
        'question' => 'Who can I ask about an assignment?',
        'answer' => 'Your course instructor is the best person to contact about assignment instructions, deadlines, or feedback.',
    ],
    [
        'category' => 'Account & support',
        'question' => 'How do I update my profile?',
        'answer' => 'Sign in and open your Profile page to review and update the personal details available to you.',
    ],
    [
        'category' => 'Account & support',
        'question' => 'How can I contact the Campusly team?',
        'answer' => 'Visit the Contact page and send a message with a brief description of what you need help with. Avoid including your password or other sensitive information.',
    ],
    [
        'category' => 'Account & support',
        'question' => 'How do I share feedback about the portal?',
        'answer' => 'Use the Feedback page to tell us what is working well or what could be improved. Specific details help the team understand your experience.',
    ],
];

$faqCategories = array_values(array_unique(array_column($faqItems, 'category')));
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
  <title>Frequently asked questions | Campusly</title>
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
      --surface: #fff;
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
    button, input { font: inherit; }
    button { cursor: pointer; }

    .topbar {
      position: sticky;
      z-index: 5;
      top: 0;
      border-bottom: 1px solid rgba(226, 232, 240, .88);
      background: rgba(255, 255, 255, .9);
      backdrop-filter: blur(14px);
    }

    .topbar-inner, .page-shell {
      width: min(1160px, calc(100% - 48px));
      margin-inline: auto;
    }

    .topbar-inner {
      min-height: 76px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
    }

    .brand-group, .brand, .topbar-right, .nav-links, .crumbs, .page-heading, .heading-icon, .status-pill, .stat, .search-wrap, .category-row, .category-button, .question-title, .contact-card, .contact-icon, .inspector-trigger, .inspector-head, .network-row, .request-method, .response-status {
      display: flex;
      align-items: center;
    }

    .brand-group { gap: 14px; }
    .brand { gap: 10px; text-decoration: none; }
    .brand-mark {
      width: 36px;
      height: 36px;
      display: grid;
      place-items: center;
      border-radius: 12px;
      color: #fff;
      background: var(--blue);
      box-shadow: 0 5px 12px rgba(0, 102, 255, .2);
    }
    .brand-mark svg { width: 21px; height: 21px; }
    .brand-name { font-size: 19px; font-weight: 800; letter-spacing: -.7px; }
    .product-tag {
      padding: 7px 11px;
      border: 1px solid var(--border);
      border-radius: 999px;
      color: #475569;
      background: #f8fafc;
      font-size: 11px;
      font-weight: 600;
      white-space: nowrap;
    }

    .topbar-right { justify-content: flex-end; gap: 24px; }
    .nav-links { gap: 21px; }
    .nav-links a {
      color: #475569;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      transition: color .18s ease;
    }
    .nav-links a:hover, .nav-links a[aria-current="page"] { color: var(--blue); }
    .status-pill {
      gap: 7px;
      padding: 7px 10px;
      border: 1px solid rgba(167, 243, 208, .8);
      border-radius: 999px;
      color: #047857;
      background: #ecfdf5;
      font-size: 11px;
      font-weight: 700;
      white-space: nowrap;
    }
    .status-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green); box-shadow: 0 0 0 3px rgba(16, 185, 129, .12); }

    .page-shell { padding: 30px 0 96px; }
    .crumbs { gap: 9px; margin-bottom: 28px; color: var(--faint); font-size: 12px; }
    .crumbs a { color: var(--muted); text-decoration: none; }
    .crumbs a:hover { color: var(--blue); }
    .crumb-separator { color: #cbd5e1; }

    .page-heading {
      align-items: flex-start;
      justify-content: space-between;
      gap: 35px;
      margin-bottom: 28px;
    }
    .heading-main { display: flex; align-items: flex-start; gap: 16px; max-width: 620px; }
    .heading-icon {
      width: 48px;
      height: 48px;
      flex: 0 0 48px;
      justify-content: center;
      border: 1px solid #dbeafe;
      border-radius: 15px;
      color: var(--blue);
      background: #eff6ff;
    }
    .heading-icon svg { width: 23px; height: 23px; }
    .eyebrow { margin: 1px 0 6px; color: var(--blue); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; }
    h1 { margin: 0; font-size: clamp(25px, 3vw, 32px); line-height: 1.2; letter-spacing: -1.25px; }
    .heading-copy { margin: 9px 0 0; color: var(--muted); font-size: 13px; line-height: 1.75; }

    .stats { display: grid; grid-template-columns: repeat(3, minmax(90px, 1fr)); gap: 10px; }
    .stat {
      min-width: 100px;
      min-height: 76px;
      align-items: flex-start;
      justify-content: center;
      flex-direction: column;
      padding: 13px 16px;
      border: 1px solid var(--border);
      border-radius: 16px;
      background: #fff;
      box-shadow: 0 1px 2px rgba(15, 23, 42, .03);
    }
    .stat strong { font-size: 20px; line-height: 1.1; letter-spacing: -.6px; }
    .stat span { margin-top: 5px; color: var(--muted); font-size: 10px; font-weight: 600; white-space: nowrap; }

    .content-grid { display: grid; grid-template-columns: minmax(0, 1fr) 275px; gap: 18px; align-items: start; }
    .faq-panel, .side-card {
      border: 1px solid var(--border);
      border-radius: 18px;
      background: var(--surface);
      box-shadow: 0 2px 5px rgba(15, 23, 42, .035);
    }
    .faq-panel { overflow: hidden; }
    .panel-top { padding: 22px 24px 18px; border-bottom: 1px solid #f1f5f9; }
    .panel-title-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; }
    .panel-title-row h2, .side-card h2 { margin: 0; font-size: 16px; letter-spacing: -.35px; }
    .panel-title-row p { margin: 5px 0 0; color: var(--muted); font-size: 12px; line-height: 1.6; }
    .results-label { padding: 6px 9px; border-radius: 999px; color: #475569; background: #f1f5f9; font-size: 10px; font-weight: 700; white-space: nowrap; }

    .search-wrap { position: relative; margin-top: 17px; }
    .search-wrap svg { position: absolute; left: 13px; width: 17px; height: 17px; color: #94a3b8; pointer-events: none; }
    .search-input {
      width: 100%;
      height: 44px;
      padding: 0 42px 0 40px;
      border: 1px solid var(--border);
      border-radius: 12px;
      outline: none;
      color: var(--navy);
      background: #fff;
      font-size: 12px;
      transition: border-color .18s ease, box-shadow .18s ease;
    }
    .search-input::placeholder { color: #94a3b8; }
    .search-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, .13); }
    .search-clear {
      position: absolute;
      right: 9px;
      width: 27px;
      height: 27px;
      display: none;
      place-items: center;
      border: 0;
      border-radius: 8px;
      color: #64748b;
      background: #f1f5f9;
      font-size: 17px;
    }
    .search-clear.visible { display: grid; }

    .category-row { flex-wrap: wrap; gap: 7px; padding: 15px 24px; border-bottom: 1px solid #f1f5f9; }
    .category-button {
      min-height: 31px;
      justify-content: center;
      padding: 0 11px;
      border: 1px solid transparent;
      border-radius: 999px;
      color: #64748b;
      background: #f8fafc;
      font-size: 10px;
      font-weight: 700;
      transition: all .18s ease;
    }
    .category-button:hover { color: var(--blue); background: #eff6ff; }
    .category-button[aria-pressed="true"] { border-color: #bfdbfe; color: #1d4ed8; background: #eff6ff; }

    .faq-list { padding: 0 24px; }
    .faq-item { border-bottom: 1px solid #f1f5f9; }
    .faq-item:last-child { border-bottom: 0; }
    .faq-item[hidden] { display: none; }
    .faq-item summary {
      display: flex;
      min-height: 65px;
      align-items: center;
      justify-content: space-between;
      gap: 15px;
      padding: 13px 0;
      list-style: none;
      cursor: pointer;
    }
    .faq-item summary::-webkit-details-marker { display: none; }
    .question-title { gap: 11px; font-size: 12px; font-weight: 700; line-height: 1.55; }
    .question-marker {
      width: 27px;
      height: 27px;
      flex: 0 0 27px;
      display: grid;
      place-items: center;
      border-radius: 9px;
      color: #2563eb;
      background: #eff6ff;
      font-size: 12px;
      font-weight: 800;
    }
    .chevron { width: 17px; height: 17px; flex: 0 0 17px; color: #94a3b8; transition: transform .2s ease; }
    .faq-item[open] .chevron { transform: rotate(180deg); color: var(--blue); }
    .faq-answer { margin: -2px 32px 17px 38px; color: var(--muted); font-size: 12px; line-height: 1.8; }
    .empty-state { display: none; padding: 42px 24px; color: var(--muted); text-align: center; }
    .empty-state.visible { display: block; }
    .empty-state strong { display: block; margin-bottom: 7px; color: var(--navy); font-size: 13px; }
    .empty-state p { margin: 0; font-size: 12px; }

    .sidebar { display: grid; gap: 14px; }
    .side-card { padding: 20px; }
    .support-card {
      position: relative;
      overflow: hidden;
      border-color: #dbeafe;
      background: linear-gradient(145deg, #fff 12%, #eff6ff 100%);
    }
    .support-card:after {
      position: absolute;
      top: -40px;
      right: -35px;
      width: 110px;
      height: 110px;
      border: 1px solid rgba(59, 130, 246, .12);
      border-radius: 50%;
      content: "";
      box-shadow: 0 0 0 15px rgba(59, 130, 246, .035), 0 0 0 30px rgba(59, 130, 246, .025);
      pointer-events: none;
    }
    .contact-icon { width: 37px; height: 37px; justify-content: center; margin-bottom: 16px; border-radius: 12px; color: var(--blue); background: #dbeafe; }
    .contact-icon svg { width: 19px; height: 19px; }
    .side-card h2 { font-size: 14px; }
    .side-card p { margin: 8px 0 16px; color: var(--muted); font-size: 11px; line-height: 1.75; }
    .primary-link, .secondary-link {
      min-height: 38px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 0 13px;
      border: 1px solid transparent;
      border-radius: 11px;
      color: white;
      background: var(--blue);
      box-shadow: 0 3px 7px rgba(0, 102, 255, .14);
      font-size: 11px;
      font-weight: 700;
      text-decoration: none;
      transition: background .18s ease, transform .18s ease;
    }
    .primary-link:hover { background: #0052cc; transform: translateY(-1px); }
    .primary-link svg, .secondary-link svg { width: 14px; height: 14px; }
    .secondary-link { color: #475569; border-color: var(--border); background: white; box-shadow: none; }
    .secondary-link:hover { background: #f8fafc; }
    .quick-links { display: grid; gap: 0; margin-top: 12px; }
    .quick-links a { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 11px 0; border-top: 1px solid #f1f5f9; color: #475569; font-size: 11px; font-weight: 600; text-decoration: none; }
    .quick-links a:hover { color: var(--blue); }
    .quick-links span { color: #94a3b8; font-size: 15px; }
    .secure-note { display: flex; gap: 9px; align-items: flex-start; padding: 13px; border: 1px solid #e2e8f0; border-radius: 12px; color: #64748b; background: #f8fafc; font-size: 10px; line-height: 1.65; }
    .secure-note svg { width: 15px; height: 15px; flex: 0 0 15px; margin-top: 1px; color: #64748b; }

    .page-footer { display: flex; justify-content: space-between; gap: 14px; padding-top: 23px; color: #94a3b8; font-size: 10px; }
    .page-footer a { color: #64748b; text-decoration: none; }
    .page-footer a:hover { color: var(--blue); }

    .inspector-trigger {
      position: fixed;
      z-index: 9;
      right: 22px;
      bottom: 20px;
      gap: 9px;
      padding: 11px 14px;
      border: 1px solid #334155;
      border-radius: 12px;
      color: #e2e8f0;
      background: #0f172a;
      box-shadow: 0 8px 26px rgba(15, 23, 42, .22);
      font-size: 11px;
      font-weight: 700;
      transition: transform .18s ease, background .18s ease;
    }
    .inspector-trigger:hover { transform: translateY(-2px); background: #1e293b; }
    .inspector-trigger svg { width: 15px; height: 15px; color: #60a5fa; }
    .inspector-trigger .status-dot { width: 6px; height: 6px; }
    .inspector {
      position: fixed;
      z-index: 10;
      right: 22px;
      bottom: 74px;
      width: min(650px, calc(100vw - 32px));
      overflow: hidden;
      border: 1px solid #cbd5e1;
      border-radius: 15px;
      background: #fff;
      box-shadow: 0 18px 50px rgba(15, 23, 42, .2);
    }
    .inspector[hidden] { display: none; }
    .inspector-head { min-height: 49px; justify-content: space-between; padding: 0 15px; border-bottom: 1px solid var(--border); background: #f8fafc; }
    .inspector-head strong { font-size: 11px; }
    .inspector-head span { margin-left: 8px; color: #94a3b8; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 10px; }
    .inspector-close { width: 28px; height: 28px; border: 0; border-radius: 8px; color: #64748b; background: transparent; font-size: 19px; }
    .inspector-close:hover { background: #e2e8f0; }
    .inspector-body { display: grid; grid-template-columns: minmax(0, 1fr) 195px; min-height: 168px; }
    .network-list { padding: 12px; border-right: 1px solid var(--border); }
    .network-row { gap: 9px; min-height: 42px; padding: 0 8px; border: 1px solid #dbeafe; border-radius: 9px; background: #eff6ff; }
    .request-method { min-width: 36px; justify-content: center; padding: 4px 5px; border-radius: 5px; color: #1d4ed8; background: #dbeafe; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 9px; font-weight: 800; }
    .request-name { min-width: 0; overflow: hidden; color: #334155; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 10px; text-overflow: ellipsis; white-space: nowrap; }
    .response-status { gap: 5px; margin-left: auto; color: #047857; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 9px; white-space: nowrap; }
    .response-status .status-dot { width: 6px; height: 6px; box-shadow: none; }
    .network-caption { margin: 9px 2px 0; color: #94a3b8; font-size: 9px; }
    .inspector-details { padding: 14px 12px; }
    .inspector-details h3 { margin: 0 0 10px; color: #64748b; font-size: 9px; letter-spacing: .7px; text-transform: uppercase; }
    .detail-line { display: flex; justify-content: space-between; gap: 8px; margin-top: 8px; color: #64748b; font-size: 9px; }
    .detail-line strong { color: #334155; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 9px; font-weight: 600; text-align: right; }

    @media (max-width: 860px) {
      .content-grid { grid-template-columns: minmax(0, 1fr) 240px; gap: 14px; }
      .topbar-right { gap: 15px; }
      .nav-links { gap: 14px; }
      .product-tag { display: none; }
      .stat { min-width: 84px; padding-inline: 12px; }
    }
    @media (max-width: 680px) {
      .topbar-inner, .page-shell { width: min(100% - 32px, 560px); }
      .topbar-inner { min-height: 66px; }
      .nav-links { display: none; }
      .topbar-right { gap: 0; }
      .page-shell { padding-top: 22px; }
      .crumbs { margin-bottom: 22px; }
      .page-heading { align-items: stretch; flex-direction: column; gap: 18px; }
      .stats { grid-template-columns: repeat(3, 1fr); }
      .stat { min-width: 0; min-height: 67px; padding: 10px 12px; }
      .stat strong { font-size: 18px; }
      .stat span { font-size: 9px; }
      .content-grid { grid-template-columns: 1fr; }
      .sidebar { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .support-card { grid-row: span 2; }
    }
    @media (max-width: 470px) {
      .topbar-inner, .page-shell { width: calc(100% - 28px); }
      .brand-name { font-size: 17px; }
      .status-pill { padding: 7px 8px; font-size: 9px; }
      .heading-main { gap: 12px; }
      .heading-icon { width: 42px; height: 42px; flex-basis: 42px; border-radius: 13px; }
      h1 { font-size: 25px; }
      .heading-copy { font-size: 12px; }
      .panel-top { padding: 18px 16px 15px; }
      .category-row { padding: 13px 16px; }
      .faq-list { padding: 0 16px; }
      .question-title { font-size: 11px; }
      .faq-answer { margin-left: 38px; font-size: 11px; }
      .sidebar { grid-template-columns: 1fr; }
      .support-card { grid-row: auto; }
      .page-footer { flex-direction: column; }
      .inspector-trigger { right: 14px; bottom: 14px; }
      .inspector { right: 8px; bottom: 66px; width: calc(100vw - 16px); }
      .inspector-body { grid-template-columns: minmax(0, 1fr) 145px; }
      .request-name { font-size: 9px; }
      .response-status { font-size: 8px; }
    }
    @media (prefers-reduced-motion: reduce) {
      *, *:before, *:after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
    }
  </style>
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <div class="brand-group">
        <a class="brand" href="<?php echo htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Campusly home">
          <span class="brand-mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M4 8.5 12 4l8 4.5-8 4.5L4 8.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M7 10.5v4.1c0 .8 2.2 2.4 5 2.4s5-1.6 5-2.4v-4.1M20 9v5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
          <span class="brand-name">Campusly</span>
        </a>
        <span class="product-tag">Practical Engine / Student Hub</span>
      </div>
      <div class="topbar-right">
        <nav class="nav-links" aria-label="Main navigation">
          <a href="<?php echo htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8'); ?>">Home</a>
          <a href="<?php echo htmlspecialchars(BASE_URL . 'events.php', ENT_QUOTES, 'UTF-8'); ?>">Events</a>
          <a href="<?php echo htmlspecialchars(BASE_URL . 'about.php', ENT_QUOTES, 'UTF-8'); ?>">About</a>
          <a href="<?php echo htmlspecialchars(BASE_URL . 'faq.php', ENT_QUOTES, 'UTF-8'); ?>" aria-current="page">Help</a>
        </nav>
        <span class="status-pill"><span class="status-dot" aria-hidden="true"></span>Page: <?php echo (int) $pageStatusCode; ?> <?php echo htmlspecialchars($pageStatusLabel, ENT_QUOTES, 'UTF-8'); ?></span>
      </div>
    </div>
  </header>

  <main class="page-shell">
    <nav class="crumbs" aria-label="Breadcrumb">
      <a href="<?php echo htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8'); ?>">Home</a>
      <span class="crumb-separator" aria-hidden="true">/</span>
      <a href="<?php echo htmlspecialchars(BASE_URL . 'faq.php', ENT_QUOTES, 'UTF-8'); ?>">Help center</a>
      <span class="crumb-separator" aria-hidden="true">/</span>
      <span aria-current="page">FAQs</span>
    </nav>

    <section class="page-heading" aria-labelledby="page-title">
      <div class="heading-main">
        <span class="heading-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none"><path d="M12 18.25h.01M9.1 9a3 3 0 1 1 4.7 2.45c-1 .68-1.8 1.25-1.8 2.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/></svg>
        </span>
        <div>
          <p class="eyebrow">Campusly help center</p>
          <h1 id="page-title">Frequently asked questions</h1>
          <p class="heading-copy">Find quick answers about your account, campus events, courses, and getting the most out of Campusly.</p>
        </div>
      </div>
      <div class="stats" aria-label="Help center highlights">
        <div class="stat"><strong><?php echo count($faqItems); ?></strong><span>Helpful answers</span></div>
        <div class="stat"><strong><?php echo count($faqCategories); ?></strong><span>Topics covered</span></div>
        <div class="stat"><strong>0</strong><span>Sign-in needed</span></div>
      </div>
    </section>

    <div class="content-grid">
      <section class="faq-panel" aria-labelledby="faq-panel-title">
        <div class="panel-top">
          <div class="panel-title-row">
            <div>
              <h2 id="faq-panel-title">How can we help?</h2>
              <p>Search the answers or choose a topic to get started.</p>
            </div>
            <span class="results-label" id="results-count" aria-live="polite"><?php echo count($faqItems); ?> articles</span>
          </div>
          <label class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.8"/><path d="m16 16 4.2 4.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            <span class="visually-hidden" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Search frequently asked questions</span>
            <input class="search-input" id="faq-search" type="search" placeholder="Search questions, topics, or keywords..." autocomplete="off">
            <button class="search-clear" id="search-clear" type="button" aria-label="Clear search">×</button>
          </label>
        </div>

        <div class="category-row" role="group" aria-label="Filter by topic">
          <button class="category-button" type="button" data-category="all" aria-pressed="true">All topics</button>
          <?php foreach ($faqCategories as $category): ?>
            <button class="category-button" type="button" data-category="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>" aria-pressed="false"><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></button>
          <?php endforeach; ?>
        </div>

        <div class="faq-list" id="faq-list">
          <?php foreach ($faqItems as $index => $item): ?>
            <details class="faq-item" data-category="<?php echo htmlspecialchars($item['category'], ENT_QUOTES, 'UTF-8'); ?>" data-search="<?php echo htmlspecialchars(strtolower($item['question'] . ' ' . $item['answer'] . ' ' . $item['category']), ENT_QUOTES, 'UTF-8'); ?>">
              <summary>
                <span class="question-title"><span class="question-marker" aria-hidden="true">Q</span><?php echo htmlspecialchars($item['question'], ENT_QUOTES, 'UTF-8'); ?></span>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </summary>
              <p class="faq-answer"><?php echo htmlspecialchars($item['answer'], ENT_QUOTES, 'UTF-8'); ?></p>
            </details>
          <?php endforeach; ?>
        </div>
        <div class="empty-state" id="empty-state" role="status">
          <strong>No matching answers yet</strong>
          <p>Try another search or choose a different topic.</p>
        </div>
      </section>

      <aside class="sidebar" aria-label="More help">
        <section class="side-card support-card">
          <span class="contact-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v8a2.5 2.5 0 0 1-2.5 2.5h-6l-4.5 3v-3h-.5A2.5 2.5 0 0 1 4 14.5v-8Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8 9h8M8 12.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
          </span>
          <h2>Still need a hand?</h2>
          <p>Our campus team can help with account access, portal questions, and more.</p>
          <a class="primary-link" href="<?php echo htmlspecialchars(BASE_URL . 'contact.php', ENT_QUOTES, 'UTF-8'); ?>">
            Contact support
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </section>

        <section class="side-card">
          <h2>Explore Campusly</h2>
          <p>Jump straight to the pages students visit most.</p>
          <div class="quick-links">
            <a href="<?php echo htmlspecialchars(BASE_URL . 'events.php', ENT_QUOTES, 'UTF-8'); ?>">Campus events <span aria-hidden="true">›</span></a>
            <a href="<?php echo htmlspecialchars(BASE_URL . 'about.php', ENT_QUOTES, 'UTF-8'); ?>">About the portal <span aria-hidden="true">›</span></a>
            <a href="<?php echo htmlspecialchars(BASE_URL . 'feedback.php', ENT_QUOTES, 'UTF-8'); ?>">Share feedback <span aria-hidden="true">›</span></a>
          </div>
        </section>

        <div class="secure-note">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="5" y="10" width="14" height="11" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 10V7a4 4 0 1 1 8 0v3m-4 5v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
          <span>For your safety, never share your password in a support message.</span>
        </div>
      </aside>
    </div>

    <footer class="page-footer">
      <span>© <?php echo date('Y'); ?> Campusly · Made for campus life.</span>
      <span><a href="<?php echo htmlspecialchars(BASE_URL . 'contact.php', ENT_QUOTES, 'UTF-8'); ?>">Contact</a> &nbsp;·&nbsp; <a href="<?php echo htmlspecialchars(BASE_URL . 'feedback.php', ENT_QUOTES, 'UTF-8'); ?>">Feedback</a></span>
    </footer>
  </main>

  <button class="inspector-trigger" id="inspector-trigger" type="button" aria-expanded="false" aria-controls="network-inspector">
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 5h16v14H4zM4 9h16M8 7h.01M11 7h.01m-3 5h4m-4 3h8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
    Network inspector
    <span class="status-dot" aria-hidden="true"></span>
  </button>
  <section class="inspector" id="network-inspector" aria-label="Document request inspector" hidden>
    <div class="inspector-head">
      <div><strong>Network</strong><span>Document request</span></div>
      <button class="inspector-close" id="inspector-close" type="button" aria-label="Close network inspector">×</button>
    </div>
    <div class="inspector-body">
      <div class="network-list">
        <div class="network-row">
          <span class="request-method">GET</span>
          <span class="request-name" id="request-name">/faq.php</span>
          <span class="response-status"><span class="status-dot" aria-hidden="true"></span><?php echo (int) $pageStatusCode; ?> <?php echo htmlspecialchars($pageStatusLabel, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <p class="network-caption">Current page document · no API request is required for these FAQs.</p>
      </div>
      <div class="inspector-details">
        <h3>Request details</h3>
        <div class="detail-line"><span>Type</span><strong>document</strong></div>
        <div class="detail-line"><span>Response</span><strong>text/html</strong></div>
        <div class="detail-line"><span>Payload</span><strong>none</strong></div>
        <div class="detail-line"><span>Load time</span><strong id="request-latency">—</strong></div>
      </div>
    </div>
  </section>

  <script>
    (() => {
      const searchInput = document.getElementById('faq-search');
      const clearButton = document.getElementById('search-clear');
      const categoryButtons = Array.from(document.querySelectorAll('.category-button'));
      const faqItems = Array.from(document.querySelectorAll('.faq-item'));
      const resultCount = document.getElementById('results-count');
      const emptyState = document.getElementById('empty-state');
      const inspectorTrigger = document.getElementById('inspector-trigger');
      const inspector = document.getElementById('network-inspector');
      const inspectorClose = document.getElementById('inspector-close');
      const requestName = document.getElementById('request-name');
      const requestLatency = document.getElementById('request-latency');
      let selectedCategory = 'all';

      const updateFaqs = () => {
        const query = searchInput.value.trim().toLocaleLowerCase();
        let visibleCount = 0;

        faqItems.forEach((item) => {
          const matchesCategory = selectedCategory === 'all' || item.dataset.category === selectedCategory;
          const matchesSearch = !query || item.dataset.search.includes(query);
          const visible = matchesCategory && matchesSearch;
          item.hidden = !visible;
          if (visible) visibleCount += 1;
        });

        resultCount.textContent = `${visibleCount} ${visibleCount === 1 ? 'article' : 'articles'}`;
        emptyState.classList.toggle('visible', visibleCount === 0);
        clearButton.classList.toggle('visible', searchInput.value.length > 0);
      };

      searchInput.addEventListener('input', updateFaqs);
      clearButton.addEventListener('click', () => {
        searchInput.value = '';
        searchInput.focus();
        updateFaqs();
      });

      categoryButtons.forEach((button) => {
        button.addEventListener('click', () => {
          selectedCategory = button.dataset.category;
          categoryButtons.forEach((categoryButton) => {
            categoryButton.setAttribute('aria-pressed', String(categoryButton === button));
          });
          updateFaqs();
        });
      });

      const setInspectorOpen = (isOpen) => {
        inspector.hidden = !isOpen;
        inspectorTrigger.setAttribute('aria-expanded', String(isOpen));
        if (isOpen) inspectorClose.focus();
        else inspectorTrigger.focus();
      };

      inspectorTrigger.addEventListener('click', () => setInspectorOpen(inspector.hidden));
      inspectorClose.addEventListener('click', () => setInspectorOpen(false));
      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !inspector.hidden) setInspectorOpen(false);
      });

      requestName.textContent = window.location.pathname + window.location.search;
      window.addEventListener('load', () => {
        const timing = performance.getEntriesByType('navigation')[0];
        if (timing && timing.loadEventEnd > 0) {
          requestLatency.textContent = `${Math.round(timing.loadEventEnd)} ms`;
        }
      }, { once: true });
    })();
  </script>
</body>
</html>
