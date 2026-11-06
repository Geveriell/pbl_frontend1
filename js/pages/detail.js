(function () {
  const f = document.getElementById('detForm');
  const csrf = document.querySelector('meta[name="csrf-token"]').content;
  const base = +f.dataset.base;
  const $ = id => document.getElementById(id);
  const note = $('note');
  const rp = n => 'Rp ' + n.toLocaleString('id-ID');

  function render() {
    let extra = 0;
    f.querySelectorAll('input:checked').forEach(i => { extra += +i.dataset.p || 0; });
    $('btnTotal').textContent = rp(base + extra);
    $('noteCount').textContent = note.value.length + '/100';
  }

  f.addEventListener('change', render);
  note.addEventListener('input', render);

  document.querySelectorAll('[data-quick]').forEach(b => b.addEventListener('click', () => {
    const t = b.dataset.quick;
    if (note.value.includes(t)) return;
    const next = note.value ? note.value.replace(/[,\s]+$/, '') + ', ' + t : t;
    note.value = next.slice(0, 100); render();
  }));

  const heart = $('btnHeart');
  heart.addEventListener('click', () => heart.setAttribute('aria-pressed', heart.getAttribute('aria-pressed') !== 'true'));

  $('btnSave').addEventListener('click', async e => {
    const btn = e.currentTarget; btn.disabled = true;
    try {
      const res = await fetch(API_CART, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf },
        body: JSON.stringify({
          id: +f.dataset.id, line: f.dataset.line, action: f.dataset.line ? 'update' : 'add',
          r: +(f.querySelector('input[name="r"]:checked') || { value: 0 }).value,
          a: [...f.querySelectorAll('input[name="a"]:checked')].map(i => +i.value),
          note: note.value
        })
      });
      const d = await res.json();
      if (!d.ok) throw new Error(d.error || 'Gagal');
      location.replace(f.dataset.back);
    } catch (err) {
      toast('Gagal menyimpan: ' + err.message); btn.disabled = false;
    }
  });
  render();
})();
