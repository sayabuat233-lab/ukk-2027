<?php
require_once 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// PROSES SIMPAN
if (isset($_POST['simpan'])) {
    $id = $_POST['id'] ?? '';
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $status = $_POST['status_aktif'] == 'Aktif' ? 1 : 0;

    if ($id) {
        mysqli_query($koneksi, "UPDATE t_kelas SET nama='$nama', tingkat='$tingkat', jurusan='$jurusan', status_aktif='$status', updated_at=NOW() WHERE id='$id'");
    } else {
        mysqli_query($koneksi, "INSERT INTO t_kelas (nama, tingkat, jurusan, status_aktif, created_at, updated_at) VALUES ('$nama', '$tingkat', '$jurusan', '$status', NOW(), NOW())");
    }

    header("Location: kelola_kelas.php");
    exit();
}

// PROSES HAPUS
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    mysqli_query($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE kelas_id='$id'");
    mysqli_query($koneksi, "DELETE FROM t_kelas_siswa WHERE kelas_id='$id'");
    mysqli_query($koneksi, "DELETE FROM t_wali_kelas WHERE kelas_id='$id'");
    mysqli_query($koneksi, "DELETE FROM t_kelas WHERE id='$id'");

    header("Location: kelola_kelas.php");
    exit();
}

// DATA EDIT
$edit_id = $_GET['edit'] ?? '';
$edit = $edit_id ? mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM t_kelas WHERE id='$edit_id'")) : null;

// AMBIL DATA KELAS (Diurutkan berdasarkan id ASC agar data input terakhir muncul di paling bawah)
$data = mysqli_query($koneksi, "SELECT * FROM t_kelas ORDER BY id ASC");

if (!$data) {
    die("Gagal mengambil data: " . htmlspecialchars(mysqli_error($koneksi)));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kelas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <li class="nav-item mb-1"><a href="kelola_guru.php">Kelola Guru</a></li>
        <li class="nav-item mb-1"><a href="kelola_siswa.php">Kelola Siswa</a></li>
        <li class="nav-item mb-1"><a href="kelola_kelas.php" class="active">Kelola Kelas</a></li>
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

    <h2>Kelola Kelas</h2>

    <div class="mb-3"></div>

    <!-- FORM TAMBAH / EDIT -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <?= $edit ? 'Edit Data Kelas' : 'Tambah Data Kelas'; ?>
        </div>

        <div class="card-body">
            <form method="POST">

                <input type="hidden" name="id" value="<?= htmlspecialchars($edit['id'] ?? ''); ?>">

                <!-- DROPDOWN TINGKAT -->
                <div class="mb-3">
                    <label class="form-label">Tingkat</label>
                    <select name="tingkat" class="form-select" required>
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="X" <?= (($edit['tingkat'] ?? '') == 'X') ? 'selected' : ''; ?>>X</option>
                        <option value="XI" <?= (($edit['tingkat'] ?? '') == 'XI') ? 'selected' : ''; ?>>XI</option>
                        <option value="XII" <?= (($edit['tingkat'] ?? '') == 'XII') ? 'selected' : ''; ?>>XII</option>
                    </select>
                </div>

                <!-- DROPDOWN NAMA KELAS -->
                <div class="mb-3">
                    <label class="form-label">Nama Kelas</label>
                    <select name="nama" class="form-select" required>
                        <option value="">-- Pilih Nama Kelas --</option>
                        <option value="X RPL 1" <?= (($edit['nama'] ?? '') == 'X RPL 1') ? 'selected' : ''; ?>>RPL 1</option>
                        <option value="X TKR 2" <?= (($edit['nama'] ?? '') == 'X TKR 2') ? 'selected' : ''; ?>>TKR 2</option>
                        <option value="XI RPL 1" <?= (($edit['nama'] ?? '') == 'XI RPL 1') ? 'selected' : ''; ?>> RPL 1</option>
                        <option value="XI DB 2" <?= (($edit['nama'] ?? '') == 'XI DB 2') ? 'selected' : ''; ?>> DB 2</option>
                        <option value="XII RPL 1" <?= (($edit['nama'] ?? '') == 'XII RPL 1') ? 'selected' : ''; ?>> RPL 1</option>
                        <option value="XII TSM 2" <?= (($edit['nama'] ?? '') == 'XII TSM 2') ? 'selected' : ''; ?>>TSM 2</option>
                        <option value="X TKJ 1" <?= (($edit['nama'] ?? '') == 'X TKJ 1') ? 'selected' : ''; ?>>TKJ 1</option>
                        <option value="XI TKJ 1" <?= (($edit['nama'] ?? '') == 'XI TKJ 1') ? 'selected' : ''; ?>> TKJ 1</option>
                        <option value="XII TKJ 1" <?= (($edit['nama'] ?? '') == 'XII TKJ 1') ? 'selected' : ''; ?>> TKJ 1</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jurusan</label>
                    <input type="text" name="jurusan" class="form-control"
                        value="<?= htmlspecialchars($edit['jurusan'] ?? ''); ?>"
                        placeholder="Contoh: RPL" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Aktif</label>
                    <select name="status_aktif" class="form-select" required>
                        <option value="Aktif" <?= (($edit['status_aktif'] ?? 1) == 1) ? 'selected' : ''; ?>>
                            Aktif
                        </option>
                        <option value="Tidak Aktif" <?= (($edit['status_aktif'] ?? 1) == 0) ? 'selected' : ''; ?>>
                            Tidak Aktif
                        </option>
                    </select>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary">
                    <?= $edit ? 'Update Data' : 'Simpan'; ?>
                </button>

                <?php if ($edit): ?>
                    <a href="kelola_kelas.php" class="btn btn-secondary">Batal</a>
                <?php endif; ?>

            </form>
        </div>
    </div>

    <!-- TABEL DATA KELAS -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Data Kelas
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table id="tabelKelas" class="table table-bordered table-striped table-hover align-middle w-100">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; ?>
                        <?php while ($r = mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($r['nama']); ?></td>
                                <td><?= htmlspecialchars($r['tingkat']); ?></td>
                                <td><?= htmlspecialchars($r['jurusan']); ?></td>

                                <td>
                                    <span class="badge bg-<?= $r['status_aktif'] == 1 ? 'success' : 'secondary'; ?>">
                                        <?= $r['status_aktif'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="kelola_kelas.php?edit=<?= (int)$r['id']; ?>"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <a href="kelola_kelas.php?hapus=<?= (int)$r['id']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus kelas ini?')">
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

<!-- JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#tabelKelas').DataTable({
        language: {
            search: "Cari data:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data kelas",
            infoEmpty: "Tidak ada data kelas",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data kelas tidak ditemukan",
            emptyTable: "Belum ada data kelas",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[0, 'asc']], // Diurutkan berdasarkan kolom No (urutan ID dari database)
        columnDefs: [{
            targets: 5,
            orderable: false,
            searchable: false
        }]
    });
});
</script>

</body>
</html>