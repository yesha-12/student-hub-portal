<section class="panel" aria-labelledby="schedule-title">
  <h2 id="schedule-title">Sample weekly schedule</h2>
  <p class="panel-intro">Example blocks only — replace these with your official department timetable.</p>
  <div class="schedule-grid">
    <div class="schedule-head">Day</div><div class="schedule-head">9:00 AM</div><div class="schedule-head">11:00 AM</div><div class="schedule-head">2:00 PM</div>
    <div class="schedule-day">Monday</div><div class="schedule-item">Lecture</div><div class="schedule-item">Study block</div><div class="schedule-item">Lab</div>
    <div class="schedule-day">Tuesday</div><div class="schedule-item">Study block</div><div class="schedule-item">Lecture</div><div class="schedule-item">Project time</div>
    <div class="schedule-day">Wednesday</div><div class="schedule-item">Lecture</div><div class="schedule-item">Tutorial</div><div class="schedule-item">Study block</div>
    <div class="schedule-day">Thursday</div><div class="schedule-item">Lab</div><div class="schedule-item">Study block</div><div class="schedule-item">Lecture</div>
    <div class="schedule-day">Friday</div><div class="schedule-item">Tutorial</div><div class="schedule-item">Project time</div><div class="schedule-item">Campus time</div>
  </div>
</section>
<style>
  .schedule-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:7px;margin-top:14px}.schedule-head{padding:9px 8px;border-radius:8px;color:#64748b;background:#f8fafc;font-size:9px;font-weight:700}.schedule-day,.schedule-item{min-height:39px;display:flex;align-items:center;padding:8px;border:1px solid #e2e8f0;border-radius:9px;font-size:9px}.schedule-day{color:#334155;background:#f8fafc;font-weight:700}.schedule-item{color:#475569;background:#fff}
  @media(max-width:520px){.schedule-grid{gap:4px}.schedule-head,.schedule-day,.schedule-item{padding:6px 4px;font-size:8px}}
</style>
