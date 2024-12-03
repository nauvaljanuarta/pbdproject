@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Tambah Pengadaan Baru</h2>
        </div>
    </div>

    <!-- Form Tambah Pengadaan -->
    <div class="row justify-content-center">
        <div class="card col-md-12">
            <h4 class="card-header">Form Pengadaan</h4>
            <div class="card-body">
                <form action="{{ route('add.pengadaan') }}" method="POST">
                    @csrf
                    <!-- User dan Vendor -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="user_iduser" class="form-label">User</label>
                            <select name="user_iduser" id="user_iduser" class="form-control" required>
                                <option value="">Pilih User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->iduser }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="vendor_idvendor" class="form-label">Vendor</label>
                            <select name="vendor_idvendor" id="vendor_idvendor" class="form-control" required>
                                <option value="">Pilih Vendor</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->idvendor }}">{{ $vendor->nama_vendor }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Status, Subtotal, PPN, Total -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="P">Proses</option>
                                <option value="S">Selesai</option>
                                <option value="C">Batal</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="subtotal_nilai" class="form-label">Subtotal Nilai</label>
                            <input type="number" name="subtotal_nilai" id="subtotal_nilai" class="form-control" required readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="ppn" class="form-label">PPN</label>
                            <input type="number" name="ppn" id="ppn" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="total_nilai" class="form-label">Total Nilai</label>
                            <input type="number" name="total_nilai" id="total_nilai" class="form-control" required readonly>
                        </div>
                    </div>

                    <!-- Detail Pengadaan -->
                    <h5 class="mt-4">Detail Pengadaan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="detail-table">
                            <thead>
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
                                        <select name="details[0][idbarang]" class="form-control barang-select" required>
                                            <option value="">Pilih Barang</option>
                                            @foreach($barangs as $barang)
                                                <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">{{ $barang->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="details[0][harga_satuan]" class="form-control harga_satuan" required readonly></td>
                                    <td><input type="number" name="details[0][jumlah]" class="form-control jumlah" required></td>
                                    <td><input type="number" name="details[0][sub_total]" class="form-control sub_total" required readonly></td>
                                    <td><button type="button" class="btn btn-danger remove-detail-row">Hapus</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success" id="add-detail-row">Tambah Detail</button>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Simpan Pengadaan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to update harga_satuan otomatis berdasarkan barang yang dipilih
    function updateHargaSatuan(rowIndex) {
        const barangSelect = document.querySelector(`select[name="details[${rowIndex}][idbarang]"]`);
        const hargaSatuanInput = document.querySelector(`input[name="details[${rowIndex}][harga_satuan]"]`);

        // Ambil harga satuan berdasarkan pilihan barang
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        const hargaSatuan = selectedOption ? selectedOption.getAttribute('data-harga') : 0;
        hargaSatuanInput.value = hargaSatuan;

        updateSubTotal(rowIndex); // Update subtotal setelah harga satuan diperbarui
    }

    // Function to update subtotal per detail row
    function updateSubTotal(rowIndex) {
        const hargaSatuan = parseFloat(document.querySelector(`input[name="details[${rowIndex}][harga_satuan]"]`).value) || 0;
        const jumlah = parseFloat(document.querySelector(`input[name="details[${rowIndex}][jumlah]"]`).value) || 0;
        const subTotal = hargaSatuan * jumlah;
        document.querySelector(`input[name="details[${rowIndex}][sub_total]"]`).value = subTotal;
        updateGrandTotal();
    }

    // Function to update the grand total (subtotal + ppn)
    function updateGrandTotal() {
        let subtotal = 0;
        const rows = document.querySelectorAll('#detail-table tbody tr');
        rows.forEach((row, index) => {
            const subTotal = parseFloat(document.querySelector(`input[name="details[${index}][sub_total]"]`).value) || 0;
            subtotal += subTotal;
        });

        const ppn = parseFloat(document.getElementById('ppn').value) || 0;
        const total = subtotal + ppn;

        document.getElementById('subtotal_nilai').value = subtotal;
        document.getElementById('total_nilai').value = total;
    }

    // Add event listener for dynamic rows
    document.getElementById('add-detail-row').addEventListener('click', function() {
        let table = document.getElementById('detail-table').getElementsByTagName('tbody')[0];
        let rowCount = table.rows.length;
        let newRow = table.insertRow(rowCount);

        newRow.innerHTML = `
            <td>
                <select name="details[${rowCount}][idbarang]" class="form-control barang-select" required>
                    <option value="">Pilih Barang</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">{{ $barang->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="details[${rowCount}][harga_satuan]" class="form-control harga_satuan" required readonly></td>
            <td><input type="number" name="details[${rowCount}][jumlah]" class="form-control jumlah" required></td>
            <td><input type="number" name="details[${rowCount}][sub_total]" class="form-control sub_total" required readonly></td>
            <td><button type="button" class="btn btn-danger remove-detail-row">Hapus</button></td>
        `;

        // Attach event listeners to the new select and inputs
        const barangSelect = newRow.querySelector('select[name="details[' + rowCount + '][idbarang]"]');
        const hargaSatuanInput = newRow.querySelector('input[name="details[' + rowCount + '][harga_satuan]"]');
        const jumlahInput = newRow.querySelector('input[name="details[' + rowCount + '][jumlah]"]');

        barangSelect.addEventListener('change', function() {
            updateHargaSatuan(rowCount);
        });

        jumlahInput.addEventListener('input', function() {
            updateSubTotal(rowCount);
        });
    });

    // Handle the removal of detail rows
    document.getElementById('detail-table').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-detail-row')) {
            event.target.closest('tr').remove();
            updateGrandTotal();
        }
    });

    // Initialize event listeners for existing rows
    document.querySelectorAll('.barang-select').forEach((select, index) => {
        select.addEventListener('change', function() {
            updateHargaSatuan(index);
        });
    });

    document.querySelectorAll('.jumlah').forEach((input, index) => {
        input.addEventListener('input', function() {
            updateSubTotal(index);
        });
    });
</script>

@endsection
