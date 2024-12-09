@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Tambah Penjualan</h2>
        </div>
    </div>

    <!-- Form Tambah Penjualan -->
    <div class="row justify-content-center">
        <div class="card col-md-12">
            <h4 class="card-header">Form Penjualan</h4>
            <div class="card-body">
                <form action="{{ route('add.penjualan') }}" method="POST">
                    @csrf

                    <!-- Margin Penjualan -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="idmargin_penjualan" class="form-label">Margin Penjualan</label>
                            <select name="idmargin_penjualan" id="idmargin_penjualan" class="form-control" required onchange="updateGrandTotal()">
                                <option value="">Pilih Margin</option>
                                @foreach($margins as $margin)
                                    <option value="{{ $margin->idmargin_penjualan }}" data-margin="{{ $margin->persen }}">
                                        {{ $margin->persen }} %
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subtotal -->
                        <div class="col-md-6">
                            <label for="subtotal" class="form-label">Subtotal</label>
                            <input type="number" name="subtotal" id="subtotal" class="form-control" value="0" readonly>
                        </div>
                    </div>

                    <!-- PPN -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ppn" class="form-label">PPN (11%)</label>
                            <input type="number" name="ppn" id="ppn" class="form-control" value="0" readonly>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" name="total" id="total" class="form-control" value="0" readonly>
                        </div>
                    </div>

                    <!-- Detail Barang -->
                    <h5 class="mt-4 mb-3">Detail Penjualan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="detail-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Barang</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="details[0][idbarang]" class="form-control barang-select" required onchange="updateHargaSatuan(0)">
                                            <option value="">Pilih Barang</option>
                                            @foreach($barangs as $barang)
                                                <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">
                                                    {{ $barang->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="details[0][harga_satuan]" class="form-control harga_satuan" required readonly></td>
                                    <td><input type="number" name="details[0][jumlah]" class="form-control jumlah" required oninput="updateSubTotal(0)"></td>
                                    <td><input type="number" name="details[0][sub_total]" class="form-control sub_total" required readonly></td>
                                    <td><button type="button" class="btn btn-danger remove-detail-row">Hapus</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <button type="button" class="btn btn-success" id="add-detail-row">Tambah Detail</button>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Simpan Penjualan</button>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
    // Update Harga Satuan
    function updateHargaSatuan(rowIndex) {
        const barangSelect = document.querySelector(`select[name="details[${rowIndex}][idbarang]"]`);
        const hargaSatuanInput = document.querySelector(`input[name="details[${rowIndex}][harga_satuan]"]`);
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        const hargaSatuan = selectedOption ? parseFloat(selectedOption.getAttribute('data-harga')) : 0;
        hargaSatuanInput.value = hargaSatuan;
        updateSubTotal(rowIndex);
    }

    // Update Subtotal per Barang
    function updateSubTotal(rowIndex) {
        const hargaSatuan = parseFloat(document.querySelector(`input[name="details[${rowIndex}][harga_satuan]"]`).value) || 0;
        const jumlah = parseFloat(document.querySelector(`input[name="details[${rowIndex}][jumlah]"]`).value) || 0;
        const subTotal = hargaSatuan * jumlah;
        document.querySelector(`input[name="details[${rowIndex}][sub_total]"]`).value = subTotal;
        updateGrandTotal();
    }

    // Update Grand Total
    function updateGrandTotal() {
        let subtotal = 0;
        const rows = document.querySelectorAll('#detail-table tbody tr');

        rows.forEach((row, index) => {
            const subTotal = parseFloat(document.querySelector(`input[name="details[${index}][sub_total]"]`).value) || 0;
            subtotal += subTotal;
        });

        const marginSelect = document.getElementById('idmargin_penjualan');
        const selectedMargin = marginSelect.options[marginSelect.selectedIndex];
        const marginPersen = selectedMargin ? parseFloat(selectedMargin.getAttribute('data-margin')) : 0;

        const marginValue = (subtotal * marginPersen) / 100;

        // Hitung PPN 11%
        const ppn = (subtotal * 11) / 100;

        // Hitung Total (Subtotal + Margin + PPN)
        const total = subtotal + marginValue + ppn;

        document.getElementById('subtotal').value = subtotal.toFixed(2);
        document.getElementById('ppn').value = ppn.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }

    // Tambah Baris Detail
    document.getElementById('add-detail-row').addEventListener('click', function() {
        const table = document.getElementById('detail-table').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
        const newRow = table.insertRow(rowCount);

        newRow.innerHTML = `
            <td>
                <select name="details[${rowCount}][idbarang]" class="form-control barang-select" required onchange="updateHargaSatuan(${rowCount})">
                    <option value="">Pilih Barang</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">
                            {{ $barang->nama }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="details[${rowCount}][harga_satuan]" class="form-control harga_satuan" required readonly></td>
            <td><input type="number" name="details[${rowCount}][jumlah]" class="form-control jumlah" required oninput="updateSubTotal(${rowCount})"></td>
            <td><input type="number" name="details[${rowCount}][sub_total]" class="form-control sub_total" required readonly></td>
            <td><button type="button" class="btn btn-danger remove-detail-row">Hapus</button></td>
        `;
    });

    // Hapus Baris Detail
    document.getElementById('detail-table').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-detail-row')) {
            event.target.closest('tr').remove();
            updateGrandTotal();
        }
    });
</script>
@endsection
