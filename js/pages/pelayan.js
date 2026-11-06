(function () {
  const $ = (s, r) => (r || document).querySelector(s);
  const esc = s => String(s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const rp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
  const mmss = ms => { const s = Math.max(0, Math.floor(ms / 1000)); return String(Math.floor(s / 60)).padStart(2, '0') + ':' + String(s % 60).padStart(2, '0'); };

  const data = JSON.parse($('#plData').textContent);
  const now0 = Date.now();
  const tables = data.tables.map(t => Object.assign(t, { since: now0 - t.detik * 1000 }));
  const antar = data.antar.map(a => Object.assign(a, { since: now0 - a.detik * 1000 }));
  const alerts = data.alerts.map(a => Object.assign(a, { since: now0 - a.detik * 1000 }));
  const orders = data.orders;
  const sum = data.sum;
  const menu = data.menu.map(([id, nama, kat, harga]) => ({ id, nama, kat, harga }));
  let sel = '07', tab = 'Makanan';

  const byNo = no => tables.find(t => t.no === no);
  const ord = no => (orders[no] = orders[no] || { items: {}, note: '' });
  const LABEL = { kosong: 'Kosong', terisi: 'Terisi', makan: 'Makan', antar: 'Siap diantar', bantuan: 'Minta bantuan', terlambat: 'Terlambat' };
  const timed = s => s === 'antar' || s === 'bantuan' || s === 'terlambat';

  function tickClock() {
    $('#plClock').textContent = new Date().toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', hour12: false });
  }

  function renderStats() {
    const c = { kosong: 0, terisi: 0, antar: 0, bantuan: 0 };
    tables.forEach(t => { c[['terisi', 'makan', 'terlambat'].includes(t.status) ? 'terisi' : t.status]++; });
    $('#cKosong').textContent = c.kosong; $('#cTerisi').textContent = c.terisi;
    $('#cAntar').textContent = c.antar; $('#cBantuan').textContent = c.bantuan;
    $('#hAntar').textContent = antar.length;
    const mnt = sum.rataDetik;
    $('#shiftList').innerHTML = [['Meja ditangani', sum.ditangani], ['Pesanan dikirim ke dapur', sum.dikirim], ['Pesanan diantar', sum.diantar], ['Rata-rata waktu antar', mmss(mnt * 1000) + ' mnt']]
      .map(([k, v]) => '<div><dt>' + k + '</dt><dd>' + v + '</dd></div>').join('');
    $('#sBantuan').textContent = sum.bantuan;
  }

  function renderFloor() {
    $('#floor').innerHTML = tables.map(t => {
      const sub = timed(t.status) ? '<span data-since="' + t.since + '">' + mmss(Date.now() - t.since) + '</span>'
        : '<span>' + (t.status === 'kosong' ? t.kursi + ' kursi' : t.tamu + ' tamu') + '</span>';
      return '<button class="pl-t s-' + t.status + (t.no === sel ? ' is-sel' : '') + '" data-no="' + t.no + '"><b>Meja ' + t.no + '</b><strong>' + LABEL[t.status] + '</strong>' + sub + '</button>';
    }).join('');
  }

  function renderAlerts() {
    $('#alerts').innerHTML = alerts.map((a, i) => a.jenis === 'bantuan'
      ? '<div class="pl-al"><div><b>Meja ' + a.no + ' minta bantuan</b><small>Menunggu <span data-since="' + a.since + '">' + mmss(Date.now() - a.since) + '</span></small></div><button data-i="' + i + '">Terima</button></div>'
      : '<div class="pl-al is-bill"><div><b>Meja ' + a.no + ' minta bill</b><small>' + esc(a.ket) + '</small></div><button data-i="' + i + '">Panggil Kasir</button></div>').join('');
  }

  function renderAntar() {
    $('#antarNone').hidden = antar.length > 0;
    $('#antarList').innerHTML = antar.map(a => '<article class="pl-a"><div class="pl-a-h"><span><b>Meja ' + a.no + '</b><small>#' + esc(a.ref) + '</small></span><time data-since="' + a.since + '">' + mmss(Date.now() - a.since) + '</time></div>' +
      '<div class="pl-a-b"><ul>' + a.items.map(i => '<li>' + i[0] + '× ' + esc(i[1]) + '</li>').join('') + '</ul><button data-no="' + a.no + '">Sudah Diantar</button></div></article>').join('');
  }

  function totals(no) {
    const o = ord(no); let q = 0, s = 0;
    menu.forEach(m => { const n = o.items[m.id] || 0; q += n; s += n * m.harga; });
    return { q, s };
  }

  function renderOrder() {
    const t = byNo(sel), o = ord(sel);
    $('#oTitle').textContent = 'Meja ' + sel;
    $('#oMeta').textContent = t.tamu + ' tamu · ' + (t.nama || 'Tamu') + ' · ' + t.tipe;
    document.querySelectorAll('#oTabs button').forEach(b => b.classList.toggle('is-on', b.dataset.t === tab));
    $('#oMenu').innerHTML = menu.filter(m => m.kat === tab).map(m => {
      const n = o.items[m.id] || 0;
      const ctrl = n > 0
        ? '<div class="pl-qty"><button class="m" data-id="' + m.id + '" data-d="-1" aria-label="Kurangi">−</button><span>' + n + '</span><button class="p" data-id="' + m.id + '" data-d="1" aria-label="Tambah">+</button></div>'
        : '<button class="pl-add" data-id="' + m.id + '" data-d="1">Tambah</button>';
      return '<li><div><b>' + esc(m.nama) + '</b><small>' + rp(m.harga) + '</small></div>' + ctrl + '</li>';
    }).join('');
    $('#oNote').value = o.note;
    const tt = totals(sel);
    $('#oCount').textContent = tt.q + ' item';
    $('#oSub').textContent = 'Subtotal ' + rp(tt.s);
    $('#btnKirim').disabled = tt.q === 0;
  }

  function renderAll() { renderStats(); renderFloor(); renderAlerts(); renderAntar(); renderOrder(); }

  function tick() {
    document.querySelectorAll('[data-since]').forEach(el => { el.textContent = mmss(Date.now() - +el.dataset.since); });
    tickClock();
  }

  const dlg = bootstrap.Modal.getOrCreateInstance($('#dlgBuka'));
  function openBuka(no) {
    const free = tables.filter(t => t.status === 'kosong');
    if (!free.length) { toast('Semua meja sedang terisi'); return; }
    $('#bMeja').innerHTML = free.map(t => '<option value="' + t.no + '">Meja ' + t.no + ' · ' + t.kursi + ' kursi</option>').join('');
    if (no) $('#bMeja').value = no;
    $('#bTamu').value = Math.min(2, byNo($('#bMeja').value).kursi);
    $('#bNama').value = '';
    dlg.show();
  }
  $('#bMeja').addEventListener('change', e => { $('#bTamu').value = Math.min(2, byNo(e.target.value).kursi); });
  $('#btnBaru').addEventListener('click', () => openBuka(null));
  $('#frmBuka').addEventListener('submit', e => {
    e.preventDefault();
    const t = byNo($('#bMeja').value), n = Math.max(1, parseInt($('#bTamu').value, 10) || 1);
    if (n > t.kursi) { toast('Meja ' + t.no + ' hanya punya ' + t.kursi + ' kursi'); return; }
    t.status = 'terisi'; t.tamu = n; t.nama = $('#bNama').value.trim(); t.since = Date.now();
    sum.ditangani++; sel = t.no;
    dlg.hide(); toast('Meja ' + t.no + ' dibuka untuk ' + n + ' tamu'); renderAll();
  });

  $('#floor').addEventListener('click', e => {
    const b = e.target.closest('.pl-t'); if (!b) return;
    const t = byNo(b.dataset.no);
    if (t.status === 'kosong') { openBuka(t.no); return; }
    sel = t.no; renderFloor(); renderOrder();
  });
  $('#oTabs').addEventListener('click', e => { const b = e.target.closest('button'); if (b) { tab = b.dataset.t; renderOrder(); } });
  $('#oMenu').addEventListener('click', e => {
    const b = e.target.closest('button'); if (!b) return;
    const o = ord(sel), id = b.dataset.id;
    o.items[id] = Math.max(0, (o.items[id] || 0) + +b.dataset.d);
    if (!o.items[id]) delete o.items[id];
    renderOrder();
  });
  $('#oNote').addEventListener('input', e => { ord(sel).note = e.target.value; });
  $('#btnKirim').addEventListener('click', () => {
    const tt = totals(sel); if (!tt.q) return;
    sum.dikirim++;
    orders[sel] = { items: {}, note: '' };
    toast('Pesanan Meja ' + sel + ' (' + tt.q + ' item) dikirim ke dapur');
    renderStats(); renderOrder();
  });
  $('#antarList').addEventListener('click', e => {
    const b = e.target.closest('button'); if (!b) return;
    const i = antar.findIndex(a => a.no === b.dataset.no); if (i < 0) return;
    const [a] = antar.splice(i, 1);
    const t = byNo(a.no); t.status = 'makan'; t.since = Date.now();
    sum.diantar++; toast('Meja ' + a.no + ' sudah diantar'); renderAll();
  });
  $('#alerts').addEventListener('click', e => {
    const b = e.target.closest('button'); if (!b) return;
    const a = alerts.splice(+b.dataset.i, 1)[0];
    if (a.jenis === 'bantuan') {
      const t = byNo(a.no); if (t && t.status === 'bantuan') { t.status = 'terisi'; t.since = Date.now(); }
      sum.bantuan++; toast('Bantuan Meja ' + a.no + ' diterima');
    } else toast('Kasir dipanggil ke Meja ' + a.no);
    renderAll();
  });

  renderAll(); tick();
  setInterval(tick, 1000);
})();
