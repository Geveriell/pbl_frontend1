(function () {
  const $ = (s, r) => (r || document).querySelector(s);
  const $$ = (s, r) => [...(r || document).querySelectorAll(s)];
  const rp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
  const esc = s => String(s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

  const data = JSON.parse($('#ksData').textContent);
  const PAJAK = data.pajak;
  const orders = data.orders;
  const shift = data.shift;
  let lunas = data.lunas;
  let cur = null, method = 'Tunai', splitVia = 'Tunai', splitN = 2, cash = 0;

  const STATUS = { siap: ['Siap dibayar', true], masak: ['Dimasak', false], sebagian: ['Sebagian', false] };

  const calc = o => {
    const sub = o.items.reduce((n, i) => n + i[0] * i[2], 0);
    const disc = Math.round(sub * o.diskon / 100);
    const pb1 = Math.round((sub - disc) * PAJAK);
    const total = sub - disc + pb1;
    return { sub, disc, pb1, total, sisa: total - o.dibayar, qty: o.items.reduce((n, i) => n + i[0], 0) };
  };
  const shareOf = o => {
    const c = calc(o);
    const left = (o.split ? o.split.n : splitN) - (o.split ? o.split.k : 0);
    return left <= 1 ? c.sisa : Math.min(c.sisa, Math.round(c.sisa / left / 100) * 100);
  };
  const due = () => (method === 'Split Bill' ? shareOf(cur) : calc(cur).sisa);
  const cashMode = () => method === 'Tunai' || (method === 'Split Bill' && splitVia === 'Tunai');

  function tickClock() {
    $('#ksClock').textContent = new Date().toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', hour12: false });
  }
  tickClock();
  setInterval(tickClock, 15000);

  function renderStats() {
    const kas = Object.values(shift).reduce((a, b) => a + b, 0);
    $('#cBelum').textContent = orders.length;
    $('#qCount').textContent = orders.length;
    $('#cLunas').textContent = lunas;
    $('#cSplit').textContent = orders.filter(o => o.split).length;
    $('#cKas').textContent = 'Rp ' + String(+(kas / 1e6).toFixed(2)).replace('.', ',') + ' jt';
    $('#shiftList').innerHTML = Object.entries(shift).map(([k, v]) => '<div><dt>' + esc(k) + '</dt><dd>' + rp(v) + '</dd></div>').join('');
    $('#shiftTotal').textContent = rp(kas);
  }

  function renderQueue() {
    $('#queue').innerHTML = orders.map(o => {
      const c = calc(o);
      const [label, ready] = STATUS[o.status];
      const info = '#' + o.id + ' · ' + c.qty + ' item · ' + (o.split ? 'Split Bill ' + o.split.k + '/' + o.split.n : o.tipe);
      return '<li><button class="ks-q t-' + o.tone + (cur && cur.id === o.id ? ' is-sel' : '') + '" data-id="' + o.id + '">' +
        '<span class="ks-q-h"><span>Meja ' + esc(o.meja) + '</span><span>' + rp(c.total) + '</span></span>' +
        '<span class="ks-q-b"><span>' + esc(info) + '</span><span class="ks-tag' + (ready ? ' is-ready' : '') + '">' + label + '</span></span></button></li>';
    }).join('');
  }

  function renderDetail() {
    const has = !!cur;
    $('#detailBody').hidden = !has;
    $('#detailActions').hidden = !has;
    $('#detailEmpty').hidden = has;
    $('#payCard').hidden = !has;
    if (!has) return;
    const c = calc(cur);
    $('#detailBody').innerHTML =
      '<h3>Meja ' + esc(cur.meja) + '</h3>' +
      '<p class="ks-meta">#' + esc(cur.id) + ' · ' + esc(cur.tipe) + ' · ' + esc(cur.pelanggan) + '</p>' +
      cur.items.map(i => '<div class="ks-line"><em>' + i[0] + '×</em><span>' + esc(i[1]) + (i[3] ? '<small>' + esc(i[3]) + '</small>' : '') + '</span><span>' + rp(i[0] * i[2]) + '</span></div>').join('') +
      '<div class="ks-sum"><p><span>Subtotal</span><span>' + rp(c.sub) + '</span></p>' +
      '<p><span>PB1 (' + Math.round(PAJAK * 100) + '%)</span><span>' + rp(c.pb1) + '</span></p>' +
      '<p><span>Diskon' + (cur.diskon ? ' (' + cur.diskon + '%)' : '') + '</span><span>– ' + rp(c.disc) + '</span></p>' +
      '<p class="ks-grand"><span>Total</span><b>' + rp(c.total) + '</b></p></div>';
  }

  function quickAmounts(n) {
    const up = (v, s) => (Math.floor(v / s) + 1) * s;
    const out = [...new Set([up(n, 10000), up(n, 50000), up(n, 100000)])];
    while (out.length < 3) out.push(out[out.length - 1] + 50000);
    return out;
  }
  const fmtK = v => (v % 1000 === 0 ? v / 1000 + 'rb' : rp(v));

  function resetCash() {
    const d = due();
    cash = Math.ceil((d + 1) / 50000) * 50000;
    if (cash < d) cash = d;
  }

  function renderPay() {
    if (!cur) return;
    const c = calc(cur);
    const split = method === 'Split Bill';
    const d = due();
    $('#payTotal').textContent = rp(c.sisa);
    const paid = $('#payPaid');
    paid.hidden = !cur.dibayar;
    paid.textContent = cur.dibayar ? 'Sudah dibayar ' + rp(cur.dibayar) + ' dari ' + rp(c.total) : '';

    $$('#methods button').forEach(b => b.classList.toggle('is-on', b.dataset.m === method));
    $('#splitBox').hidden = !split;
    if (split) {
      const n = cur.split ? cur.split.n : splitN, k = cur.split ? cur.split.k : 0;
      $('#spN').textContent = n;
      $('#spMin').disabled = !!cur.split || n <= 2;
      $('#spPlus').disabled = !!cur.split || n >= 10;
      $('#spInfo').textContent = 'Bagian ' + (k + 1) + ' dari ' + n + ' orang';
      $('#spShare').textContent = rp(d);
      $$('#splitVia button').forEach(b => b.classList.toggle('is-on', b.dataset.v === splitVia));
    }

    const cm = cashMode();
    $('#cashBox').hidden = !cm;
    const note = $('#noteBox');
    note.hidden = cm;
    const via = split ? splitVia : method;
    if (via === 'QRIS') note.textContent = 'Tampilkan kode QRIS ke pelanggan, lalu tekan bayar setelah pembayaran masuk.';
    else if (via === 'Kartu') note.textContent = 'Gesek atau tempel kartu pada mesin EDC, lalu tekan bayar setelah disetujui.';

    if (cm) {
      $('#cash').value = rp(cash);
      const opts = [['Uang Pas', d], ...quickAmounts(d).map(v => [fmtK(v), v])];
      $('#quick').innerHTML = opts.map(([l, v]) => '<button data-v="' + v + '" class="' + (cash === v ? 'is-on' : '') + '">' + l + '</button>').join('');
      const ch = $('#change').parentElement;
      ch.classList.toggle('is-short', cash < d);
      $('#change').textContent = cash < d ? 'Kurang ' + rp(d - cash) : rp(cash - d);
      ch.firstElementChild.textContent = cash < d ? 'Uang Diterima' : 'Kembalian';
    }
  }

  function select(id) {
    cur = orders.find(o => o.id === id) || null;
    method = 'Tunai';
    splitVia = 'Tunai';
    splitN = 2;
    if (cur) resetCash();
    renderQueue();
    renderDetail();
    renderPay();
  }

  $('#queue').addEventListener('click', e => {
    const b = e.target.closest('.ks-q');
    if (b) select(b.dataset.id);
  });

  $('#methods').addEventListener('click', e => {
    const b = e.target.closest('button');
    if (!b || !cur) return;
    method = b.dataset.m;
    resetCash();
    renderPay();
  });
  $('#splitVia').addEventListener('click', e => {
    const b = e.target.closest('button');
    if (!b) return;
    splitVia = b.dataset.v;
    resetCash();
    renderPay();
  });
  const step = d => { splitN = Math.max(2, Math.min(10, splitN + d)); resetCash(); renderPay(); };
  $('#spMin').addEventListener('click', () => step(-1));
  $('#spPlus').addEventListener('click', () => step(1));

  $('#cash').addEventListener('input', e => {
    cash = parseInt(e.target.value.replace(/\D/g, ''), 10) || 0;
    renderPay();
    const i = $('#cash');
    i.setSelectionRange(i.value.length, i.value.length);
  });
  $('#quick').addEventListener('click', e => {
    const b = e.target.closest('button');
    if (!b) return;
    cash = +b.dataset.v;
    renderPay();
  });

  $('#btnEdit').addEventListener('click', () => toast('Edit pesanan belum tersedia'));

  const dlg = bootstrap.Modal.getOrCreateInstance($('#dlgDiskon'));
  $('#btnDiskon').addEventListener('click', () => {
    $('#dPct').value = cur.diskon;
    dlg.show();
  });
  $('#dPreset').addEventListener('click', e => {
    const b = e.target.closest('button');
    if (b) $('#dPct').value = b.dataset.p;
  });
  $('#frmDiskon').addEventListener('submit', e => {
    e.preventDefault();
    if (!cur) return;
    cur.diskon = Math.max(0, Math.min(100, parseInt($('#dPct').value, 10) || 0));
    resetCash();
    renderQueue();
    renderDetail();
    renderPay();
    toast('Diskon ' + cur.diskon + '% diterapkan');
    dlg.hide();
  });

  $('#btnPay').addEventListener('click', () => {
    if (!cur) return;
    const o = cur, split = method === 'Split Bill', via = split ? splitVia : method, amt = due();
    if (cashMode() && cash < amt) { toast('Uang diterima kurang ' + rp(amt - cash)); return; }
    const kembali = cashMode() ? cash - amt : 0;

    shift[via] += amt;
    o.dibayar += amt;
    if (split) {
      if (!o.split) o.split = { k: 0, n: splitN };
      o.split.k++;
    }
    if (calc(o).sisa <= 0) {
      orders.splice(orders.indexOf(o), 1);
      lunas++;
      toast('Meja ' + o.meja + ' lunas' + (kembali ? ' · kembalian ' + rp(kembali) : '') + ' · struk dicetak');
      renderStats();
      select(orders.length ? orders[0].id : null);
    } else {
      o.status = 'sebagian';
      o.tone = 'red';
      toast('Bagian ' + o.split.k + '/' + o.split.n + ' Meja ' + o.meja + ' lunas · struk dicetak');
      renderStats();
      method = 'Split Bill';
      resetCash();
      renderQueue();
      renderDetail();
      renderPay();
    }
  });

  renderStats();
  select(orders.length ? orders[0].id : null);
})();
