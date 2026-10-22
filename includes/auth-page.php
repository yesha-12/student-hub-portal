<?php
declare(strict_types=1);

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
  <title><?php echo $escape($authTitle); ?> | Campusly</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root{color-scheme:light;--blue:#0066ff;--navy:#0f172a;--muted:#64748b;--border:#e2e8f0;--page:#f8fafc;font-family:'Plus Jakarta Sans',Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;color:var(--navy);background:var(--page);font-synthesis:none;text-rendering:optimizeLegibility}
    *{box-sizing:border-box}body{min-width:320px;min-height:100vh;margin:0;background-color:var(--page);background-image:linear-gradient(to right,rgba(226,232,240,.5) 1px,transparent 1px),linear-gradient(to bottom,rgba(226,232,240,.5) 1px,transparent 1px);background-size:24px 24px}
    a{color:inherit}.topbar{border-bottom:1px solid rgba(226,232,240,.88);background:rgba(255,255,255,.92);backdrop-filter:blur(14px)}.topbar-inner{width:min(1080px,calc(100% - 48px));min-height:70px;display:flex;align-items:center;justify-content:space-between;gap:18px;margin:auto}
    .brand{display:flex;align-items:center;gap:10px;text-decoration:none}.brand-mark{width:35px;height:35px;display:grid;place-items:center;border-radius:11px;color:#fff;background:var(--blue)}.brand-mark svg{width:20px;height:20px}.brand-name{font-size:18px;font-weight:800;letter-spacing:-.6px}.nav{display:flex;align-items:center;gap:18px}.nav a{color:#475569;font-size:11px;font-weight:600;text-decoration:none}.nav a:hover{color:var(--blue)}
    .page{width:min(1080px,calc(100% - 48px));margin:0 auto;padding:35px 0 55px}.crumbs{display:flex;gap:8px;margin-bottom:18px;color:#94a3b8;font-size:11px}.crumbs a{color:#64748b;text-decoration:none}.auth-card{width:min(100%,650px);margin:auto;padding:27px;border:1px solid #e2e8f0;border-radius:19px;background:#fff;box-shadow:0 4px 15px rgba(15,23,42,.045)}
    .eyebrow{margin:0 0 6px;color:var(--blue);font-size:9px;font-weight:800;letter-spacing:1.4px;text-transform:uppercase}h1{margin:0;font-size:25px;letter-spacing:-.8px}.subtitle{margin:7px 0 20px;color:var(--muted);font-size:11px;line-height:1.7}
    .fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.fields label{display:grid;gap:7px;color:#334155;font-size:10px;font-weight:700}.fields label.full{grid-column:1/-1}
    .fields input,.fields select{width:100%;height:41px;padding:0 11px;border:1px solid #e2e8f0;border-radius:10px;outline:none;color:#0f172a;background:#fff;font-family:inherit;font-size:11px;transition:border-color .18s ease,box-shadow .18s ease,background .18s ease}
    .fields input::placeholder{color:#94a3b8}.fields input:focus,.fields select:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.13)}.fields input.invalid,.fields select.invalid{border-color:#fda4af;background:#fff5f5}.field-error{display:none;color:#dc2626;font-size:9px;font-weight:500;line-height:1.5}.field-error.visible{display:block}
    .submit{width:100%;min-height:42px;margin-top:19px;border:0;border-radius:11px;color:#fff;background:var(--blue);font-family:inherit;font-size:11px;font-weight:700;cursor:pointer;transition:background .18s ease,transform .18s ease}.submit:hover{background:#0052cc}.submit:active{transform:scale(.99)}.submit:disabled{cursor:wait;opacity:.7}
    .form-status{display:none;margin:14px 0 0;padding:11px 12px;border:1px solid #a7f3d0;border-radius:11px;color:#047857;background:#ecfdf5;font-size:10px;line-height:1.6}.form-status.visible{display:block}.form-status.error{border-color:#fecdd3;color:#dc2626;background:#fff5f5}.form-status a{font-weight:700}
    .auth-foot{margin:18px 0 0;color:#64748b;font-size:10px;text-align:center}.auth-foot a{color:var(--blue);font-weight:700;text-decoration:none}.privacy{display:flex;gap:8px;align-items:flex-start;margin-top:17px;padding:11px;border:1px solid #e2e8f0;border-radius:11px;color:#64748b;background:#f8fafc;font-size:9px;line-height:1.6}
    @media(max-width:640px){.topbar-inner,.page{width:min(100% - 32px,560px)}.topbar-inner{min-height:64px}.nav{gap:12px}.nav a:nth-child(-n+2){display:none}.page{padding-top:22px}.auth-card{padding:22px}}
    @media(max-width:440px){.topbar-inner,.page{width:calc(100% - 28px)}.fields{grid-template-columns:1fr}.fields label.full{grid-column:auto}.auth-card{padding:19px}}
  </style>
</head>
<body>
  <header class="topbar"><div class="topbar-inner">
    <a class="brand" href="<?php echo $escape(BASE_URL); ?>"><span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7.5 12 4l8 3.5v9L12 20l-8-3.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 3.4 7.5-3.4M12 11.5V20" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span><span class="brand-name">Campusly</span></a>
    <nav class="nav" aria-label="Main navigation"><a href="<?php echo $escape(BASE_URL . 'events.php'); ?>">Events</a><a href="<?php echo $escape(BASE_URL . 'about.php'); ?>">About</a><a href="<?php echo $escape(BASE_URL . 'faq.php'); ?>">Help center</a><a href="<?php echo $escape(BASE_URL . 'contact.php'); ?>">Contact</a></nav>
  </div></header>
  <main class="page">
    <nav class="crumbs" aria-label="Breadcrumb"><a href="<?php echo $escape(BASE_URL); ?>">Home</a><span aria-hidden="true">/</span><span><?php echo $authMode === 'register' ? 'Create account' : 'Sign in'; ?></span></nav>
    <section class="auth-card" aria-labelledby="auth-title">
      <p class="eyebrow">Campusly student hub</p>
      <h1 id="auth-title"><?php echo $escape($authTitle); ?></h1>
      <p class="subtitle"><?php echo $escape($authSubtitle); ?></p>
      <form id="auth-form" data-action="<?php echo $escape($authMode); ?>" novalidate>
        <div class="fields">
          <?php foreach ($authFields as $field): ?>
            <label class="<?php echo !empty($field['full']) ? 'full' : ''; ?>" for="field-<?php echo $escape($field['name']); ?>">
              <?php echo $escape($field['label']); ?>
              <?php if (($field['type'] ?? '') === 'select'): ?>
                <select id="field-<?php echo $escape($field['name']); ?>" name="<?php echo $escape($field['name']); ?>" required>
                  <?php foreach ($field['options'] as $value => $label): ?><option value="<?php echo $escape((string) $value); ?>"><?php echo $escape((string) $label); ?></option><?php endforeach; ?>
                </select>
              <?php else: ?>
                <input id="field-<?php echo $escape($field['name']); ?>" name="<?php echo $escape($field['name']); ?>" type="<?php echo $escape($field['type']); ?>" autocomplete="<?php echo $escape($field['autocomplete'] ?? 'off'); ?>" placeholder="<?php echo $escape($field['placeholder'] ?? ''); ?>" <?php echo !empty($field['required']) ? 'required' : ''; ?> <?php echo $field['name'] === 'password' && $authMode === 'register' ? 'minlength="6"' : ''; ?> maxlength="<?php echo $field['name'] === 'password' ? '128' : '254'; ?>">
              <?php endif; ?>
              <span class="field-error" aria-live="polite"></span>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="form-status" id="form-status" role="status" aria-live="polite"></div>
        <button class="submit" type="submit"><?php echo $authMode === 'register' ? 'Create account' : 'Sign in'; ?></button>
      </form>
      <p class="auth-foot"><?php if ($authMode === 'register'): ?>Already have an account? <a href="<?php echo $escape(BASE_URL . 'login.php'); ?>">Sign in</a><?php else: ?>New to Campusly? <a href="<?php echo $escape(BASE_URL . 'register.php'); ?>">Create an account</a><?php endif; ?></p>
      <div class="privacy">Your password is protected and stored securely. Never share it in a support message.</div>
    </section>
  </main>
  <script>
  (() => {
    const form = document.getElementById('auth-form');
    const status = document.getElementById('form-status');
    const button = form.querySelector('button[type="submit"]');
    const fields = Array.from(form.querySelectorAll('input, select'));
    const validate = (field) => {
      const error = field.parentElement.querySelector('.field-error');
      let message = '';
      if (!field.value.trim()) message = 'This field is required.';
      else if (!field.validity.valid) message = field.type === 'email' ? 'Enter a valid email address.' : field.type === 'password' ? 'Use at least 6 characters.' : 'Please check this value.';
      if (!message && field.name === 'passwordConfirm' && field.value !== form.elements.password.value) message = 'Passwords do not match.';
      field.classList.toggle('invalid', Boolean(message));
      field.setAttribute('aria-invalid', String(Boolean(message)));
      error.textContent = message;
      error.classList.toggle('visible', Boolean(message));
      return !message;
    };
    fields.forEach((field) => {
      field.addEventListener('blur', () => validate(field));
      field.addEventListener('input', () => {
        if (field.getAttribute('aria-invalid') === 'true') validate(field);
        const confirmation = form.querySelector('[name="passwordConfirm"]');
        if (field.name === 'password' && confirmation && confirmation.value) validate(confirmation);
      });
      field.addEventListener('change', () => validate(field));
    });
    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      if (!fields.map(validate).every(Boolean)) {
        fields.find((field) => field.getAttribute('aria-invalid') === 'true')?.focus();
        status.textContent = 'Please check the highlighted fields and try again.';
        status.classList.add('visible', 'error');
        return;
      }
      status.classList.remove('visible', 'error');
      button.disabled = true;
      button.textContent = form.dataset.action === 'register' ? 'Creating account…' : 'Signing in…';
      try {
        const payload = Object.fromEntries(new FormData(form).entries());
        payload.action = form.dataset.action;
        const response = await fetch(<?php echo json_encode(BASE_URL . 'process.php'); ?>, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
          body: JSON.stringify(payload)
        });
        const result = await response.json();
        if (!response.ok || result.success !== true) throw new Error(result.message || 'The request could not be completed.');
        if (form.dataset.action === 'login') {
          window.location.assign(<?php echo json_encode(BASE_URL); ?> + (result.student.role === 'admin' ? 'admin/dashboard.php' : 'student/dashboard.php'));
          return;
        }
        status.textContent = 'Your account is ready. You can now sign in.';
        status.classList.add('visible');
        form.reset();
        window.setTimeout(() => window.location.assign(<?php echo json_encode(BASE_URL . 'login.php?registered=1'); ?>), 900);
      } catch (error) {
        status.textContent = error.message || 'The request could not be completed. Please try again.';
        status.classList.add('visible', 'error');
      } finally {
        button.disabled = false;
        button.textContent = form.dataset.action === 'register' ? 'Create account' : 'Sign in';
      }
    });
  })();
  </script>
</body>
</html>
