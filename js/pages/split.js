(function () {
  const S = window.SPLIT;
  const $ = id => document.getElementById(id);
  const rp = n => 'Rp ' + n.toLocaleString('id-ID');
  const MAX = 10;
  let n = S.n, mode = 'rata';
  let assign = S.lines.map((_, i) => i % n);

  function amounts() {
    if (mode === 'rata') { const sh = Math.ceil(S.total / n / 100) * 100; return Array(n).fill(sh); }
    const a = Array(n).fill(0);
    S.lines.forEach((l, i) => { a[Math.min(assign[i], n - 1)] += l.sum; });
    return a.map(v => Math.round(v * (1 + S.pajak)));
  }

  function render() {
    const a = amounts();
    $('cnt').textContent = n;
    $('nMinus').disabled = n <= 2; $('nPlus').disabled = n >= MAX;
    $('share').textContent = rp(a[0]);
    $('pass').textContent = a[0] * n === S.total ? 'Tepat & Bersih' : 'Dibulatkan ke atas';

    $('assign').innerHTML = S.lines.map((l, i) =>
      '<li><span><b>' + l.n + '</b>' + rp(l.sum) + '</span><select data-i="' + i + '" aria-label="Dibayar oleh">' +
      a.map((_, p) => '<option value="' + p + '"' + (Math.min(assign[i], n - 1) === p ? ' selected' : '') + '>Orang ' + (p + 1) + '</option>').join('') +
      '</select></li>').join('');

    $('people').innerHTML = a.map((v, p) => {
      const paid = p === 0;
      return '<li class="' + (paid ? 'paid' : '') + '"><span class="av">' + String.fromCharCode(65 + p) + '</span>' +
        '<div class="p-t"><b>Orang ' + (p + 1) + (paid ? ' (Anda) <em>Host</em>' : '') + '</b><small>' + rp(v) + ' • ' + (paid ? 'Lunas' : 'Menunggu bayar') + '</small></div>' +
        (paid ? '<span class="pill">' + ico('tick') + ' Lunas</span>' : '<button class="app-btn app-btn--soft" data-link="' + p + '">' + ico('share') + ' Bagi Link</button>') + '</li>';
    }).join('');

    $('partCount').textContent = n + ' Bagian';
    $('progTxt').textContent = '1 dari ' + n + ' Lunas';
    $('progAmt').textContent = rp(a[0]) + ' / ' + rp(S.total);
    $('progBar').style.width = (a[0] / S.total * 100) + '%';
  }

  $('nMinus').addEventListener('click', () => { if (n > 2) { n--; render(); } });
  $('nPlus').addEventListener('click', () => { if (n < MAX) { n++; render(); } });
  $('assign').addEventListener('change', e => { assign[+e.target.dataset.i] = +e.target.value; render(); });
  $('people').addEventListener('click', e => {
    const b = e.target.closest('[data-link]');
    if (b) toast('Tautan bayar Orang ' + (+b.dataset.link + 1) + ' disalin');
  });
  document.querySelectorAll('.tabs button').forEach(b => b.addEventListener('click', () => {
    mode = b.dataset.mode;
    document.querySelectorAll('.tabs button').forEach(x => x.classList.toggle('is-active', x === b));
    $('paneRata').hidden = mode !== 'rata'; $('paneItem').hidden = mode !== 'item';
    render();
  }));
  const share = $('btnShare');
  share.addEventListener('click', () => toast('Rincian meja siap dibagikan ke WhatsApp'));
  share.addEventListener('keydown', e => { if (e.key === 'Enter') share.click(); });
  render();
})();
