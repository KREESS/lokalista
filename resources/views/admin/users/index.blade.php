@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Manajemen User</h4>

    <!-- ========================= TABEL ADMIN ========================= -->
    <h5>Daftar Admin</h5>
    <!-- Tombol Tambah Admin -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Admin</button>

    <div class="mb-2">
        <input type="text" id="searchAdmin" class="form-control" placeholder="Cari admin...">
    </div>

    <div class="table-responsive">
        <table class="table" id="table-admin">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users->where('type', 'admin')->values() as $i => $user)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->type) }}</td>
                    <td>
                        @if($user->is_active)
                        <span class="badge bg-success">Sedang Aktif</span>
                        @else
                        <span class="badge bg-secondary">Offline</span>
                        @endif
                    </td>
                    <td>
                        <!-- Tombol Edit -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#modalEdit{{ $user->id }}">Edit</button>

                        <!-- Modal Edit Admin -->
                        <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Admin</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Nama</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Password <small>(biarkan kosong jika tidak diganti)</small></label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin hapus admin?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ========================= TABEL CUSTOMER ========================= -->
    <h5 class="mt-5">Daftar Customer</h5>

    <div class="mb-2">
        <input type="text" id="searchCustomer" class="form-control" placeholder="Cari customer...">
    </div>

    <div class="table-responsive">
        <table class="table" id="table-customer">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users->where('type', 'customer')->values() as $i => $user)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->type) }}</td>
                    <td>
                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                            {{ $user->is_active ? 'Aktif' : 'Blokir' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-success' }}">
                                {{ $user->is_active ? 'Blokir' : 'Aktifkan' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Admin -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchAdmin = document.getElementById("searchAdmin");
        const adminTable = document.querySelector("#table-admin tbody");

        searchAdmin.addEventListener("keyup", function () {
            const value = this.value.toLowerCase();
            const rows = adminTable.querySelectorAll("tr");
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
            });
        });

        const searchCustomer = document.getElementById("searchCustomer");
        const customerTable = document.querySelector("#table-customer tbody");

        searchCustomer.addEventListener("keyup", function () {
            const value = this.value.toLowerCase();
            const rows = customerTable.querySelectorAll("tr");
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
            });
        });
    });
</script>
@endpush
