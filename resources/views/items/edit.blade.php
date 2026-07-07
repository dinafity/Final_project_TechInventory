<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Update Product</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('items.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="nama_barang" class="form-control" value="{{ $item->nama_barang }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stok" class="form-control" value="{{ $item->stok }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="harga" class="form-control" value="{{ $item->harga }}" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('items.index') }}" class="btn btn-secondary">cancel</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>