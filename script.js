// prefer server-start time if present, otherwise use client time
const span = document.getElementById('clock-server');
let now = span && span.dataset && span.dataset.ts
  ? new Date(parseInt(span.dataset.ts,10)*1000)
  : new Date();
function tick(){
  now = new Date(now.getTime() + 1000);
  if (span) span.textContent = now.toLocaleString();
}
tick();
setInterval(tick, 1000);