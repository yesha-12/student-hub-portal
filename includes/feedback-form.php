<dialog class="feedback-dialog" id="feedback-dialog" aria-labelledby="feedback-title">
  <form id="feedback-form" class="feedback-form" novalidate>
    <button class="dialog-close" type="button" id="dialog-close" aria-label="Close feedback form">×</button>
    <p class="eyebrow">Your voice matters</p>
    <h2 id="feedback-title">Share your feedback</h2>
    <p class="dialog-intro">A little context helps us make Campusly more useful for students.</p>
    <div class="field-grid">
      <label>Your name<input name="name" type="text" autocomplete="name" required maxlength="100" placeholder="Your name"></label>
      <label>Email address<input name="email" type="email" autocomplete="email" required maxlength="254" placeholder="you@campus.edu"></label>
      <label class="full">How would you rate Campusly?
        <select name="rating" required>
          <option value="">Choose a rating</option>
          <option value="great">Great</option>
          <option value="good">Good</option>
          <option value="okay">Okay</option>
          <option value="poor">Needs improvement</option>
        </select>
      </label>
      <label class="full">What should we know?<textarea name="message" required maxlength="2000" rows="4" placeholder="Share a suggestion or tell us what you like..."></textarea></label>
    </div>
    <p class="form-status" id="feedback-status" role="status" aria-live="polite"></p>
    <button class="button primary submit-button" type="submit">Send feedback</button>
  </form>
</dialog>
<style>
  .feedback-dialog{width:min(540px,calc(100% - 28px));max-height:min(90vh,760px);padding:0;border:1px solid #e2e8f0;border-radius:18px;color:#0f172a;background:#fff;box-shadow:0 24px 70px rgba(15,23,42,.25)}
  .feedback-dialog::backdrop{background:rgba(15,23,42,.42);backdrop-filter:blur(4px)}
  .feedback-form{position:relative;padding:26px}.dialog-close{position:absolute;top:15px;right:15px;width:30px;height:30px;border:0;border-radius:9px;color:#64748b;background:#f1f5f9;font-size:20px}
  .feedback-form h2{margin:0;font-size:20px;letter-spacing:-.6px}.dialog-intro{margin:7px 0 18px;color:#64748b;font-size:11px;line-height:1.7}
  .field-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.field-grid label{display:grid;gap:7px;color:#334155;font-size:10px;font-weight:700}.field-grid .full{grid-column:1/-1}
  .field-grid input,.field-grid select,.field-grid textarea{width:100%;padding:10px 11px;border:1px solid #e2e8f0;border-radius:10px;outline:none;color:#0f172a;background:#fff;font-family:inherit;font-size:11px}
  .field-grid input:focus,.field-grid select:focus,.field-grid textarea:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.13)}
  .field-grid input:invalid:not(:placeholder-shown),.field-grid textarea:invalid:not(:placeholder-shown),.field-grid select:invalid:not(:focus){border-color:#fda4af;background:#fff5f5}
  .form-status{display:none;margin:12px 0 0;padding:10px;border-radius:10px;color:#047857;background:#ecfdf5;font-size:10px;line-height:1.5}.form-status.visible{display:block}.form-status.error{color:#dc2626;background:#fff5f5}
  .submit-button{width:100%;margin-top:15px}
  @media(max-width:460px){.feedback-form{padding:22px 18px}.field-grid{grid-template-columns:1fr}.field-grid .full{grid-column:auto}}
</style>
<script>
(() => {
  const dialog = document.getElementById('feedback-dialog');
  const form = document.getElementById('feedback-form');
  const status = document.getElementById('feedback-status');
  document.addEventListener('click', (event) => {
    if (event.target.closest('[data-dialog-open="feedback-dialog"]')) {
      event.preventDefault();
      dialog.showModal();
    }
  });
  document.getElementById('dialog-close').addEventListener('click', () => dialog.close());
  dialog.addEventListener('click', (event) => {
    if (event.target === dialog) dialog.close();
  });
  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    if (!form.reportValidity()) return;
    const button = form.querySelector('[type="submit"]');
    button.disabled = true;
    status.classList.remove('visible', 'error');
    try {
      const payload = Object.fromEntries(new FormData(form).entries());
      payload.action = 'feedback';
      const response = await fetch(<?php echo json_encode(BASE_URL . 'process.php'); ?>, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(payload)
      });
      const result = await response.json();
      if (!response.ok || result.success !== true) throw new Error(result.message || 'Feedback could not be sent.');
      status.textContent = 'Thanks for sharing. Your feedback has been received.';
      status.classList.add('visible');
      form.reset();
    } catch (error) {
      status.textContent = error.message || 'Feedback could not be sent. Please try again.';
      status.classList.add('visible', 'error');
    } finally {
      button.disabled = false;
    }
  });
})();
</script>
