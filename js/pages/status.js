(function () {
  const meja = document.querySelector('.app').dataset.meja;
  const call = document.getElementById('btnCall');
  const struk = document.getElementById('btnStruk');
  if (call) call.addEventListener('click', () => toast('Pelayan terdekat telah diberi notifikasi untuk Meja ' + meja + '.'));
  if (struk) struk.addEventListener('click', () => toast('Struk digital akan tersedia setelah pesanan selesai'));
})();
