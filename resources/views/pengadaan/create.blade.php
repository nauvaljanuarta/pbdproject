@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Pengadaan barang</h2>
        </div>
    </div>

    <!-- Form Tambah Pengadaan -->
    <div class="row justify-content-center">
        <div class="card col-md-12">
            <h4 class="card-header">Form Pengadaan</h4>
            <div class="card-body">
                <form action="{{ route('add.pengadaan') }}" method="POST">
                    @csrf

                    <!-- Vendor -->
                    <div class="row mb-3">
                        <!-- Vendor -->
                        <div class="col-md-6">
                            <label for="vendor_idvendor" class="form-label">Vendor</label>
                            <select name="id_vendor" id="vendor_idvendor" class="form-control" required>
                                <option value="">Pilih Vendor</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->idvendor }}">{{ $vendor->nama_vendor }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subtotal Nilai -->
                        <div class="col-md-6">
                            <label for="subtotal_nilai" class="form-label">Subtotal Nilai</label>
                            <input type="number" name="subtotal" id="subtotal_nilai" class="form-control" value="0" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- PPN -->
                        <div class="col-md-6">
                            <label for="ppn" class="form-label">PPN (11%)</label>
                            <input type="number" id="ppn" class="form-control" value="0" readonly>
                        </div>

                        <!-- Total Nilai -->
                        <div class="col-md-6">
                            <label for="total_nilai" class="form-label">Total Nilai</label>
                            <input type="number" id="total_nilai" class="form-control" value="0" readonly>
                        </div>
                    </div>

                    <!-- Detail Barang -->
                    <h5 class="mt-4 mb-3">Detail Pengadaan</h5>
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
                                                <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">{{ $barang->nama }}</option>
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

                    <button type="submit" class="btn btn-primary mt-4">Simpan Pengadaan</button>
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
    function updateHargaSatuan(rowIndex) {
        const barangSelect = document.querySelector(`select[name="details[${rowIndex}][idbarang]"]`);
        const hargaSatuanInput = document.querySelector(`input[name="details[${rowIndex}][harga_satuan]"]`);
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        const hargaSatuan = selectedOption ? selectedOption.getAttribute('data-harga') : 0;
        hargaSatuanInput.value = hargaSatuan;
        updateSubTotal(rowIndex);
    }

    function updateSubTotal(rowIndex) {
        const hargaSatuan = parseFloat(document.querySelector(`input[name="details[${rowIndex}][harga_satuan]"]`).value) || 0;
        const jumlah = parseFloat(document.querySelector(`input[name="details[${rowIndex}][jumlah]"]`).value) || 0;
        const subTotal = hargaSatuan * jumlah;
        document.querySelector(`input[name="details[${rowIndex}][sub_total]"]`).value = subTotal;
        updateGrandTotal();
    }

    function updateGrandTotal() {
        let subtotal = 0;
        const rows = document.querySelectorAll('#detail-table tbody tr');
        rows.forEach((row, index) => {
            const subTotal = parseFloat(document.querySelector(`input[name="details[${index}][sub_total]"]`).value) || 0;
            subtotal += subTotal;
        });

        const ppn = subtotal * 0.11; // PPN 11%
        const total = subtotal + ppn;

        document.getElementById('subtotal_nilai').value = subtotal;
        document.getElementById('ppn').value = ppn;
        document.getElementById('total_nilai').value = total;
    }

    document.getElementById('add-detail-row').addEventListener('click', function() {
        let table = document.getElementById('detail-table').getElementsByTagName('tbody')[0];
        let rowCount = table.rows.length;
        let newRow = table.insertRow(rowCount);

        newRow.innerHTML = `
            <td>
                <select name="details[${rowCount}][idbarang]" class="form-control barang-select" required onchange="updateHargaSatuan(${rowCount})">
                    <option value="">Pilih Barang</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">{{ $barang->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="details[${rowCount}][harga_satuan]" class="form-control harga_satuan" required readonly></td>
            <td><input type="number" name="details[${rowCount}][jumlah]" class="form-control jumlah" required oninput="updateSubTotal(${rowCount})"></td>
            <td><input type="number" name="details[${rowCount}][sub_total]" class="form-control sub_total" required readonly></td>
            <td><button type="button" class="btn btn-danger remove-detail-row">Hapus</button></td>
        `;

        const barangSelect = newRow.querySelector('.barang-select');
        const jumlahInput = newRow.querySelector('.jumlah');
        barangSelect.addEventListener('change', function() {
            updateHargaSatuan(rowCount);
        });
        jumlahInput.addEventListener('input', function() {
            updateSubTotal(rowCount);
        });
    });

    document.getElementById('detail-table').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-detail-row')) {
            event.target.closest('tr').remove();
            updateGrandTotal();
        }
    });
</script>
@endsection
