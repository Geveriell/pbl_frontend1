(function () {
  const $ = (s, r) => (r || document).querySelector(s);
  const $$ = (s, r) => Array.from((r || document).querySelectorAll(s));
  const rp = n => 'Rp ' + n.toLocaleString('id-ID');
  const toast = m => window.toast && window.toast(m);

  const tabs = $('#owTabs');
  if (tabs) {
    tabs.addEventListener('click', e => {
      const b = e.target.closest('[data-tab]');
      if (!b) return;
      $$('button', tabs).forEach(x => {
        const on = x === b;
        x.classList.toggle('is-on', on);
        x.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      $$('[data-panel]').forEach(p => { p.hidden = p.dataset.panel !== b.dataset.tab; });
    });
  }

  const board = $('.ow-board');
  if (board) {
    const t0 = Date.now();
    const mmss = s => String(Math.floor(s / 60)).padStart(2, '0') + ':' + String(s % 60).padStart(2, '0');
    setInterval(() => {
      const d = Math.floor((Date.now() - t0) / 1000);
      $$('time[data-detik]', board).forEach(el => { el.textContent = mmss(Number(el.dataset.detik) + d); });
    }, 1000);
    board.addEventListener('click', e => {
      const b = e.target.closest('.ow-kbtn');
      if (b) toast(b.dataset.act + ' (mode pantau owner)');
    });
  }

  const dataEl = $('#owLaporan');
  if (dataEl) {
    const D = JSON.parse(dataEl.textContent);
    const SUB = { hari: 'Aktivitas volume omset 7 hari terakhir', minggu: 'Aktivitas volume omset 7 hari terakhir', bulan: 'Omset per minggu bulan berjalan (juta rupiah)', tahun: 'Omset per bulan tahun berjalan (miliar rupiah)' };
    const UNIT = { hari: 'jt', minggu: 'jt', bulan: 'jt', tahun: 'M' };
    let key = 'hari';

    function draw(k) {
      const d = D[k];
      key = k;
      $('#rOmzet').textContent = rp(d.omzet);
      $('#rNaik').textContent = d.naik;
      $('#rTrx').textContent = d.trx.toLocaleString('id-ID');
      $('#rRata').textContent = d.rata;
      $('#rChartSub').textContent = SUB[k];
      const max = Math.max.apply(null, d.bars);
      $('#rBars').innerHTML = d.bars.map((v, i) => {
        const top = i === d.bars.length - 1;
        return '<div class="ow-bar' + (top ? ' is-top' : '') + '">' + (top ? '<b>' + v + UNIT[k] + '</b>' : '') +
          '<i style="height:' + Math.round(v / max * 78) + '%"></i><span>' + d.label[i] + '</span></div>';
      }).join('');
    }

    $('#owRange').addEventListener('click', e => {
      const b = e.target.closest('[data-r]');
      if (!b) return;
      $$('#owRange button').forEach(x => x.classList.toggle('is-on', x === b));
      if (b.dataset.r === 'kustom') {
        const v = window.prompt('Rentang tanggal (contoh: 01/11/2026 - 06/11/2026)');
        if (v) { $('#owKustom').textContent = v; toast('Rentang kustom diterapkan'); }
        return;
      }
      $('#owKustom').textContent = 'Pilih Tanggal';
      draw(b.dataset.r);
    });
    draw('hari');
  }

  const tabel = $('#stTabel');
  if (tabel) {
    const cari = $('#stCari'), peran = $('#stPeran');
    const filter = () => {
      const q = cari.value.trim().toLowerCase();
      let n = 0;
      $$('tbody tr', tabel).forEach(tr => {
        const ok = (!q || tr.dataset.cari.includes(q)) && (!peran.value || tr.dataset.peran === peran.value);
        tr.hidden = !ok;
        if (ok) n++;
      });
      $('#stJumlah').textContent = n;
    };
    cari.addEventListener('input', filter);
    peran.addEventListener('change', filter);
    tabel.addEventListener('click', e => {
      const b = e.target.closest('[data-aksi]');
      if (b) toast(b.dataset.aksi);
    });
    $('#btnTambah').addEventListener('click', () => toast('Form tambah karyawan belum tersambung ke backend'));
    $('#btnLockdown').addEventListener('click', () => {
      if (window.confirm('Aktifkan Emergency Lockdown? Semua sesi staf akan dikunci.')) toast('Emergency Lockdown diaktifkan');
    });
    $('#btnPolicy').addEventListener('click', () => toast('Kebijakan PIN/Auth dibuka'));
    $$('.ow-perm').forEach(b => b.addEventListener('click', () => {
      const on = !b.classList.contains('is-on');
      b.classList.toggle('is-on', on);
      b.setAttribute('aria-pressed', on ? 'true' : 'false');
      b.innerHTML = on ? window.ico('check') : '–';
      toast('Perubahan izin tersimpan');
    }));
  }
})();
