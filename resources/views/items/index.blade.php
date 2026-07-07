<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0f0f0f; color: #e0e0e0; }

        .sidebar {
            height: 100vh; width: 260px; position: fixed; top: 0; left: 0;
            background: #141414;
            border-right: 1px solid #2a2a2a;
            display: flex; flex-direction: column; padding: 28px 20px;
        }
        .sidebar-brand {
            font-size: 18px; font-weight: 700; color: #fff;
            letter-spacing: 1px; margin-bottom: 40px;
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-brand span { color: #888; font-weight: 300; font-size: 13px; display: block; }
        .nav-item a {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; border-radius: 8px;
            color: #aaa; text-decoration: none; font-size: 14px;
            transition: all 0.2s;
        }
        .nav-item a:hover, .nav-item a.active {
            background: #222; color: #fff;
        }
        .nav-item a .icon { font-size: 16px; width: 20px; text-align: center; }
        .sidebar-footer { margin-top: auto; }
        .btn-logout {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 14px; border-radius: 8px;
            color: #e74c3c; text-decoration: none; font-size: 14px;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: #1f1010; color: #e74c3c; }

    
        .main-content { margin-left: 260px; padding: 36px 40px; min-height: 100vh; }

     
        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-size: 24px; font-weight: 700; color: #fff; }
        .page-header p { font-size: 13px; color: #666; margin-top: 4px; }
        .badge-admin {
            background: #fff; color: #000;
            font-size: 11px; font-weight: 600;
            padding: 4px 12px; border-radius: 20px;
            letter-spacing: 1px;
        }

     
        .stat-card {
            background: #141414;
            border: 1px solid #2a2a2a;
            border-radius: 14px; padding: 24px;
            transition: border-color 0.2s;
        }
        .stat-card:hover { border-color: #444; }
        .stat-label { font-size: 12px; color: #666; letter-spacing: 0.5px; text-transform: uppercase; }
        .stat-value { font-size: 32px; font-weight: 700; color: #fff; margin: 8px 0 4px; }
        .stat-sub { font-size: 12px; color: #555; }
        .stat-icon { font-size: 28px; opacity: 0.6; }

  
        .card-dark {
            background: #141414;
            border: 1px solid #2a2a2a;
            border-radius: 14px; padding: 28px;
            margin-bottom: 24px;
        }
        .card-title { font-size: 14px; font-weight: 600; color: #fff; margin-bottom: 20px; letter-spacing: 0.3px; }

      
        .form-control, .form-control:focus {
            background: #0f0f0f; border: 1px solid #2a2a2a;
            color: #e0e0e0; border-radius: 8px; font-size: 14px;
            padding: 10px 14px;
        }
        .form-control:focus { border-color: #555; box-shadow: none; color: #fff; }
        .form-control::placeholder { color: #444; }
        .form-label { font-size: 12px; color: #777; font-weight: 500; margin-bottom: 6px; }
        .btn-save {
            background: #fff; color: #000; border: none;
            padding: 10px 24px; border-radius: 8px;
            font-size: 14px; font-weight: 600;
            transition: background 0.2s;
        }
        .btn-save:hover { background: #ddd; color: #000; }

    
        .search-wrapper { position: relative; margin-bottom: 20px; }
        .search-wrapper input { padding-left: 38px; }
        .search-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #555; font-size: 14px; }

        .table { color: #ccc; border-color: #1f1f1f; }
        .table thead th {
            background: #1a1a1a; color: #777;
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.8px;
            border-bottom: 1px solid #2a2a2a; padding: 14px 16px;
        }
        .table tbody tr { border-bottom: 1px solid #1a1a1a; transition: background 0.15s; }
        .table tbody tr:hover { background: #181818; }
        .table tbody td { padding: 16px; font-size: 14px; border: none; vertical-align: middle; }
        .item-name { color: #fff; font-weight: 500; }
        .stock-badge {
            background: #1f1f1f; color: #aaa; border: 1px solid #2a2a2a;
            padding: 4px 10px; border-radius: 6px; font-size: 12px;
        }
        .price-text { color: #fff; font-weight: 600; }
        .btn-edit-dark {
            background: transparent; border: 1px solid #3a3a3a;
            color: #aaa; padding: 6px 14px; border-radius: 6px;
            font-size: 12px; font-weight: 500; transition: all 0.2s;
        }
        .btn-edit-dark:hover { background: #2a2a2a; color: #fff; border-color: #555; }
        .btn-delete-dark {
            background: transparent; border: 1px solid #3a1a1a;
            color: #e74c3c; padding: 6px 14px; border-radius: 6px;
            font-size: 12px; font-weight: 500; transition: all 0.2s;
        }
        .btn-delete-dark:hover { background: #1f0a0a; border-color: #e74c3c; }

        .modal-content {
            background: #141414; border: 1px solid #2a2a2a;
            border-radius: 16px; color: #e0e0e0;
        }
        .modal-header { border-bottom: 1px solid #2a2a2a; padding: 20px 24px; }
        .modal-title { font-size: 15px; font-weight: 600; color: #fff; }
        .modal-footer { border-top: 1px solid #2a2a2a; padding: 16px 24px; }
        .btn-close { filter: invert(1); }
        .btn-modal-cancel {
            background: transparent; border: 1px solid #2a2a2a;
            color: #aaa; padding: 9px 20px; border-radius: 8px; font-size: 14px;
        }
        .btn-modal-save {
            background: #fff; color: #000; border: none;
            padding: 9px 24px; border-radius: 8px;
            font-size: 14px; font-weight: 600;
        }
        .btn-modal-save:hover { background: #ddd; color: #000; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar">
    <div class="sidebar-brand">
        <span>💡</span>
        <div>
           TECH INVENTORY
            <span>Admin Panel</span>
        </div>
    </div>
    <nav>
        <div class="nav-item">
            <a href="#" class="active">
                <span class="icon">▦</span> Dashboard
            </a>
        </div>
    </nav>
    <div class="sidebar-footer">
        <div style="font-size:11px; color:#444; margin-bottom:12px; padding: 0 14px;">
            Logged in as<br>
            <span style="color:#777; font-weight:500;">{{ auth()->user()->name }}</span>
        </div>
        <a href="{{ route('logout') }}" class="btn-logout">
            <span>↩</span> Sign Out
        </a>
    </div>
</div>

{{-- MAIN --}}
<div class="main-content">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-start">
        <div>
            <h1>Dashboard</h1>
            <p>Manage inventory data</p>
        </div>
        <span class="badge-admin">ADMIN</span>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Items</div>
                    <div class="stat-value" id="stat-total">{{ $items->count() }}</div>
                    <div class="stat-sub">Registered product types</div>
                </div>
                <div class="stat-icon">📦</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Stock</div>
                    <div class="stat-value" id="stat-stok">{{ $items->sum('stok') }}</div>
                    <div class="stat-sub">Units available</div>
                </div>
                <div class="stat-icon">🗂️</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Value</div>
                    <div class="stat-value" style="font-size:22px;" id="stat-nilai">
                        {{ 'Rp ' . number_format($items->sum(fn($i) => $i->harga * $i->stok), 0, ',', '.') }}
                    </div>
                    <div class="stat-sub">Estimated inventory value</div>
                </div>
                <div class="stat-icon">💰</div>
            </div>
        </div>
    </div>

    {{-- KOTAK PENAMBAHAN DARI PUBLIC API --}}
    <div class="card-dark mb-4" style="padding: 20px 28px;">
        <div style="font-size: 11px; color: #666; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 6px;">💡 Quote of the Day (Public API)</div>
        <div id="api-quote" style="font-size: 14px; font-style: italic; color: #fff;">Loading dynamic wisdom quote...</div>
        <div id="api-author" style="font-size: 12px; color: #555; margin-top: 4px; font-weight: 500;"></div>
    </div>

    {{-- Form Tambah --}}
    <div class="card-dark">
        <div class="card-title">+ Add New Item</div>
        <form id="form-tambah-barang" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Name Product</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="example: Laptop Asus" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantity in Stock</label>
                <input type="number" name="stok" class="form-control" placeholder="0" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Unit Price (IDR)</label>
                <input type="number" name="harga" class="form-control" placeholder="500000" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-save w-100">Save</button>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="card-dark">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="card-title mb-0">Inventory List</div>
            <small style="color:#555;" id="jumlah-tampil">{{ $items->count() }} items</small>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" style="background:#1a1a1a; border:1px solid #2a2a2a; color:#555; border-right:none;">🔍</span>
            <input type="text" id="search-input" class="form-control" placeholder="Search product name..." style="border-left:none;">
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name Product</th>
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
                    <td><span class="stock-badge">{{ $item->stok }} unit</span></td>
                    <td class="price-text">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td style="color:#666;">Rp {{ number_format($item->harga * $item->stok, 0, ',', '.') }}</td>
                    <td class="text-end">
                        <button class="btn-edit-dark btn-edit me-1"
                            data-id="{{ $item->id }}"
                            data-nama="{{ $item->nama_barang }}"
                            data-stok="{{ $item->stok }}"
                            data-harga="{{ $item->harga }}">Edit</button>
                        <button class="btn-delete-dark btn-delete"
                            data-id="{{ $item->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="form-edit">
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label class="form-label">Name Product</label>
                        <input type="text" id="edit-nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity in Stock</label>
                        <input type="number" id="edit-stok" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Unit Price (IDR)</label>
                        <input type="number" id="edit-harga" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-modal-save" id="btn-simpan-edit">Save</button>
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

function buildRow(d) {
    let total = Number(d.harga) * Number(d.stok);
    return `
        <tr id="item-${d.id}">
            <td class="item-name">${d.nama_barang}</td>
            <td><span class="stock-badge">${d.stok} unit</span></td>
            <td class="price-text">${formatRupiah(d.harga)}</td>
            <td style="color:#666;">${formatRupiah(total)}</td>
            <td class="text-end">
                <button class="btn-edit-dark btn-edit me-1"
                    data-id="${d.id}" data-nama="${d.nama_barang}"
                    data-stok="${d.stok}" data-harga="${d.harga}">Edit</button>
                <button class="btn-delete-dark btn-delete"
                    data-id="${d.id}">Hapus</button>
            </td>
        </tr>`;
}

$(document).ready(function() {
    $.ajax({
        url: "{{ route('admin.api') }}",
        type: "GET",
        success: function(res) {
            if (res.success) {
                $('#api-quote').text('"' + res.quote + '"');
                $('#api-author').text('— ' + res.author);
            }
        },
        error: function() {
            $('#api-quote').text('"Keep up the great spirit in managing the inventory for a brighter business future."');
            $('#api-author').text('— Admin System');
        }
    });

    $('#search-input').on('keyup', function() {
        let keyword = $(this).val().toLowerCase().trim();

        $('#tabel-barang tr').each(function() {
            let namaItem = $(this).find('.item-name').text().toLowerCase();

            if (namaItem.indexOf(keyword) > -1) {
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
                        Item "${$(this).val()}" not found.
                    </td>
                </tr>
            `);
        }
    });
});

$('#form-tambah-barang').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: "{{ route('items.store') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(res) {
            if (res.success) {
                alert(res.message);
                $('#tabel-barang').append(buildRow(res.data));
                $('#form-tambah-barang')[0].reset();
                $('#stat-total').text(parseInt($('#stat-total').text()) + 1);
            }
        },
        error: function(xhr) {
            let msg = '';
            $.each(xhr.responseJSON.errors, function(k, v) { msg += v[0] + '\n'; });
            alert(msg);
        }
    });
});

$(document).on('click', '.btn-edit', function() {
    $('#edit-id').val($(this).data('id'));
    $('#edit-nama').val($(this).data('nama'));
    $('#edit-stok').val($(this).data('stok'));
    $('#edit-harga').val($(this).data('harga'));
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
});

$('#btn-simpan-edit').on('click', function() {
    let id = $('#edit-id').val();
    $.ajax({
        url: `/items/${id}`,
        type: "POST",
        data: {
            _method: 'PUT',
            nama_barang: $('#edit-nama').val(),
            stok: $('#edit-stok').val(),
            harga: $('#edit-harga').val(),
        },
        success: function(res) {
            if (res.success) {
                alert(res.message);
                $(`#item-${res.data.id}`).replaceWith(buildRow(res.data));
                bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide();
            }
        },
        error: function() { alert('Failed to update item.'); }
    });
});

$(document).on('click', '.btn-delete', function() {
    if (!confirm('Delete this item?')) return;
    let id = $(this).data('id');
    $.ajax({
        url: `/items/${id}`,
        type: "POST",
        data: { _method: 'DELETE' },
        success: function(res) {
            if (res.success) {
                alert(res.message);
                $(`#item-${id}`).fadeOut(400, function() {
                    $(this).remove();
                    $('#stat-total').text(parseInt($('#stat-total').text()) - 1);
                });
            }
        },
        error: function() { alert('Failed to delete item.'); }
    });
});
</script>
</body>
</html>