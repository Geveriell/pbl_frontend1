(function () {

  window.addEventListener('pageshow', e => { if (e.persisted) location.reload(); });

  const list = document.getElementById('menuList');
  const cartBar = document.getElementById('cartBar');
  const searchEl = document.getElementById('searchInput');
  const chipsEl = document.getElementById('chips');
  const csrf = document.querySelector('meta[name="csrf-token"]').content;

  function ctrl(qty, url) {
    return qty > 0
      ? '<div class="qty"><button data-act="dec" aria-label="Hapus porsi terakhir">' + ico('minus') + '</button>' +
        '<span>' + qty + '</span><a class="plus" href="' + url + '" aria-label="Tambah porsi dan racik">' + ico('plus') + '</a></div>'
      : '<a class="app-btn app-btn--accent btn-add" href="' + url + '">' + ico('plus') + ' Tambah</a>';
  }

  function updateCart(d) {
    const mejaText = document.getElementById('cartText').textContent.split('•')[1] || '';
    cartBar.hidden = d.items === 0;
    document.getElementById('cartCount').textContent = d.items;
    document.getElementById('cartText').textContent = d.items + ' Item •' + mejaText;
    document.getElementById('cartTotal').textContent = d.totalFmt;
  }

  list.addEventListener('click', async e => {
    const b = e.target.closest('[data-act]'); if (!b || b.disabled) return;
    const card = b.closest('.menu-item');
    b.disabled = true;
    try {
      const res = await fetch(API_CART, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf },
        body: JSON.stringify({ id: +card.dataset.id, action: 'dec' })
      });
      const d = await res.json();
      if (!d.ok) throw new Error(d.error || 'Gagal');
      const bc = card.querySelector('.buy-ctrl');
      bc.innerHTML = ctrl(d.qty, bc.dataset.add);
      updateCart(d);
      toast('Porsi terakhir dihapus');
    } catch (err) {
      alert('Keranjang gagal diperbarui: ' + err.message);
      b.disabled = false;
    }
  });

  searchEl.addEventListener('input', () => {
    const q = searchEl.value.trim().toLowerCase();
    let n = 0;
    list.querySelectorAll('.menu-item').forEach(c => {
      const show = !q || c.dataset.name.includes(q);
      c.hidden = !show; if (show) n++;
    });
    document.getElementById('menuCount').textContent = n + ' Pilihan Tersedia';
  });

  chipsEl.addEventListener('click', e => {
    const b = e.target.closest('.chip'); if (!b) return;
    chipsEl.querySelectorAll('.chip').forEach(c => c.classList.toggle('is-active', c === b));
  });
})();
