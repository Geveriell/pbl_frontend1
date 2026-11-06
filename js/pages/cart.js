(function () {
  window.addEventListener('pageshow', e => { if (e.persisted) location.reload(); });
  const csrf = document.querySelector('meta[name="csrf-token"]').content;
  const list = document.getElementById('cartList');

  if (list) {
    list.addEventListener('click', async e => {
      const b = e.target.closest('[data-act]'); if (!b || b.disabled) return;
      const card = b.closest('.cart-item');
      b.disabled = true;
      try {
        const res = await fetch(API_CART, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf },
          body: JSON.stringify({ action: 'remove', line: card.dataset.line })
        });
        const d = await res.json();
        if (!d.ok) throw new Error(d.error || 'Gagal');
        location.reload();
        return;
      } catch (err) {
        toast('Porsi gagal dihapus: ' + err.message);
      }
      b.disabled = false;
    });
  }

  const pay = document.getElementById('payBtn');
  if (pay) {
    document.getElementById('methods').addEventListener('change', e => {
      pay.href = e.target.value === 'qris' ? APP.routes.payment : APP.routes.statusPaid + '&metode=' + e.target.value;
    });
    document.getElementById('btnPromo').addEventListener('click', () => {
      toast(document.getElementById('promoCode').value.trim() ? 'Kode belum bisa dipakai pada pesanan ini' : 'Isi kode voucher atau nomor member dulu');
    });
  }
})();
