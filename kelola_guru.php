<?php
require_once 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 1. PROSES SIMPAN (TAMBAH / EDIT)
if (isset($_POST['simpan'])) {
    $id = $_POST['id'] ?? '';
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip'] ?? '');
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
    $email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
    $status = (isset($_POST['status_aktif']) && $_POST['status_aktif'] == 'Aktif') ? 1 : 0;
    $password = $_POST['password'] ?? '';
    $konfirmasi = $_POST['konfirmasi_password'] ?? '';

    if (!empty($password) && $password !== $konfirmasi) {
        echo "<script>alert('Konfirmasi password tidak cocok!'); window.history.back();</script>";
        exit();
    }
    
    if (!empty($id)) {
        $d_old = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT user_id FROM t_guru WHERE id='$id'"));
        mysqli_query($koneksi, "UPDATE t_guru SET nip='$nip', nama='$nama', email='$email', status_aktif='$status' WHERE id='$id'");
        
        if (!empty($d_old['user_id'])) {
            $pass_query = !empty($password) ? ", password='".password_hash($password, PASSWORD_DEFAULT)."'" : "";
            mysqli_query($koneksi, "UPDATE t_users SET name='$nama', email='$email' $pass_query WHERE id='{$d_old['user_id']}'");
        }
    } else {
        $hashed = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : password_hash('123456', PASSWORD_DEFAULT);
        mysqli_query($koneksi, "INSERT INTO t_users (name, email, password, role) VALUES ('$nama', '$email', '$hashed', 'guru')");
        $user_id_baru = mysqli_insert_id($koneksi);
        mysqli_query($koneksi, "INSERT INTO t_guru (nip, nama, email, status_aktif, user_id) VALUES ('$nip', '$nama', '$email', '$status', '$user_id_baru')");
    }
    header("Location: kelola_guru.php");
    exit();
}

// 2. PROSES HAPUS (MEMBERSIHKAN RELASI)
if (isset($_GET['hapus'])) {
    $id_guru = (int)$_GET['hapus'];
    $get_guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT user_id FROM t_guru WHERE id='$id_guru'"));
    
    mysqli_query($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE guru_id='$id_guru'");
    mysqli_query($koneksi, "DELETE FROM t_wali_kelas WHERE guru_id='$id_guru'");
    mysqli_query($koneksi, "DELETE FROM t_guru WHERE id='$id_guru'");
    if (!empty($get_guru['user_id'])) {
        mysqli_query($koneksi, "DELETE FROM t_users WHERE id='{$get_guru['user_id']}'");
    }
    header("Location: kelola_guru.php");
    exit();
}

// AMBIL DATA UNTUK EDIT
$edit_id = $_GET['edit'] ?? '';
$edit = $edit_id ? mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM t_guru WHERE id='$edit_id'")) : null;

// AMBIL SEMUA DATA GURU
$data = mysqli_query($koneksi, "SELECT * FROM t_guru ORDER BY nama ASC");
if (!$data) {
    die("Gagal mengambil data guru: " . htmlspecialchars(mysqli_error($koneksi)));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Guru</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            color: #fff;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            overflow-y: auto;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            color: #fff;
            background-color: #0d6efd;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-width: 0;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar d-flex flex-column p-3">
    <h4 class="text-white mb-4">Pelanggaran Siswa</h4>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1"><a href="dashboard.php">Dashboard</a></li>
        <li class="nav-item mb-1"><a href="kelola_guru.php" class="active">Kelola Guru</a></li>
        <li class="nav-item mb-1"><a href="kelola_siswa.php">Kelola Siswa</a></li>
        <li class="nav-item mb-1"><a href="kelola_kelas.php">Kelola Kelas</a></li>
        <li class="nav-item mb-1"><a href="kelola_tahun_ajaran.php">Kelola Tahun Ajaran</a></li>
        <li class="nav-item mb-1"><a href="penempatan_siswa.php">Penempatan Siswa</a></li>
        <li class="nav-item mb-1"><a href="kelola_wali_kelas.php">Kelola Wali Kelas</a></li>
        <li class="nav-item mb-1"><a href="kelola_kategori_pelanggaran.php">Kelola Kategori Pelanggaran</a></li>
        <li class="nav-item mb-1"><a href="kelola_jenis_pelanggaran.php">Kelola Jenis Pelanggaran</a></li>
         <li class="nav-item mb-1"><a href="laporan.php">Laporan</a></li>
        <li class="nav-item mb-1"><a href="about_me.php">About Me</a></li>
        
    </ul>
    <hr>
    <a href="logout.php" class="text-danger">Logout</a>
</div>

<!-- KONTEN UTAMA -->
  <div class="main-content">
        <h2>Kelola Guru</h2>
        <div class="mb-3">
    </div>
    <!-- FORM TAMBAH / EDIT DATA GURU -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <?= $edit ? 'Edit Data Guru' : 'Tambah Data Guru'; ?>
        </div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($edit['id'] ?? ''); ?>">

                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" 
                           value="<?= htmlspecialchars($edit['nip'] ?? ''); ?>" 
                           maxlength="18" 
                           oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18)" 
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" 
                           value="<?= htmlspecialchars($edit['nama'] ?? ''); ?>" 
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?= htmlspecialchars($edit['email'] ?? ''); ?>" 
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" 
                           placeholder="<?= $edit ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password'; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="konfirmasi_password" class="form-control" 
                           placeholder="Ulangi password">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Aktif</label>
                    <select name="status_aktif" class="form-control" required>
                        <option value="Aktif" <?= (($edit['status_aktif'] ?? 1) == 1) ? 'selected' : ''; ?>>Aktif</option>
                        <option value="Tidak Aktif" <?= (($edit['status_aktif'] ?? 1) == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary">
                    <?= $edit ? 'Update Data' : 'Simpan'; ?>
                </button>

                <?php if ($edit): ?>
                    <a href="kelola_guru.php" class="btn btn-secondary">Batal</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- TABEL DATA GURU -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Data Guru
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelGuru" class="table table-bordered table-striped table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php while ($r = mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($r['nip'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($r['nama'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($r['email'] ?? ''); ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="kelola_guru.php?edit=<?= (int)$r['id']; ?>" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <a href="kelola_guru.php?hapus=<?= (int)$r['id']; ?>" class="btn btn-sm btn-danger"
                                           onclick="return confirm('Yakin ingin menghapus data guru ini?')">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
$(document).ready(function () {
    $('#tabelGuru').DataTable({
        language: {
            search: "Cari data:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data guru",
            infoEmpty: "Tidak ada data guru",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data guru tidak ditemukan",
            emptyTable: "Belum ada data guru",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[2, 'asc']],
        columnDefs: [
            {
                targets: 4,
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>

</body>
</html>