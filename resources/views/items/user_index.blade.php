<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inventory - User</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0f0f0f; color: #e0e0e0; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background: #141414; border-right: 1px solid #2a2a2a; display: flex; flex-direction: column; padding: 28px 20px; }
        .sidebar-brand { font-size: 18px; font-weight: 700; color: #fff; letter-spacing: 1px; margin-bottom: 40px; display: flex; align-items: center; gap: 10px; }
        .sidebar-brand span { color: #888; font-weight: 300; font-size: 13px; display: block; }
        .nav-item a { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 8px; color: #aaa; text-decoration: none; font-size: 14px; transition: all 0.2s; }
        .nav-item a.active, .nav-item a:hover { background: #222; color: #fff; }
        .sidebar-footer { margin-top: auto; }
        .btn-logout { display: flex; align-items: center; gap: 10px; padding: 11px 14px; border-radius: 8px; color: #e74c3c; text-decoration: none; font-size: 14px; transition: all 0.2s; }
        .btn-logout:hover { background: #1f1010; color: #e74c3c; }
        .main-content { margin-left: 260px; padding: 36px 40px; }
        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-size: 24px; font-weight: 700; color: #fff; }
        .page-header p { font-size: 13px; color: #666; margin-top: 4px; }
        .badge-user { background: #1f1f1f; color: #aaa; border: 1px solid #2a2a2a; font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; letter-spacing: 1px; }
        .card-dark { background: #141414; border: 1px solid #2a2a2a; border-radius: 14px; padding: 28px; margin-bottom: 24px; }
        .card-title { font-size: 14px; font-weight: 600; color: #fff; margin-bottom: 20px; }
        .search-wrapper { position: relative; margin-bottom: 20px; }
        .search-wrapper input { padding-left: 38px; }
        .search-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #555; font-size: 14px; }
        .form-control, .form-control:focus { background: #0f0f0f; border: 1px solid #2a2a2a; color: #e0e0e0; border-radius: 8px; font-size: 14px; padding: 10px 14px; }
        .form-control:focus { border-color: #555; box-shadow: none; color: #fff; }
        .form-control::placeholder { color: #444; }
        .table { color: #ccc; border-color: #1f1f1f; }
        .table thead th { background: #1a1a1a; color: #777; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; border-bottom: 1px solid #2a2a2a; padding: 14px 16px; }
        .table tbody tr { border-bottom: 1px solid #1a1a1a; transition: background 0.15s; }
        .table tbody tr:hover { background: #181818; }
        .table tbody td { padding: 16px; font-size: 14px; border: none; vertical-align: middle; }
        .item-name { color: #fff; font-weight: 500; }
        .stock-badge { background: #1f1f1f; color: #aaa; border: 1px solid #2a2a2a; padding: 4px 10px; border-radius: 6px; font-size: 12px; }
        .price-text { color: #fff; font-weight: 600; }
        .readonly-notice { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #666; display: flex; align-items: center; gap: 8px; }
        
        .btn-buy-dark {
            background: #fff; border: 1px solid #fff;
            color: #000; padding: 6px 14px; border-radius: 6px;
            font-size: 12px; font-weight: 600; transition: all 0.2s;
        }
        .btn-buy-dark:hover { background: #ddd; border-color: #ddd; color: #000; }
        .btn-buy-dark:disabled { background: #222; border-color: #2a2a2a; color: #555; cursor: not-allowed; }

        .modal-content { background: #141414; border: 1px solid #2a2a2a; border-radius: 16px; color: #e0e0e0; }
        .modal-header { border-bottom: 1px solid #2a2a2a; padding: 20px 24px; }
        .modal-title { font-size: 15px; font-weight: 600; color: #fff; }
        .modal-footer { border-top: 1px solid #2a2a2a; padding: 16px 24px; }
        .btn-close { filter: invert(1); }
        .btn-modal-cancel { background: transparent; border: 1px solid #2a2a2a; color: #aaa; padding: 9px 20px; border-radius: 8px; font-size: 14px; }
        .btn-modal-save { background: #fff; color: #000; border: none; padding: 9px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; }
        .btn-modal-save:hover { background: #ddd; color: #000; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <span>💡</span>
        <div>TECH INVENTORY <span>User Portal</span></div>
    </div>
    <nav>
        <div class="nav-item">
            <a href="#" class="active"><span>☰</span> Products Catalog</a>
        </div>
    </nav>
    <div class="sidebar-footer">
        <div style="font-size:11px; color:#444; margin-bottom:12px; padding: 0 14px;">
            Logged in as<br>
            <span style="color:#777; font-weight:500;">{{ auth()->user()->name }}</span>
        </div>
        <a href="{{ route('logout') }}" class="btn-logout">↩ Sign Out</a>
    </div>
</div>

<div class="main-content">
    <div class="page-header d-flex justify-content-between align-items-start">
        <div>
            <h1>Products Catalog</h1>
            <p>List of available products</p>
        </div>
        <span class="badge-user">USER</span>
    </div>

    <div class="card-dark">
        <div class="card-title">Product List</div>
        <div class="readonly-notice">
            🛍️ You are logged in as <strong style="color:#aaa;">User</strong> — Select items below to simulate a transaction purchase.
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" style="background:#1a1a1a; border:1px solid #2a2a2a; color:#555; border-right:none;">🔍</span>
            <input type="text" id="search-input" class="form-control" placeholder="Search product name..." style="border-left:none;">
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Stock</th>
                    <th>Unit Price</th>
                    <th>Total Value</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="tabel-barang">
                @foreach($items as $item)
                <tr id="item-{{ $item->id }}">
                    <td class="item-name">{{ $item->nama_barang }}</td>
                    <td><span class="stock-badge" id="stock-val-{{ $item->id }}">{{ $item->stok }} unit</span></td>
                    <td class="price-text">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td style="color:#666;" id="total-val-{{ $item->id }}">Rp {{ number_format($item->harga * $item->stok, 0, ',', '.') }}</td>
                    <td class="text-end">
                        <button class="btn-buy-dark btn-buy" 
                                data-id="{{ $item->id }}"
                                data-nama="{{ $item->nama_barang }}"
                                data-harga="{{ $item->harga }}"
                                data-stok="{{ $item->stok }}"
                                {{ $item->stok <= 0 ? 'disabled' : '' }}>
                            {{ $item->stok <= 0 ? 'Out of Stock' : 'Buy Item' }}
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL CHECKOUT PRODUK --}}
<div class="modal fade" id="modalBeli" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Checkout Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="form-beli">
                    <input type="hidden" id="beli-id">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" id="beli-nama" class="form-control" readonly style="opacity: 0.7;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price per Unit</label>
                        <input type="text" id="beli-harga-label" class="form-control" readonly style="opacity: 0.7;">
                        <input type="hidden" id="beli-harga">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity to Buy</label>
                        <input type="number" id="beli-jumlah" class="form-control" min="1" value="1" required>
                        <small class="text-muted mt-1 d-block" id="beli-stok-info"></small>
                    </div>
                    <div class="p-3 border border-secondary rounded" style="background: #1a1a1a;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="font-size: 13px; color: #888;">Total Payment:</span>
                            <span style="font-size: 16px; font-weight: 700; color: #fff;" id="total-pembayaran">Rp 0</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-modal-save" id="btn-konfirmasi-beli">Confirm Purchase</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL INVOICE NOTA SUKSES --}}
<div class="modal fade" id="modalNotaSukses" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-header border-0 justify-content-center">
                <div style="font-size: 50px; color: #2ecc71;">✓</div>
            </div>
            <div class="modal-body">
                <h5 class="modal-title fw-bold text-white mb-2" style="font-size: 18px;">Transaction Success!</h5>
                <p class="text-secondary small mb-4">Your transaction has been processed successfully.</p>
                
                <div class="p-3 rounded text-start" style="background: #1a1a1a; border: 1px solid #2a2a2a; font-size: 13px;">
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #666;">Product Name:</span>
                        <span class="text-white fw-medium" id="nota-nama">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #666;">Quantity:</span>
                        <span class="text-white fw-medium" id="nota-qty">-</span>
                    </div>
                    <hr style="border-color: #333; margin: 10px 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="color: #666; font-weight: 600;">Total Paid:</span>
                        <span style="color: #fff; font-weight: 700; font-size: 15px;" id="nota-total">Rp 0</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center pt-0">
                <button type="button" class="btn-modal-save w-100" data-bs-dismiss="modal">Close & Back to Catalog</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function formatRupiah(num) {
    return 'Rp ' + Number(num).toLocaleString('id-ID');
}

$(document).ready(function() {
    $('#search-input').on('keyup', function() {
        let keyword = $(this).val().toLowerCase().trim();

        $('#tabel-barang tr').each(function() {
            let namaProduk = $(this).find('.item-name').text().toLowerCase();

            if (namaProduk.indexOf(keyword) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        let totalVisible = $('#tabel-barang tr:visible').length;
        $('#no-data-row').remove();
        
        if (totalVisible === 0) {
            $('#tabel-barang').append(`
                <tr id="no-data-row">
                    <td colspan="5" class="text-center py-4" style="color:#555;">
                        Product "${$(this).val()}" not found.
                    </td>
                </tr>
            `);
        }
    });

    $(document).on('click', '.btn-buy', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');
        let harga = $(this).data('harga');
        let stok = $(this).data('stok');

        $('#beli-id').val(id);
        $('#beli-nama').val(nama);
        $('#beli-harga').val(harga);
        $('#beli-harga-label').val(formatRupiah(harga));
        $('#beli-jumlah').val(1).attr('max', stok);
        $('#beli-stok-info').text(`Available stock: ${stok} units`);
        
        $('#total-pembayaran').text(formatRupiah(harga));

        new bootstrap.Modal(document.getElementById('modalBeli')).show();
    });

    $('#beli-jumlah').on('input keyup', function() {
        let qty = parseInt($(this).val()) || 0;
        let harga = parseInt($('#beli-harga').val()) || 0;
        let maxStok = parseInt($(this).attr('max')) || 0;

        if (qty > maxStok) {
            $(this).val(maxStok);
            qty = maxStok;
        }

        $('#total-pembayaran').text(formatRupiah(qty * harga));
    });

    $('#btn-konfirmasi-beli').on('click', function() {
        let id = $('#beli-id').val();
        let qty = $('#beli-jumlah').val();

        if (qty < 1) {
            alert('Please enter a valid quantity.');
            return;
        }

        $.ajax({
            url: "{{ url('/items') }}/" + id + "/transaction", 
            type: "POST",
            data: {
                item_id: id,
                jumlah: qty
            },
            success: function(res) {
                if (res.success) {
                    $('#nota-nama').text($('#beli-nama').val());
                    $('#nota-qty').text(qty + ' unit(s)');
                    $('#nota-total').text($('#total-pembayaran').text());

                    bootstrap.Modal.getInstance(document.getElementById('modalBeli')).hide();
                    new bootstrap.Modal(document.getElementById('modalNotaSukses')).show();
               
                    let currentBtn = $(`.btn-buy[data-id="${id}"]`);
                    let sisaStok = res.data.stok;
                    let hargaBarang = res.data.harga;

                    $(`#stock-val-${id}`).text(`${sisaStok} unit`);
                    $(`#total-val-${id}`).text(formatRupiah(sisaStok * hargaBarang));
                    currentBtn.data('stok', sisaStok);

                    if (sisaStok <= 0) {
                        currentBtn.text('Out of Stock').attr('disabled', true);
                    }
                } else {
                    alert(res.message);
                }
            },
            error: function() {
                alert('Transaction failed. Make sure your controller logic matches the request.');
            }
        });
    });
});
</script>
</body>
</html>