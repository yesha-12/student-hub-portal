<?php
if (!defined('BASE_URL')) {
    $base = dirname($_SERVER['PHP_SELF']);
    define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
}

$pageStatusCode = http_response_code();
if ($pageStatusCode === false) {
    $pageStatusCode = 200;
}
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
  <meta name="description" content="Campusly Practical 13 asynchronous student management dashboard demo.">
  <title>Student Management Dashboard | Campusly</title>
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
      padding-bottom: 40px;
      background-color: var(--page);
      background-image:
        linear-gradient(to right, rgba(226, 232, 240, .6) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(226, 232, 240, .6) 1px, transparent 1px);
      background-size: 24px 24px;
    }
    button, input, select { font: inherit; }
    button { cursor: pointer; }
    button:focus-visible, a:focus-visible, input:focus-visible, select:focus-visible { outline: 3px solid rgba(59, 130, 246, .28); outline-offset: 2px; }
    a { color: inherit; }
    .topbar { position: sticky; z-index: 5; top: 0; border-bottom: 1px solid rgba(226, 232, 240, .92); background: rgba(255, 255, 255, .93); backdrop-filter: blur(14px); }
    .topbar-inner, .page-shell { width: min(1320px, calc(100% - 56px)); margin-inline: auto; }
    .topbar-inner { min-height: 68px; display: flex; align-items: center; justify-content: space-between; gap: 18px; }
    .brand, .brand-group, .server-status, .breadcrumbs, .page-title-row, .heading-icon, .stat-card, .toolbar, .toolbar-left, .toolbar-right, .search-box, .catalog-heading, .records-count, .student-cell, .department-badge, .status-badge, .row-actions, .network-trigger, .inspector-heading, .network-item, .method-badge, .network-status, .inspector-tabs, .inspector-tab, .modal-header, .field-error, .empty-state, .toast { display: flex; align-items: center; }
    .brand-group { gap: 12px; }
    .brand { gap: 10px; text-decoration: none; }
    .brand-mark { width: 35px; height: 35px; display: grid; place-items: center; border-radius: 11px; color: #fff; background: var(--blue); box-shadow: 0 4px 10px rgba(0, 102, 255, .19); }
    .brand-mark svg { width: 20px; height: 20px; }
    .brand-name { font-size: 18px; font-weight: 800; letter-spacing: -.65px; }
    .product-pill, .system-pill { padding: 6px 10px; border: 1px solid var(--border); border-radius: 999px; color: #475569; background: #f8fafc; font-size: 10px; font-weight: 700; white-space: nowrap; }
    .server-status { gap: 8px; padding: 7px 11px; border: 1px solid rgba(0, 168, 107, .18); border-radius: 999px; color: #008653; background: #e6f9f0; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 10px; font-weight: 700; white-space: nowrap; }
    .live-dot { width: 7px; height: 7px; flex: 0 0 7px; border-radius: 50%; background: var(--green); box-shadow: 0 0 0 3px rgba(16, 185, 129, .12); }

    .page-shell { padding: 25px 0 48px; }
    .breadcrumbs { flex-wrap: wrap; gap: 8px; margin-bottom: 20px; color: var(--faint); font-size: 10px; }
    .breadcrumbs a { color: var(--muted); text-decoration: none; }
    .breadcrumbs a:hover { color: var(--blue); }
    .breadcrumb-separator { color: #cbd5e1; }
    .page-title-row { align-items: flex-start; justify-content: space-between; gap: 24px; margin-bottom: 22px; }
    .page-title-main { display: flex; align-items: flex-start; gap: 13px; max-width: 700px; }
    .heading-icon { width: 45px; height: 45px; flex: 0 0 45px; justify-content: center; border: 1px solid #dbeafe; border-radius: 14px; color: var(--blue); background: #eff6ff; }
    .heading-icon svg { width: 23px; height: 23px; }
    .eyebrow { margin: 0 0 5px; color: var(--blue); font-size: 9px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; }
    h1 { margin: 0; font-size: clamp(22px, 2.5vw, 29px); line-height: 1.24; letter-spacing: -.9px; }
    .page-description { max-width: 640px; margin: 7px 0 0; color: var(--muted); font-size: 11px; line-height: 1.75; }
    .metrics { display: grid; grid-template-columns: repeat(3, minmax(105px, 1fr)); gap: 9px; }
    .stat-card { min-width: 107px; min-height: 70px; align-items: flex-start; justify-content: center; flex-direction: column; padding: 11px 14px; border: 1px solid var(--border); border-radius: 14px; background: #fff; box-shadow: 0 1px 3px rgba(15, 23, 42, .035); }
    .stat-card strong { font-size: 19px; line-height: 1; letter-spacing: -.6px; }
    .stat-card span { margin-top: 6px; color: var(--muted); font-size: 9px; font-weight: 600; white-space: nowrap; }
    .metric-live { display: flex; align-items: center; gap: 5px; }
    .metric-live i { width: 5px; height: 5px; border-radius: 50%; background: var(--green); }

    .surface-card { border: 1px solid var(--border); border-radius: 16px; background: var(--surface); box-shadow: 0 2px 5px rgba(15, 23, 42, .035); transition: box-shadow .2s ease; }
    .surface-card:hover { box-shadow: 0 5px 14px rgba(15, 23, 42, .055); }
    .toolbar-card { padding: 14px; margin-bottom: 15px; }
    .toolbar { justify-content: space-between; gap: 12px; }
    .toolbar-left, .toolbar-right { gap: 9px; }
    .search-box { position: relative; width: min(370px, 32vw); }
    .search-icon { position: absolute; left: 12px; width: 16px; height: 16px; color: #94a3b8; pointer-events: none; }
    .search-box input, .filter-select, .field-control {
      height: 39px;
      border: 1px solid var(--border);
      border-radius: 10px;
      outline: none;
      color: var(--navy);
      background: #fff;
      font-size: 10px;
      transition: border-color .18s ease, box-shadow .18s ease;
    }
    .search-box input { width: 100%; padding: 0 125px 0 36px; }
    .search-box input::placeholder { color: var(--faint); }
    .search-box input:focus, .filter-select:focus, .field-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, .13); }
    .debounce-pill { position: absolute; right: 7px; display: inline-flex; align-items: center; gap: 4px; padding: 5px 7px; border-radius: 7px; color: #475569; background: #f1f5f9; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 8px; font-weight: 700; white-space: nowrap; }
    .debounce-pill svg { width: 11px; height: 11px; color: #f59e0b; }
    .filter-select { min-width: 120px; padding: 0 30px 0 10px; }
    .button { min-height: 39px; display: inline-flex; align-items: center; justify-content: center; gap: 7px; padding: 0 12px; border: 1px solid var(--border); border-radius: 10px; color: #475569; background: #fff; font-size: 10px; font-weight: 700; white-space: nowrap; transition: background .18s ease, border-color .18s ease, transform .18s ease; }
    .button:hover { background: #f8fafc; }
    .button:active { transform: scale(.98); }
    .button svg { width: 14px; height: 14px; }
    .button-primary { border-color: var(--blue); color: #fff; background: var(--blue); box-shadow: 0 3px 7px rgba(0, 102, 255, .14); }
    .button-primary:hover { border-color: #0052cc; background: #0052cc; }
    .button-blue-soft { border-color: #dbeafe; color: #2563eb; background: #eff6ff; }
    .button-blue-soft:hover { background: #dbeafe; }
    .button:disabled { cursor: wait; opacity: .58; }

    .catalog { overflow: hidden; }
    .catalog-heading { justify-content: space-between; gap: 15px; padding: 17px 18px; border-bottom: 1px solid #f1f5f9; }
    .catalog-heading h2 { margin: 0; font-size: 13px; letter-spacing: -.25px; }
    .catalog-heading p { margin: 4px 0 0; color: var(--muted); font-size: 9px; }
    .records-count { gap: 7px; padding: 6px 9px; border-radius: 999px; color: #475569; background: #f1f5f9; font-size: 9px; font-weight: 700; white-space: nowrap; }
    .records-count .count-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--blue); }
    .table-wrap { width: 100%; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    thead { background: rgba(248, 250, 252, .85); }
    th { height: 39px; padding: 0 15px; color: #64748b; font-size: 8px; font-weight: 800; letter-spacing: .75px; text-transform: uppercase; white-space: nowrap; }
    td { height: 57px; padding: 8px 15px; border-bottom: 1px solid #f1f5f9; color: #475569; font-size: 10px; white-space: nowrap; }
    tbody tr { transition: background .15s ease; }
    tbody tr:hover { background: rgba(248, 250, 252, .75); }
    tbody tr:last-child td { border-bottom: 0; }
    .student-cell { gap: 10px; }
    .avatar { width: 30px; height: 30px; flex: 0 0 30px; display: grid; place-items: center; border: 1px solid #dbeafe; border-radius: 50%; color: #1d4ed8; background: #eff6ff; font-size: 9px; font-weight: 800; }
    .student-name { color: var(--navy); font-size: 10px; font-weight: 700; }
    .student-id { display: block; margin-top: 2px; color: var(--faint); font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 8px; }
    .email-cell { color: #475569; }
    .department-badge { width: fit-content; min-height: 22px; justify-content: center; padding: 0 8px; border-radius: 999px; font-size: 8px; font-weight: 700; }
    .department-badge[data-department="CSE"] { color: #7e22ce; background: #f3e8ff; }
    .department-badge[data-department="CE"] { color: #1d4ed8; background: #ebf4ff; }
    .department-badge[data-department="IT"] { color: #0369a1; background: #e0f2fe; }
    .status-badge { width: fit-content; gap: 6px; min-height: 22px; padding: 0 8px; border: 1px solid rgba(167, 243, 208, .8); border-radius: 999px; color: #047857; background: #ecfdf5; font-size: 8px; font-weight: 700; }
    .status-badge .status-indicator { width: 5px; height: 5px; border-radius: 50%; background: var(--green); }
    .status-badge.inactive { border-color: #e2e8f0; color: #64748b; background: #f1f5f9; }
    .status-badge.inactive .status-indicator { background: #94a3b8; }
    .row-actions { gap: 6px; }
    .action-button { width: 29px; height: 29px; display: grid; place-items: center; padding: 0; border: 1px solid transparent; border-radius: 8px; transition: background .15s ease; }
    .action-button svg { width: 14px; height: 14px; }
    .action-edit { color: #2563eb; background: #eff6ff; }
    .action-edit:hover { background: #dbeafe; }
    .action-delete { color: #dc2626; background: #fef2f2; }
    .action-delete:hover { background: #fee2e2; }
    .empty-state { min-height: 150px; justify-content: center; flex-direction: column; gap: 5px; color: var(--muted); text-align: center; }
    .empty-state strong { color: var(--navy); font-size: 11px; }
    .empty-state span { font-size: 9px; }
    .catalog-footer { display: flex; justify-content: space-between; gap: 12px; padding: 11px 17px; border-top: 1px solid #f1f5f9; color: var(--faint); font-size: 8px; }
    .system-pill { padding: 4px 7px; border: 0; border-radius: 6px; color: #64748b; background: #f1f5f9; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 8px; }
    .demo-notice { display: flex; align-items: flex-start; gap: 8px; margin-top: 12px; padding: 10px 12px; border: 1px solid #dbeafe; border-radius: 11px; color: #475569; background: rgba(239, 246, 255, .83); font-size: 9px; line-height: 1.6; }
    .demo-notice svg { width: 14px; height: 14px; flex: 0 0 14px; margin-top: 1px; color: var(--blue); }

    .modal { width: min(500px, calc(100% - 28px)); max-height: min(90vh, 750px); padding: 0; overflow: auto; border: 1px solid var(--border); border-radius: 18px; color: var(--navy); background: #fff; box-shadow: 0 24px 70px rgba(15, 23, 42, .22); }
    .modal::backdrop { background: rgba(15, 23, 42, .42); backdrop-filter: blur(4px); }
    .modal-form { padding: 22px; }
    .modal-header { justify-content: space-between; gap: 14px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
    .modal-header h2 { margin: 0; font-size: 16px; letter-spacing: -.4px; }
    .modal-header p { margin: 4px 0 0; color: var(--muted); font-size: 9px; }
    .modal-close { width: 30px; height: 30px; display: grid; place-items: center; border: 0; border-radius: 9px; color: #64748b; background: #f1f5f9; font-size: 20px; }
    .modal-fields { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; padding-top: 16px; }
    .form-field { min-width: 0; }
    .form-field.full { grid-column: 1 / -1; }
    .form-field label { display: block; margin-bottom: 6px; color: #334155; font-size: 9px; font-weight: 700; }
    .field-control { width: 100%; height: 39px; padding: 0 10px; font-size: 10px; }
    .field-control.invalid { border-color: #fecdd3; background: #fff5f5; }
    .field-control.invalid:focus { border-color: #f87171; box-shadow: 0 0 0 3px rgba(248, 113, 113, .13); }
    .field-error { display: none; gap: 5px; margin-top: 5px; color: #dc2626; font-size: 8px; line-height: 1.5; }
    .field-error.visible { display: flex; }
    .modal-actions { display: flex; justify-content: flex-end; gap: 8px; padding-top: 18px; }
    .modal-status { min-height: 16px; margin: 10px 0 -4px; color: #dc2626; font-size: 9px; }

    .network-trigger { position: fixed; z-index: 12; right: 18px; bottom: 15px; gap: 8px; min-height: 38px; padding: 0 12px; border: 1px solid #334155; border-radius: 11px; color: #f8fafc; background: #0f172a; box-shadow: 0 8px 24px rgba(15, 23, 42, .2); font-size: 9px; font-weight: 700; transition: transform .18s ease, background .18s ease; }
    .network-trigger:hover { transform: translateY(-1px); background: #1e293b; }
    .network-trigger svg { width: 15px; height: 15px; color: #60a5fa; }
    .network-trigger .live-dot { width: 6px; height: 6px; flex-basis: 6px; }
    .network-panel { position: fixed; z-index: 11; right: 14px; bottom: 62px; width: min(820px, calc(100vw - 28px)); overflow: hidden; border: 1px solid #cbd5e1; border-radius: 14px; background: #fff; box-shadow: 0 18px 54px rgba(15, 23, 42, .21); }
    .network-panel[hidden] { display: none; }
    .inspector-heading { min-height: 42px; justify-content: space-between; padding: 0 13px; border-bottom: 1px solid var(--border); background: #f8fafc; }
    .inspector-heading strong { font-size: 10px; }
    .inspector-heading span { margin-left: 8px; color: var(--faint); font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 8px; }
    .inspector-close { width: 26px; height: 26px; border: 0; border-radius: 7px; color: #64748b; background: transparent; font-size: 18px; }
    .network-layout { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(250px, .8fr); min-height: 204px; max-height: 310px; }
    .network-list { min-width: 0; overflow: auto; padding: 8px; border-right: 1px solid var(--border); }
    .network-item { width: 100%; min-height: 34px; gap: 8px; padding: 0 7px; border: 1px solid transparent; border-radius: 7px; background: transparent; text-align: left; }
    .network-item:hover, .network-item[aria-selected="true"] { border-color: #dbeafe; background: #eff6ff; }
    .network-name { min-width: 0; overflow: hidden; flex: 1; color: #334155; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 8px; text-overflow: ellipsis; white-space: nowrap; }
    .method-badge { min-width: 42px; justify-content: center; padding: 4px 5px; border-radius: 5px; color: #1d4ed8; background: #dbeafe; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 7px; font-weight: 800; }
    .method-badge.post { color: #7e22ce; background: #f3e8ff; }
    .method-badge.put { color: #0369a1; background: #e0f2fe; }
    .method-badge.delete { color: #dc2626; background: #fee2e2; }
    .network-status { gap: 4px; color: #047857; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 7px; white-space: nowrap; }
    .network-status.error { color: #dc2626; }
    .network-time { width: 42px; color: #64748b; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 7px; text-align: right; white-space: nowrap; }
    .inspector-detail { min-width: 0; padding: 10px; }
    .inspector-tabs { gap: 3px; margin-bottom: 9px; border-bottom: 1px solid #e2e8f0; }
    .inspector-tab { min-height: 27px; padding: 0 7px; border: 0; border-bottom: 2px solid transparent; color: #64748b; background: transparent; font-size: 8px; font-weight: 600; white-space: nowrap; }
    .inspector-tab[aria-selected="true"] { border-color: var(--blue); color: var(--blue); }
    .detail-content { max-height: 150px; overflow: auto; margin: 0; color: #334155; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 8px; line-height: 1.7; white-space: pre-wrap; overflow-wrap: anywhere; }
    .toast { position: fixed; z-index: 20; top: 82px; right: 18px; max-width: min(360px, calc(100vw - 36px)); gap: 8px; padding: 10px 13px; border: 1px solid #a7f3d0; border-radius: 11px; color: #047857; background: #ecfdf5; box-shadow: 0 8px 20px rgba(15, 23, 42, .1); font-size: 9px; font-weight: 600; opacity: 0; transform: translateY(-6px); pointer-events: none; transition: opacity .2s ease, transform .2s ease; }
    .toast.visible { opacity: 1; transform: translateY(0); }
    .toast.error { border-color: #fecdd3; color: #dc2626; background: #fff5f5; }

    @media (max-width: 1050px) {
      .topbar-inner, .page-shell { width: min(100% - 40px, 960px); }
      .page-title-row { flex-direction: column; }
      .metrics { width: min(100%, 440px); }
      .toolbar { align-items: stretch; flex-direction: column; }
      .toolbar-left, .toolbar-right { flex-wrap: wrap; }
      .search-box { width: min(100%, 400px); flex: 1 1 320px; }
    }
    @media (max-width: 700px) {
      .topbar-inner, .page-shell { width: calc(100% - 30px); }
      .topbar-inner { min-height: 62px; }
      .product-pill { display: none; }
      .page-shell { padding-top: 18px; }
      .breadcrumbs { font-size: 9px; }
      .toolbar-left, .toolbar-right { align-items: stretch; }
      .search-box { width: 100%; flex-basis: 100%; }
      .filter-select { flex: 1; }
      .toolbar-right .button { flex: 1; }
      .table-wrap table { min-width: 730px; }
      .catalog-heading { align-items: flex-start; }
      .catalog-footer { align-items: flex-start; flex-direction: column; }
      .network-layout { grid-template-columns: 1fr; max-height: min(62vh, 510px); }
      .network-list { max-height: 145px; border-right: 0; border-bottom: 1px solid var(--border); }
      .inspector-detail { min-height: 145px; }
    }
    @media (max-width: 440px) {
      .topbar-inner, .page-shell { width: calc(100% - 24px); }
      .server-status { padding: 7px 8px; font-size: 8px; }
      .brand-name { font-size: 16px; }
      .page-title-main { gap: 10px; }
      .heading-icon { width: 39px; height: 39px; flex-basis: 39px; }
      .metrics { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 6px; }
      .stat-card { min-width: 0; min-height: 64px; padding: 9px; }
      .stat-card strong { font-size: 16px; }
      .stat-card span { font-size: 8px; }
      .toolbar-card { padding: 10px; }
      .toolbar-right { flex-wrap: wrap; }
      .toolbar-right .button { flex: 1 1 44%; }
      .records-count { font-size: 8px; }
      .catalog-heading { padding: 14px 12px; }
      .network-trigger { right: 11px; bottom: 10px; }
      .network-panel { right: 8px; bottom: 57px; width: calc(100vw - 16px); }
      .modal-fields { grid-template-columns: 1fr; }
      .form-field.full { grid-column: auto; }
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
        <a class="brand" href="<?php echo $escape(BASE_URL); ?>" aria-label="Campusly dashboard home">
          <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7.5 12 4l8 3.5v9L12 20l-8-3.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 3.4 7.5-3.4M12 11.5V20" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span>
          <span class="brand-name">Campusly</span>
        </a>
        <span class="product-pill">Practical 13 Engine</span>
      </div>
      <span class="server-status" id="server-status"><span class="live-dot" aria-hidden="true"></span><span id="server-status-text">JSON API: /api/practical13.php (checking)</span></span>
    </div>
  </header>

  <main class="page-shell">
    <nav class="breadcrumbs" aria-label="Breadcrumb">
      <a href="<?php echo $escape(BASE_URL); ?>">Campusly Home</a>
      <span class="breadcrumb-separator" aria-hidden="true">/</span><span>Dashboard</span>
      <span class="breadcrumb-separator" aria-hidden="true">/</span><span aria-current="page">Practical 13: Asynchronous AJAX/Fetch-Based CRUD</span>
    </nav>

    <section class="page-title-row" aria-labelledby="page-title">
      <div class="page-title-main">
        <span class="heading-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="m13.2 2.8-8 10h6l-.5 8.4 8.1-11h-6.1l.5-7.4Z" fill="currentColor" stroke="currentColor" stroke-linejoin="round"/></svg></span>
        <div>
          <p class="eyebrow">Asynchronous practical · student records</p>
          <h1 id="page-title">Asynchronous Student Management System</h1>
          <p class="page-description">Explore a responsive student catalog powered by asynchronous Fetch requests. Search, filter, and try CRUD interactions while watching request metadata update live in the inspector.</p>
        </div>
      </div>
      <div class="metrics" aria-label="Student record metrics">
        <div class="stat-card"><strong id="total-metric">24</strong><span>Total Records</span></div>
        <div class="stat-card"><strong id="active-metric">22</strong><span>Active Students</span></div>
        <div class="stat-card"><strong>5 ms</strong><span>Fetch Latency</span></div>
      </div>
    </section>

    <section class="surface-card toolbar-card" aria-label="Student record filters and actions">
      <div class="toolbar">
        <div class="toolbar-left">
          <label class="search-box" for="student-search">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.8"/><path d="m16 16 4.2 4.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            <input id="student-search" type="search" placeholder="Search name, email, or student ID..." autocomplete="off" aria-label="Search students">
            <span class="debounce-pill"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m13.2 2.8-8 10h6l-.5 8.4 8.1-11h-6.1l.5-7.4Z" fill="currentColor"/></svg>300ms Debounce</span>
          </label>
          <label><span hidden>Filter by department</span><select class="filter-select" id="department-filter" aria-label="Filter by department"><option value="">All Departments</option><option value="CSE">CSE</option><option value="CE">CE</option><option value="IT">IT</option></select></label>
          <label><span hidden>Filter by status</span><select class="filter-select" id="status-filter" aria-label="Filter by status"><option value="">All Statuses</option><option value="active">Active</option><option value="inactive">Inactive</option></select></label>
        </div>
        <div class="toolbar-right">
          <button class="button button-primary" id="add-student-button" type="button"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></svg>Add New Student</button>
          <button class="button" id="refresh-button" type="button"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20 7v5h-5M4 17v-5h5m-4.1-3a8 8 0 0 1 13.5-2L20 12M4 12l1.6 5a8 8 0 0 0 13.5-2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>Refresh</button>
          <button class="button button-blue-soft" id="network-toggle" type="button" aria-expanded="false" aria-controls="network-panel"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 5h16v14H4zM4 9h16M8 7h.01M11 7h.01m-3 5h4m-4 3h8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Network Inspector</button>
        </div>
      </div>
    </section>

    <section class="surface-card catalog" aria-labelledby="catalog-title">
      <div class="catalog-heading">
        <div><h2 id="catalog-title">Student Records Catalog</h2><p>Browse and manage the Practical 13 demo dataset.</p></div>
        <span class="records-count"><span class="count-dot" aria-hidden="true"></span><span id="records-count">Loading records…</span></span>
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr><th scope="col">Student Full Name</th><th scope="col">University Email</th><th scope="col">Department</th><th scope="col">Status</th><th scope="col">Actions</th></tr></thead>
          <tbody id="student-rows"></tbody>
        </table>
        <div class="empty-state" id="empty-state" hidden><strong>No students match these filters</strong><span>Try a different search term or clear a filter.</span></div>
      </div>
      <div class="catalog-footer"><span>Showing <strong id="showing-count">0</strong> demo records</span><span class="system-pill">JSON · Fetch API · 300ms debounce</span></div>
    </section>

    <p class="demo-notice"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 11v5m0-8h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg><span><strong>Interactive demo:</strong> These are fictional sample records. Create, edit, and delete operations are simulated in this browser and reset when the page is reloaded; no real student accounts are changed.</span></p>
  </main>

  <dialog class="modal" id="student-modal" aria-labelledby="modal-title">
    <form class="modal-form" id="student-form" novalidate>
      <div class="modal-header">
        <div><h2 id="modal-title">Add student</h2><p>Enter student details for this demo session.</p></div>
        <button class="modal-close" id="modal-close" type="button" aria-label="Close dialog">×</button>
      </div>
      <div class="modal-fields">
        <div class="form-field full"><label for="student-name">Full Name</label><input class="field-control" id="student-name" name="name" type="text" autocomplete="name" maxlength="100" aria-describedby="student-name-error"><span class="field-error" id="student-name-error">Full Name is required</span></div>
        <div class="form-field full"><label for="student-email">University Email</label><input class="field-control" id="student-email" name="email" type="email" autocomplete="email" maxlength="254" aria-describedby="student-email-error"><span class="field-error" id="student-email-error">Invalid email format</span></div>
        <div class="form-field"><label for="student-department">Department</label><select class="field-control" id="student-department" name="department"><option value="CSE">CSE</option><option value="CE">CE</option><option value="IT">IT</option></select></div>
        <div class="form-field"><label for="student-status">Status</label><select class="field-control" id="student-status" name="status"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
      </div>
      <p class="modal-status" id="modal-status" role="status" aria-live="polite"></p>
      <div class="modal-actions"><button class="button" id="cancel-modal" type="button">Cancel</button><button class="button button-primary" id="save-student-button" type="submit">Add Student</button></div>
    </form>
  </dialog>

  <button class="network-trigger" id="network-trigger" type="button" aria-expanded="false" aria-controls="network-panel"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 5h16v14H4zM4 9h16M8 7h.01M11 7h.01m-3 5h4m-4 3h8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Network inspector<span class="live-dot" aria-hidden="true"></span></button>
  <section class="network-panel" id="network-panel" aria-label="Network inspector" hidden>
    <div class="inspector-heading"><div><strong>Network</strong><span>Practical 13 · Fetch requests</span></div><button class="inspector-close" id="inspector-close" type="button" aria-label="Close network inspector">×</button></div>
    <div class="network-layout">
      <div class="network-list" id="network-list" role="listbox" aria-label="Request log"></div>
      <div class="inspector-detail">
        <div class="inspector-tabs" role="tablist" aria-label="Request details">
          <button class="inspector-tab" type="button" role="tab" data-tab="headers" aria-selected="true">Headers</button>
          <button class="inspector-tab" type="button" role="tab" data-tab="payload" aria-selected="false">Payload</button>
          <button class="inspector-tab" type="button" role="tab" data-tab="response" aria-selected="false">JSON Response</button>
        </div>
        <pre class="detail-content" id="detail-content" role="tabpanel"></pre>
      </div>
    </div>
  </section>
  <div class="toast" id="toast" role="status" aria-live="polite"></div>

  <script>
    (() => {
      'use strict';

      const apiUrl = <?php echo json_encode(BASE_URL . 'api/practical13.php'); ?>;
      const rowsElement = document.getElementById('student-rows');
      const searchInput = document.getElementById('student-search');
      const departmentFilter = document.getElementById('department-filter');
      const statusFilter = document.getElementById('status-filter');
      const recordsCount = document.getElementById('records-count');
      const showingCount = document.getElementById('showing-count');
      const emptyState = document.getElementById('empty-state');
      const totalMetric = document.getElementById('total-metric');
      const activeMetric = document.getElementById('active-metric');
      const modal = document.getElementById('student-modal');
      const form = document.getElementById('student-form');
      const modalTitle = document.getElementById('modal-title');
      const modalStatus = document.getElementById('modal-status');
      const saveButton = document.getElementById('save-student-button');
      const nameInput = document.getElementById('student-name');
      const emailInput = document.getElementById('student-email');
      const networkPanel = document.getElementById('network-panel');
      const networkToggle = document.getElementById('network-toggle');
      const networkTrigger = document.getElementById('network-trigger');
      const networkList = document.getElementById('network-list');
      const detailContent = document.getElementById('detail-content');
      const serverStatusText = document.getElementById('server-status-text');
      const toast = document.getElementById('toast');

      let students = [];
      let activeEditId = null;
      let requestLog = [];
      let selectedRequestId = null;
      let selectedTab = 'headers';
      let debounceTimer = 0;
      let toastTimer = 0;
      let requestSequence = 0;

      const escapeHtml = (value) => String(value).replace(/[&<>"']/g, (character) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
      })[character]);
      const initials = (name) => name.trim().split(/\s+/).slice(0, 2).map((part) => part.charAt(0)).join('').toUpperCase();
      const delay = (milliseconds) => new Promise((resolve) => window.setTimeout(resolve, milliseconds));
      const getVisibleStudents = () => {
        const query = searchInput.value.trim().toLocaleLowerCase();
        return students.filter((student) => {
          const matchesQuery = !query || [student.name, student.email, student.department, student.id].some((value) => value.toLocaleLowerCase().includes(query));
          const matchesDepartment = !departmentFilter.value || student.department === departmentFilter.value;
          const matchesStatus = !statusFilter.value || student.status === statusFilter.value;
          return matchesQuery && matchesDepartment && matchesStatus;
        });
      };

      const buildRequestDetails = (entry, tab) => {
        if (!entry) return 'Select a request to inspect its details.';
        if (tab === 'payload') return JSON.stringify(entry.payload ?? { note: 'No request payload.' }, null, 2);
        if (tab === 'response') return JSON.stringify(entry.response ?? { success: true }, null, 2);
        return JSON.stringify({
          'Request URL': entry.url,
          'Request Method': entry.method,
          'Status Code': `${entry.status} ${entry.statusText}`,
          Type: 'fetch',
          'Content-Type': 'application/json',
          'Request duration': `${entry.duration} ms`
        }, null, 2);
      };

      const renderNetwork = () => {
        networkList.replaceChildren();
        requestLog.forEach((entry) => {
          const item = document.createElement('button');
          item.type = 'button';
          item.className = 'network-item';
          item.setAttribute('role', 'option');
          item.setAttribute('aria-selected', String(entry.id === selectedRequestId));
          const method = document.createElement('span');
          method.className = `method-badge ${entry.method.toLowerCase()}`;
          method.textContent = entry.method;
          const name = document.createElement('span');
          name.className = 'network-name';
          name.textContent = entry.name;
          name.title = entry.name;
          const status = document.createElement('span');
          status.className = `network-status${entry.status >= 400 ? ' error' : ''}`;
          status.textContent = `${entry.status} ${entry.statusText}`;
          const time = document.createElement('span');
          time.className = 'network-time';
          time.textContent = `${entry.duration} ms`;
          item.append(method, name, status, time);
          item.addEventListener('click', () => {
            selectedRequestId = entry.id;
            renderNetwork();
          });
          networkList.append(item);
        });

        const selected = requestLog.find((entry) => entry.id === selectedRequestId) ?? requestLog[0];
        if (selected && selectedRequestId === null) selectedRequestId = selected.id;
        detailContent.textContent = buildRequestDetails(selected, selectedTab);
        networkList.scrollTop = networkList.scrollHeight;
      };

      const addRequestLog = (entry) => {
        requestLog.push({ ...entry, id: ++requestSequence });
        if (requestLog.length > 40) requestLog = requestLog.slice(-40);
        if (requestLog.length === 1) selectedRequestId = requestLog[0].id;
        renderNetwork();
      };

      const setInspectorOpen = (open) => {
        networkPanel.hidden = !open;
        networkToggle.setAttribute('aria-expanded', String(open));
        networkTrigger.setAttribute('aria-expanded', String(open));
        if (open) document.getElementById('inspector-close').focus();
        else networkTrigger.focus();
      };

      const simulatedRequest = async ({ method, name, payload = null, response }) => {
        const startedAt = performance.now();
        await delay(5);
        const duration = Math.max(1, Math.round(performance.now() - startedAt));
        const result = response ?? { success: true, message: 'Demo request completed.' };
        addRequestLog({
          method,
          name,
          url: `${apiUrl}${method === 'GET' ? '?search=' + encodeURIComponent(searchInput.value.trim()) : ''}`,
          status: 200,
          statusText: 'OK',
          duration,
          payload,
          response: result
        });
        return { ok: true, status: 200, json: async () => result };
      };

      const updateMetrics = () => {
        totalMetric.textContent = String(students.length);
        activeMetric.textContent = String(students.filter((student) => student.status === 'active').length);
      };

      const renderRows = () => {
        const visibleStudents = getVisibleStudents();
        rowsElement.replaceChildren();
        visibleStudents.forEach((student) => {
          const row = document.createElement('tr');
          const nameCell = document.createElement('td');
          const studentInfo = document.createElement('div');
          studentInfo.className = 'student-cell';
          const avatar = document.createElement('span');
          avatar.className = 'avatar';
          avatar.textContent = initials(student.name);
          const nameWrap = document.createElement('span');
          const name = document.createElement('span');
          name.className = 'student-name';
          name.textContent = student.name;
          const id = document.createElement('span');
          id.className = 'student-id';
          id.textContent = student.id;
          nameWrap.append(name, id);
          studentInfo.append(avatar, nameWrap);
          nameCell.append(studentInfo);

          const emailCell = document.createElement('td');
          emailCell.className = 'email-cell';
          emailCell.textContent = student.email;

          const departmentCell = document.createElement('td');
          const department = document.createElement('span');
          department.className = 'department-badge';
          department.dataset.department = student.department;
          department.textContent = student.department;
          departmentCell.append(department);

          const statusCell = document.createElement('td');
          const status = document.createElement('span');
          status.className = `status-badge${student.status === 'inactive' ? ' inactive' : ''}`;
          const statusDot = document.createElement('span');
          statusDot.className = 'status-indicator';
          statusDot.setAttribute('aria-hidden', 'true');
          status.append(statusDot, document.createTextNode(student.status === 'active' ? 'Active' : 'Inactive'));
          statusCell.append(status);

          const actionsCell = document.createElement('td');
          const actions = document.createElement('div');
          actions.className = 'row-actions';
          const edit = document.createElement('button');
          edit.type = 'button';
          edit.className = 'action-button action-edit';
          edit.setAttribute('aria-label', `Edit ${student.name}`);
          edit.title = `Edit ${student.name}`;
          edit.innerHTML = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m14 5 5 5M4 20l4.2-.8L19 8.4a2.1 2.1 0 0 0-3-3L5.2 16.2 4 20Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>';
          edit.addEventListener('click', () => openModal(student));
          const remove = document.createElement('button');
          remove.type = 'button';
          remove.className = 'action-button action-delete';
          remove.setAttribute('aria-label', `Delete ${student.name}`);
          remove.title = `Delete ${student.name}`;
          remove.innerHTML = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16m-10 4v6m4-6v6M6 7l1 14h10l1-14M9 7V4h6v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>';
          remove.addEventListener('click', () => deleteStudent(student));
          actions.append(edit, remove);
          actionsCell.append(actions);
          row.append(nameCell, emailCell, departmentCell, statusCell, actionsCell);
          rowsElement.append(row);
        });

        const count = visibleStudents.length;
        recordsCount.textContent = `${count} ${count === 1 ? 'Record' : 'Records'} Loaded`;
        showingCount.textContent = String(count);
        emptyState.hidden = count > 0;
        rowsElement.closest('table').hidden = count === 0;
      };

      const setLoading = (loading) => {
        document.getElementById('refresh-button').disabled = loading;
        document.getElementById('add-student-button').disabled = loading;
        rowsElement.setAttribute('aria-busy', String(loading));
      };

      const showToast = (message, isError = false) => {
        window.clearTimeout(toastTimer);
        toast.textContent = message;
        toast.classList.toggle('error', isError);
        toast.classList.add('visible');
        toastTimer = window.setTimeout(() => toast.classList.remove('visible'), 2600);
      };

      const renderFailure = (message) => {
        serverStatusText.textContent = 'JSON API: /api/practical13.php (unavailable)';
        document.querySelector('#server-status .live-dot').style.background = '#ef4444';
        recordsCount.textContent = 'Unable to load records';
        emptyState.hidden = false;
        emptyState.innerHTML = `<strong>Student records could not be loaded</strong><span>${escapeHtml(message)}</span>`;
        rowsElement.closest('table').hidden = true;
      };

      const loadStudents = async () => {
        setLoading(true);
        try {
          const startedAt = performance.now();
          const response = await fetch(apiUrl, { headers: { Accept: 'application/json' }, cache: 'no-store' });
          const result = await response.json();
          const duration = Math.max(1, Math.round(performance.now() - startedAt));
          if (!response.ok || result.success !== true || !Array.isArray(result.data)) {
            throw new Error(result.message || `Student API returned ${response.status}.`);
          }
          students = result.data.map((student) => ({ ...student }));
          serverStatusText.textContent = 'JSON API: /api/practical13.php (200 OK)';
          addRequestLog({
            method: 'GET',
            name: '/api/practical13.php',
            url: apiUrl,
            status: response.status,
            statusText: 'OK',
            duration,
            payload: { note: 'No request payload.' },
            response: { success: true, total: students.length, active: students.filter((student) => student.status === 'active').length }
          });
          updateMetrics();
          renderRows();
        } catch (error) {
          renderFailure(error.message || 'Please refresh to try again.');
          showToast(error.message || 'Unable to load student records.', true);
        } finally {
          setLoading(false);
        }
      };

      const performSearch = async () => {
        await simulatedRequest({
          method: 'GET',
          name: '/api/practical13.php?search=' + searchInput.value.trim(),
          payload: { search: searchInput.value.trim(), department: departmentFilter.value || 'all', status: statusFilter.value || 'all' },
          response: { success: true, total: getVisibleStudents().length, data: getVisibleStudents() }
        });
        renderRows();
      };

      const validateField = (input) => {
        const error = document.getElementById(`${input.id}-error`);
        let message = '';
        if (input.name === 'name' && !input.value.trim()) message = 'Full Name is required';
        if (input.name === 'email' && (!input.value.trim() || !input.validity.valid)) message = 'Invalid email format';
        input.classList.toggle('invalid', Boolean(message));
        input.setAttribute('aria-invalid', String(Boolean(message)));
        error.classList.toggle('visible', Boolean(message));
        return message === '';
      };

      const openModal = (student = null) => {
        activeEditId = student?.id ?? null;
        modalTitle.textContent = student ? 'Edit student' : 'Add new student';
        saveButton.textContent = student ? 'Save Changes' : 'Add Student';
        modalStatus.textContent = '';
        form.reset();
        document.querySelectorAll('.field-control').forEach((field) => {
          field.classList.remove('invalid');
          field.setAttribute('aria-invalid', 'false');
        });
        document.querySelectorAll('.field-error').forEach((error) => error.classList.remove('visible'));
        if (student) {
          nameInput.value = student.name;
          emailInput.value = student.email;
          document.getElementById('student-department').value = student.department;
          document.getElementById('student-status').value = student.status;
        }
        modal.showModal();
        nameInput.focus();
      };

      const deleteStudent = async (student) => {
        const response = await simulatedRequest({
          method: 'DELETE',
          name: `/api/practical13.php/${student.id}`,
          payload: { id: student.id },
          response: { success: true, message: 'Demo student removed.', id: student.id }
        });
        if (!response.ok) {
          showToast('The demo record could not be deleted.', true);
          return;
        }
        students = students.filter((record) => record.id !== student.id);
        updateMetrics();
        renderRows();
        showToast(`${student.name} was removed from this demo session.`);
      };

      document.getElementById('add-student-button').addEventListener('click', () => openModal());
      document.getElementById('refresh-button').addEventListener('click', async () => {
        setLoading(true);
        try {
          const startedAt = performance.now();
          const response = await fetch(apiUrl, { headers: { Accept: 'application/json' }, cache: 'no-store' });
          const result = await response.json();
          const duration = Math.max(1, Math.round(performance.now() - startedAt));
          if (!response.ok || result.success !== true || !Array.isArray(result.data)) throw new Error(result.message || 'Refresh failed.');
          students = result.data.map((student) => ({ ...student }));
          addRequestLog({ method: 'GET', name: '/api/practical13.php', url: apiUrl, status: response.status, statusText: 'OK', duration, payload: { note: 'No request payload.' }, response: { success: true, total: students.length } });
          updateMetrics();
          renderRows();
          showToast('Student records refreshed.');
        } catch (error) {
          showToast(error.message || 'Unable to refresh records.', true);
        } finally {
          setLoading(false);
        }
      });

      searchInput.addEventListener('input', () => {
        window.clearTimeout(debounceTimer);
        debounceTimer = window.setTimeout(performSearch, 300);
      });
      departmentFilter.addEventListener('change', performSearch);
      statusFilter.addEventListener('change', performSearch);

      [nameInput, emailInput].forEach((input) => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => {
          if (input.getAttribute('aria-invalid') === 'true') validateField(input);
        });
      });

      form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const validName = validateField(nameInput);
        const validEmail = validateField(emailInput);
        if (!validName || !validEmail) {
          modalStatus.textContent = 'Please correct the highlighted fields.';
          (!validName ? nameInput : emailInput).focus();
          return;
        }

        const current = activeEditId ? students.find((student) => student.id === activeEditId) : null;
        const student = {
          id: current?.id ?? `STU-DEMO-${Date.now()}`,
          name: nameInput.value.trim(),
          email: emailInput.value.trim().toLowerCase(),
          department: document.getElementById('student-department').value,
          status: document.getElementById('student-status').value
        };
        const method = activeEditId ? 'PUT' : 'POST';
        const response = await simulatedRequest({
          method,
          name: activeEditId ? `/api/practical13.php/${student.id}` : '/api/practical13.php',
          payload: student,
          response: { success: true, message: activeEditId ? 'Demo student updated.' : 'Demo student added.', student }
        });

        if (!response.ok) {
          modalStatus.textContent = 'The student record could not be saved.';
          return;
        }
        if (activeEditId) students = students.map((record) => record.id === activeEditId ? student : record);
        else students = [student, ...students];
        updateMetrics();
        renderRows();
        modal.close();
        showToast(activeEditId ? 'Student changes saved for this session.' : 'Student added to this demo session.');
      });

      document.getElementById('modal-close').addEventListener('click', () => modal.close());
      document.getElementById('cancel-modal').addEventListener('click', () => modal.close());
      document.getElementById('network-toggle').addEventListener('click', () => setInspectorOpen(networkPanel.hidden));
      networkTrigger.addEventListener('click', () => setInspectorOpen(networkPanel.hidden));
      document.getElementById('inspector-close').addEventListener('click', () => setInspectorOpen(false));
      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !networkPanel.hidden && !modal.open) setInspectorOpen(false);
      });
      document.querySelectorAll('.inspector-tab').forEach((tab) => {
        tab.addEventListener('click', () => {
          selectedTab = tab.dataset.tab;
          document.querySelectorAll('.inspector-tab').forEach((item) => item.setAttribute('aria-selected', String(item === tab)));
          renderNetwork();
        });
      });

      loadStudents();
    })();
  </script>
</body>
</html>
