(function () {
  const $ = (s, r) => (r || document).querySelector(s);
  const $$ = (s, r) => [...(r || document).querySelectorAll(s)];
  const rp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');

  const clock = $('#adClock');
  function tickClock() {
    if (!clock) return;
    const t = new Date().toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', hour12: false });
    clock.textContent = t.replace('.', ':') + ' WIB';
  }
  tickClock();
  setInterval(tickClock, 30000);

  const bell = $('#btnBell');
  if (bell) bell.addEventListener('click', () => toast('Tidak ada notifikasi baru'));

  const respond = $('#btnRespond');
  if (respond) {
    respond.addEventListener('click', () => {
      const card = $('.tbl[data-meja="' + respond.dataset.meja + '"]');
      if (!card) return;
      card.scrollIntoView({ behavior: 'smooth', block: 'center' });
      card.classList.remove('is-flash');
      void card.offsetWidth;
      card.classList.add('is-flash');
      toast('Menuju Meja ' + respond.dataset.meja);
    });
    $('#btnDone').addEventListener('click', () => {
      $('#alertBar').hidden = true;
      const card = $('.tbl--action');
      if (card) { card.classList.remove('tbl--action'); const t = $('.take', card); if (t) t.remove(); }
      toast('Permintaan ditandai selesai');
    });
    $$('.tbl').forEach(c => {
      const open = () => toast('Meja ' + c.dataset.meja + ' dipilih');
      c.addEventListener('click', open);
      c.addEventListener('keydown', e => { if (e.key === 'Enter') open(); });
    });
  }

  const grid = $('#kdsGrid');
  if (grid) {
    let station = 'all';
    const tickets = () => $$('.ticket', grid);

    function refreshTicket(t) {
      const items = $$('.tk-it', t);
      const all = items.every(i => $('input', i).checked);
      $('.tk-ok', t).hidden = !all;
      $('.tk-btn', t).disabled = !all;
      items.forEach(i => i.classList.toggle('is-done', $('input', i).checked));
    }

    function refreshAll() {
      const counts = { all: 0 };
      tickets().forEach(t => {
        let visible = 0;
        $$('.tk-it', t).forEach(i => {
          const st = i.dataset.st;
          const done = $('input', i).checked;
          if (!done) { counts.all++; counts[st] = (counts[st] || 0) + 1; }
          const show = station === 'all' || st === station;
          i.hidden = !show;
          if (show) visible++;
        });
        t.hidden = visible === 0;
      });
      $$('[data-count]').forEach(c => { c.textContent = counts[c.dataset.count] || 0; });
      $('#emptyKds').hidden = tickets().some(t => !t.hidden);
      const sla = $$('.tk-timeout', grid).length;
      $('#kSla').textContent = sla + ' Tiket';
      $('#kProses').textContent = tickets().reduce((n, t) => n + $$('.tk-t b em', t).reduce((m, e) => m + parseInt(e.textContent, 10), 0), 0);
    }

    tickets().forEach(refreshTicket);
    refreshAll();

    grid.addEventListener('change', e => {
      const t = e.target.closest('.ticket');
      if (!t) return;
      refreshTicket(t);
      refreshAll();
    });
    grid.addEventListener('click', e => {
      const b = e.target.closest('.tk-btn');
      if (!b || b.disabled) return;
      const t = b.closest('.ticket');
      const meja = t.dataset.meja;
      t.remove();
      refreshAll();
      toast('Tiket Meja ' + meja + ' selesai dan siap diantar');
    });
    $('#stations').addEventListener('click', e => {
      const b = e.target.closest('.chip-st');
      if (!b) return;
      station = b.dataset.st;
      $$('.chip-st', $('#stations')).forEach(c => c.classList.toggle('is-active', c === b));
      refreshAll();
    });
    $('#btnWaiter').addEventListener('click', () => toast('Bel waiter dibunyikan'));
    $('#btnPrint').addEventListener('click', () => toast('Mencetak ulang tiket terakhir'));
    $('#btnFull').addEventListener('click', () => {
      if (document.fullscreenElement) document.exitFullscreen();
      else if (document.documentElement.requestFullscreen) document.documentElement.requestFullscreen();
    });
  }

  const stok = $('#stokList');
  if (stok) {
    let filter = 'all';
    const rows = $$('.stok-row', stok);
    const status = n => (n <= 0 ? ['HABIS', 'tp-red', 'out'] : n <= 10 ? ['MENIPIS', 'tp-amber', 'low'] : ['TERSEDIA', 'tp-ok', 'ok']);

    function paint(r) {
      const n = +r.dataset.stok;
      const [label, cls, key] = status(n);
      const pill = $('.stok-pill', r);
      pill.textContent = label;
      pill.className = 'tp stok-pill ' + cls;
      r.dataset.state = key;
      $('.qv', r).textContent = n;
      $('.switch input', r).disabled = n <= 0;
      if (n <= 0) $('.switch input', r).checked = false;
      r.classList.toggle('is-hidden-row', !$('.switch input', r).checked);
    }

    function apply() {
      const q = $('#stokSearch').value.trim().toLowerCase();
      rows.forEach(r => {
        r.hidden = !((filter === 'all' || r.dataset.state === filter) && (!q || r.dataset.nama.includes(q)));
      });
      $('#sLow').textContent = rows.filter(r => r.dataset.state === 'low').length;
      $('#sOut').textContent = rows.filter(r => r.dataset.state === 'out').length;
    }

    rows.forEach(paint);
    apply();

    stok.addEventListener('click', e => {
      const b = e.target.closest('[data-d]');
      if (!b) return;
      const r = b.closest('.stok-row');
      const was = +r.dataset.stok;
      r.dataset.stok = Math.max(0, Math.min(999, was + +b.dataset.d));
      if (was === 0 && +r.dataset.stok > 0) $('.switch input', r).checked = true;
      paint(r);
      apply();
    });
    stok.addEventListener('change', e => {
      const r = e.target.closest('.stok-row');
      if (r) { paint(r); toast(e.target.checked ? 'Menu tampil di customer' : 'Menu disembunyikan dari customer'); }
    });
    $('#stokSearch').addEventListener('input', apply);
    $('#stokFilter').addEventListener('click', e => {
      const b = e.target.closest('.chip-st');
      if (!b) return;
      filter = b.dataset.f;
      $$('.chip-st', $('#stokFilter')).forEach(c => c.classList.toggle('is-active', c === b));
      apply();
    });
  }

  const hf = $('#hrgForm');
  if (hf) {
    const aktif = $('#dAktif'), persen = $('#dPersen');
    const potong = (b, p) => Math.max(0, Math.round(b * (100 - p) / 100 / 100) * 100);

    function recalc() {
      const p = aktif.checked ? Math.max(0, Math.min(90, parseInt(persen.value, 10) || 0)) : 0;
      let n = 0;
      $$('.hrg-row', hf).forEach(r => {
        const base = parseInt($('.hrg-in input', r).value.replace(/\D/g, ''), 10) || 0;
        const ikut = $('.hrg-ikut input', r).checked;
        if (ikut) n++;
        const disc = p > 0 && ikut;
        $('.hrg-final', r).textContent = rp(disc ? potong(base, p) : base);
        const old = $('.hrg-old', r);
        old.hidden = !disc;
        old.textContent = disc ? rp(base) : '';
      });
      $('#dCount').textContent = n;
    }

    hf.addEventListener('input', recalc);
    hf.addEventListener('change', recalc);
    $('#hrgSearch').addEventListener('input', e => {
      const q = e.target.value.trim().toLowerCase();
      $$('.hrg-row', hf).forEach(r => { r.hidden = !!q && !r.dataset.nama.includes(q); });
    });
    hf.addEventListener('submit', e => {
      const bad = $$('.hrg-in input', hf).find(i => !(parseInt(i.value.replace(/\D/g, ''), 10) > 0));
      if (bad) { e.preventDefault(); bad.focus(); toast('Harga menu harus lebih dari 0'); }
    });
    recalc();
  }

  const filter = $('#trxFilter');
  if (filter) {
    filter.addEventListener('click', e => {
      const b = e.target.closest('.chip-st');
      if (!b) return;
      $$('.chip-st', filter).forEach(c => c.classList.toggle('is-active', c === b));
      $$('#trxBody tr').forEach(r => { r.hidden = b.dataset.m !== 'all' && r.dataset.m !== b.dataset.m; });
    });
    $('#btnCetak').addEventListener('click', () => window.print());
  }

  const dmRows = $('#dmRows');
  if (dmRows) {
    const items = JSON.parse($('#dmData').textContent);
    const PER = 10;
    const CATS = ['Makanan Utama', 'Minuman', 'Camilan & Dessert'];
    const katCls = { 'Minuman': 'kat--min', 'Camilan & Dessert': 'kat--cam' };
    const katIco = { 'Makanan Utama': 'utensils', 'Minuman': 'cup', 'Camilan & Dessert': 'flame' };
    const esc = t => String(t).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const stat = m => (m.stok <= 0 ? 'out' : m.stok <= 5 ? 'low' : 'ok');
    let fs = 'all', fk = 'all', q = '', page = 1, editId = null;

    const margin = m => (m.harga - m.cost) / m.harga * 100;
    const fmtM = v => { const r = Math.round(v * 10) / 10; return (Number.isInteger(r) ? r : r.toFixed(1)) + '%'; };
    const num = n => Math.round(n).toLocaleString('id-ID');

    function counts() {
      const c = { all: items.length, ok: 0, low: 0, out: 0 };
      items.forEach(m => c[stat(m)]++);
      $$('[data-n]').forEach(el => { el.textContent = c[el.dataset.n]; });
      $('#dmCat').innerHTML = [['all', 'Semua', items.length]].concat(CATS.map(k => [k, k, items.filter(m => m.kategori === k).length]))
        .map(([k, l, n]) => '<button class="pill-f' + (fk === k ? ' is-on' : '') + '" data-k="' + esc(k) + '">' + esc(l) + ' (' + n + ')</button>').join('');
    }

    function filtered() {
      return items.filter(m => (fs === 'all' || stat(m) === fs) && (fk === 'all' || m.kategori === fk) && (!q || m.nama.toLowerCase().includes(q)));
    }

    function render() {
      const list = filtered();
      const pages = Math.max(1, Math.ceil(list.length / PER));
      page = Math.min(page, pages);
      const rows = list.slice((page - 1) * PER, page * PER);
      dmRows.innerHTML = rows.map(m => {
        const s = stat(m), mg = margin(m);
        const stk = s === 'out' ? ['stk--out', 'Habis / Sold Out'] : s === 'low' ? ['stk--low', 'Kritis > sisa ' + m.stok] : ['', 'Tersedia: ' + m.stok];
        return '<div class="dm-tr' + (s === 'out' ? ' is-out' : '') + '" data-id="' + m.id + '">' +
          '<div class="dm-menu"><span class="dm-img">' + ico(katIco[m.kategori] || 'utensils') + '</span><b>' + esc(m.nama) + '</b></div>' +
          '<span class="kat ' + (katCls[m.kategori] || '') + '">' + esc(m.kategori) + '</span>' +
          '<span class="dm-harga">' + num(m.harga) + '</span>' +
          '<div class="dm-mg"><b>' + fmtM(mg) + ' Margin</b><div class="bar"><i style="width:' + Math.max(0, Math.min(100, mg)) + '%"></i></div><small>Cost: Rp ' + num(m.cost) + '</small></div>' +
          '<span class="stk ' + stk[0] + '">' + stk[1] + '</span>' +
          '<div class="dm-act"><button class="edit" aria-label="Ubah ' + esc(m.nama) + '">' + ico('edit') + '</button><button class="del" aria-label="Hapus ' + esc(m.nama) + '">' + ico('trash') + '</button></div></div>';
      }).join('');
      $('#dmNone').hidden = rows.length > 0;
      let pg = '<button class="pg-nav" data-p="' + (page - 1) + '"' + (page <= 1 ? ' disabled' : '') + '>Sebelumnya</button>';
      for (let i = 1; i <= pages; i++) pg += '<button data-p="' + i + '"' + (i === page ? ' class="is-on"' : '') + '>' + i + '</button>';
      pg += '<button class="pg-nav" data-p="' + (page + 1) + '"' + (page >= pages ? ' disabled' : '') + '>Berikutnya</button>';
      $('#dmPager').innerHTML = pg;
    }

    function refresh() { counts(); render(); }

    $('#dmSearch').addEventListener('input', e => { q = e.target.value.trim().toLowerCase(); page = 1; render(); });
    $('#dmStatus').addEventListener('click', e => {
      const b = e.target.closest('[data-s]'); if (!b) return;
      fs = b.dataset.s; page = 1;
      $$('#dmStatus .pill-f').forEach(x => x.classList.toggle('is-on', x === b));
      render();
    });
    $('#dmCat').addEventListener('click', e => {
      const b = e.target.closest('[data-k]'); if (!b) return;
      fk = b.dataset.k; page = 1; counts(); render();
    });
    $('#dmPager').addEventListener('click', e => {
      const b = e.target.closest('[data-p]'); if (!b || b.disabled) return;
      page = +b.dataset.p; render();
    });

    const dlg = bootstrap.Modal.getOrCreateInstance($('#dlgMenu'));
    function openForm(m) {
      editId = m ? m.id : null;
      $('#dlgTitle').textContent = m ? 'Ubah Menu' : 'Tambah Menu Baru';
      $('#fNama').value = m ? m.nama : '';
      $('#fKat').value = m ? m.kategori : CATS[0];
      $('#fHarga').value = m ? m.harga : '';
      $('#fCost').value = m ? m.cost : '';
      $('#fStok').value = m ? m.stok : '';
      dlg.show();
    }
    $('#btnAdd').addEventListener('click', () => openForm(null));
    $('#frmMenu').addEventListener('submit', e => {
      e.preventDefault();
      const v = { nama: $('#fNama').value.trim(), kategori: $('#fKat').value, harga: parseInt($('#fHarga').value, 10) || 0, cost: parseInt($('#fCost').value, 10) || 0, stok: Math.max(0, parseInt($('#fStok').value, 10) || 0) };
      if (!v.nama || v.harga <= 0) { toast('Nama dan harga wajib diisi'); return; }
      if (editId) { Object.assign(items.find(m => m.id === editId), v); toast('Menu diperbarui'); }
      else { items.unshift(Object.assign({ id: Math.max(0, ...items.map(m => m.id)) + 1 }, v)); page = 1; toast('Menu baru ditambahkan'); }
      dlg.hide();
      refresh();
    });
    dmRows.addEventListener('click', e => {
      const tr = e.target.closest('.dm-tr'); if (!tr) return;
      const m = items.find(x => x.id === +tr.dataset.id);
      if (e.target.closest('.edit')) openForm(m);
      else if (e.target.closest('.del') && confirm('Hapus "' + m.nama + '" dari daftar menu?')) {
        items.splice(items.indexOf(m), 1); toast('Menu dihapus'); refresh();
      }
    });
    refresh();
  }

  const anRange = $('#anRange');
  if (anRange) {
    const all = JSON.parse($('#anData').textContent);
    const COL = ['c1', 'c2', 'c3'], HEX = ['#a83a00', '#7a5200', '#9b7468', '#e3bfb2'];
    let key = 'hari', custom = null, cur = all.hari;

    const scale = (d, f) => Object.assign({}, d, {
      omzet: d.omzet * f, banding: d.banding * f, target: d.target * f, trx: Math.round(d.trx * f),
      kanal: d.kanal.map(k => [k[0], k[1] * f, Math.round(k[2] * f)]),
      bars: d.bars.map(b => [b[0], b[1] * f, b[2]]),
      kategori: d.kategori.map(k => [k[0], k[1] * f])
    });
    const short = v => (v >= 1e6 ? +(v / 1e6).toFixed(2) + 'M' : Math.round(v / 1e3) + 'k');
    const pct = (a, b) => (b ? a / b * 100 : 0);

    function niceMax(v) {
      const pow = Math.pow(10, Math.floor(Math.log10(v)));
      return [1, 1.2, 1.6, 2, 2.4, 3, 4, 5, 6, 8, 10].map(m => m * pow).find(x => x >= v) || v;
    }

    function paint() {
      const d = cur;
      $('#aOmzet').textContent = rp(d.omzet);
      const naik = (d.omzet - d.banding) / d.banding * 100;
      $('#aNaik').textContent = (naik >= 0 ? '+' : '') + Math.round(naik) + '%';
      $('#aBanding').textContent = 'vs ' + d.bandingLabel + ' (' + rp(d.banding) + ')';
      $('#aNaik').parentElement.classList.toggle('is-down', naik < 0);
      $('#aTargetL').textContent = d.targetLabel + ': ' + rp(d.target);
      $('#aTargetP').textContent = pct(d.omzet, d.target).toFixed(1).replace('.0', '') + '%';
      $('#aTrx').textContent = d.trx.toLocaleString('id-ID');
      $('#aRata').textContent = rp(Math.round(d.omzet / d.trx / 100) * 100);
      $('#aOkL').textContent = 'Okupansi Meja: ' + d.okupansi[0] + ' / ' + d.okupansi[1] + ' aktif';
      $('#aOkP').textContent = Math.round(pct(d.okupansi[0], d.okupansi[1])) + '%';

      const top = d.kanal.slice().sort((a, b) => b[1] - a[1])[0];
      $('#aKanal').textContent = top[0] + ' Meja ' + Math.round(pct(top[1], d.omzet)) + '%';
      $('#aNominal').innerHTML = 'Nominal: <b>' + rp(top[1]) + '</b> (' + top[2].toLocaleString('id-ID') + ' Tx)';
      $('#aStack').innerHTML = d.kanal.map((k, i) => '<i class="' + COL[i] + '" style="width:' + pct(k[1], d.omzet) + '%" title="' + k[0] + ' ' + rp(k[1]) + '"></i>').join('');
      $('#aLeg').innerHTML = d.kanal.map((k, i) => '<li><i class="' + COL[i] + '"></i>' + k[0] + '</li>').join('');

      const horiz = key === 'hari';
      $('#cTitle').textContent = horiz ? 'Tren Penjualan Jam Sibuk' : 'Tren Penjualan';
      $('#cSub').textContent = horiz ? 'Pola intensitas omzet & volume pesanan berdasarkan jam operasional' : 'Omzet per ' + (key === 'bulan' ? 'minggu' : 'hari') + ' pada rentang terpilih';
      const max = niceMax(Math.max(...d.bars.map(b => b[1])));
      let g = '';
      for (let i = 0; i <= 4; i++) g += '<div class="grid-l" style="bottom:calc(34px + (100% - 74px) * ' + i / 4 + ')"><span>' + (i ? short(max * i / 4) : '0') + '</span></div>';
      let prev = '';
      g += '<div class="cols">' + d.bars.map(b => {
        const first = b[2] && b[2] !== prev; prev = b[2];
        return '<div class="bcol' + (b[2] ? ' is-rush' : '') + '">' + (first ? '<span class="cap">' + esc(b[2]) + '</span>' : '') +
          '<i style="height:' + b[1] / max * 100 + '%"><b>' + (b[2] ? short(b[1]) : '') + '</b></i><em>' + esc(b[0]) + '</em></div>';
      }).join('') + '</div>';
      $('#chart').innerHTML = g;

      const tot = d.kategori.reduce((n, k) => n + k[1], 0);
      let off = 0;
      $('#donut').innerHTML = d.kategori.map((k, i) => {
        const len = k[1] / tot * 100;
        const c = '<circle cx="60" cy="60" r="45" pathLength="100" stroke="' + HEX[i] + '" stroke-dasharray="' + len + ' ' + (100 - len) + '" stroke-dashoffset="' + -off + '"/>';
        off += len; return c;
      }).join('');
      $('#dTiket').textContent = d.trx.toLocaleString('id-ID') + ' Tiket';
      $('#catList').innerHTML = d.kategori.map((k, i) => '<li><p><i style="background:' + HEX[i] + '"></i><b>' + esc(k[0]) + '</b><b>' + Math.round(k[1] / tot * 100) + '%</b><span>(' + rp(k[1]) + ')</span></p>' +
        '<div class="bar"><i style="width:' + k[1] / tot * 100 + '%;background:' + HEX[i] + '"></i></div></li>').join('');
    }

    function esc(t) { return String(t).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c])); }

    function setRange(k) {
      key = k;
      cur = k === 'kustom' ? custom : all[k];
      $$('#anRange button').forEach(b => b.classList.toggle('is-on', b.dataset.r === k));
      paint();
    }
    const dlg = bootstrap.Modal.getOrCreateInstance($('#dlgTgl'));
    anRange.addEventListener('click', e => {
      const b = e.target.closest('button'); if (!b) return;
      if (b.dataset.r === 'kustom') {
        const t = new Date().toISOString().slice(0, 10);
        if (!$('#tglB').value) { $('#tglB').value = t; $('#tglA').value = t; }
        dlg.show();
      } else setRange(b.dataset.r);
    });
    $('#frmTgl').addEventListener('submit', e => {
      e.preventDefault();
      const a = new Date($('#tglA').value), z = new Date($('#tglB').value);
      if (isNaN(a) || isNaN(z) || z < a) { e.preventDefault(); toast('Rentang tanggal tidak valid'); return; }
      const days = Math.round((z - a) / 864e5) + 1;
      const f = fmt => new Date(fmt).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
      custom = Object.assign(scale(all.minggu, days / 7), { bandingLabel: 'periode sebelumnya', targetLabel: 'Target Periode' });
      $('#kLabel').textContent = f(a) + ' – ' + f(z);
      setRange('kustom');
      dlg.hide();
    });

    $('#btnUnduh').addEventListener('click', () => {
      const d = cur, lines = [['Ringkasan', cur === all.hari ? 'Hari Ini' : $('#anRange .is-on').textContent.trim()], ['Total penjualan', Math.round(d.omzet)], ['Target', Math.round(d.target)], ['Total transaksi', d.trx], ['Rata-rata tiket', Math.round(d.omzet / d.trx)], [], ['Kanal pembayaran', 'Nominal', 'Transaksi']]
        .concat(d.kanal.map(k => [k[0], Math.round(k[1]), k[2]]), [[], ['Tren', 'Omzet']], d.bars.map(b => [b[0], Math.round(b[1])]), [[], ['Kategori', 'Omzet']], d.kategori.map(k => [k[0], Math.round(k[1])]));
      const csv = lines.map(r => r.map(c => '"' + String(c).replace(/"/g, '""') + '"').join(',')).join('\r\n');
      const a = document.createElement('a');
      a.href = URL.createObjectURL(new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8' }));
      a.download = 'rekap-penjualan-' + key + '.csv';
      document.body.appendChild(a); a.click(); a.remove();
      toast('Rekap laporan diunduh');
    });
    paint();
  }

})();
