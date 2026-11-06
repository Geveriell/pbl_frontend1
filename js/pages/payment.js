(function () {
  const root = document.querySelector('.app--pay');
  const batas = +root.dataset.batas;
  let sisa = +root.dataset.sisa;
  const meja = root.dataset.meja;

  const clock = document.getElementById('clock');
  const bar = document.getElementById('timerBar');
  function tick() {
    const m = String(Math.floor(sisa / 60)).padStart(2, '0');
    const s = String(sisa % 60).padStart(2, '0');
    clock.textContent = m + ':' + s;
    bar.style.width = (sisa / batas * 100) + '%';
    if (sisa <= 0) { clearInterval(t); return; }
    sisa--;
  }
  tick();
  const t = setInterval(tick, 1000);

<<<<<<< HEAD:js/pages/payment.js
  const N = 25; let svg = '', seed = 7;
  const rnd = () => (seed = (seed * 16807) % 2147483647) / 2147483647;
  const inFinder = (x, y) => (x < 8 && y < 8) || (x >= N - 8 && y < 8) || (x < 8 && y >= N - 8);
  for (let y = 0; y < N; y++) for (let x = 0; x < N; x++)
    if (!inFinder(x, y) && rnd() > 0.52) svg += '<rect x="' + x + '" y="' + y + '" width="1" height="1"/>';
  [[0, 0], [N - 7, 0], [0, N - 7]].forEach(([fx, fy]) => {
    svg += '<rect x="' + fx + '" y="' + fy + '" width="7" height="7"/>' +
           '<rect x="' + (fx + 1) + '" y="' + (fy + 1) + '" width="5" height="5" fill="#fff"/>' +
           '<rect x="' + (fx + 2) + '" y="' + (fy + 2) + '" width="3" height="3"/>';
  });
  document.getElementById('qrGrid').innerHTML = svg;

  document.getElementById('btnSave').addEventListener('click', () => alert('Simpan gambar QR (hubungkan ke backend)'));
  document.getElementById('btnCheck').addEventListener('click', () => alert('Cek status pembayaran (api/order-status.php)'));
  document.getElementById('btnCall').addEventListener('click', e => { e.preventDefault(); alert('Memanggil kasir ke Meja ' + meja); });
=======
  /* ----- QR placeholder (js/ui.js); hapus bila memakai gambar QRIS dari payment gateway ----- */
  drawQR(document.getElementById('qrGrid'), 7);

  /* ----- aksi (sambungkan ke api/ saat backend siap) ----- */
  document.getElementById('btnSave').addEventListener('click', () => toast('Gambar QR disimpan (hubungkan ke backend)'));
  document.getElementById('btnCheck').addEventListener('click', () => {
    toast('Memeriksa pembayaran…');
    // TODO: panggil api/order-status.php, lalu pindah ke status.php bila lunas
    setTimeout(() => { location.href = 'status.php'; }, 1200);
  });
  document.getElementById('btnCall').addEventListener('click', e => { e.preventDefault(); toast('Kasir dipanggil ke Meja ' + meja); });
>>>>>>> 86ce094a8c2c90ac04beeb6125876965e70d8bc3:js/payment.js
})();
