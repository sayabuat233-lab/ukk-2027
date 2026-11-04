<?php
require_once 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil filter jika ada
$tgl_mulai = $_GET['tgl_mulai'] ?? '';
$tgl_selesai = $_GET['tgl_selesai'] ?? '';
$kelas_id = $_GET['kelas_id'] ?? '';

// Query dasar untuk laporan pelanggaran siswa
$query = "SELECT p.*, s.nis, k.nama AS nama_kelas_rel 
          FROM t_pelanggaran_siswa p
          LEFT JOIN t_siswa s ON p.siswa_id = s.id
          LEFT JOIN t_kelas k ON p.kelas_id = k.id WHERE 1=1";

if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
    $query .= " AND p.tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
}

if (!empty($kelas_id)) {
    $query .= " AND p.kelas_id = '$kelas_id'";
}

$query .= " ORDER BY p.id ASC";
$data_laporan = mysqli_query($koneksi, $query);

if (!$data_laporan) {
    die("Gagal mengambil data laporan: " . htmlspecialchars(mysqli_error($koneksi)));
}

// Ambil data kelas untuk dropdown filter
$data_kelas = mysqli_query($koneksi, "SELECT * FROM t_kelas ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggaran Siswa</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #212529; color: #fff; position: fixed; width: 250px; top: 0; left: 0; overflow-y: auto; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 10px 20px; border-radius: 5px; }
        .sidebar a:hover, .sidebar a.active { color: #fff; background-color: #0d6efd; }
        .main-content { margin-left: 250px; padding: 20px; min-width: 0; }
        @media (max-width: 767.98px) {
            .sidebar { position: relative; width: 100%; min-height: auto; }
            .main-content { margin-left: 0; }
            .no-print { display: none !important; }
        }
        @media print {
            .sidebar, .no-print, .card-header, form { display: none !important; }
            .main-content { margin-left: 0 !important; padding: 0 !important; }
            body { background-color: white !important; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar d-flex flex-column p-3 no-print">
    <h4 class="text-white mb-4">Pelanggaran Siswa</h4>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1"><a href="dashboard.php">Dashboard</a></li>
        <li class="nav-item mb-1"><a href="kelola_guru.php">Kelola Guru</a></li>
        <li class="nav-item mb-1"><a href="kelola_siswa.php">Kelola Siswa</a></li>
        <li class="nav-item mb-1"><a href="kelola_kelas.php">Kelola Kelas</a></li>
        <li class="nav-item mb-1"><a href="kelola_tahun_ajaran.php">Kelola Tahun Ajaran</a></li>
        <li class="nav-item mb-1"><a href="penempatan_siswa.php">Penempatan Siswa</a></li>
        <li class="nav-item mb-1"><a href="kelola_wali_kelas.php">Kelola Wali Kelas</a></li>
        <li class="nav-item mb-1"><a href="kelola_kategori_pelanggaran.php">Kelola Kategori Pelanggaran</a></li>
        <li class="nav-item mb-1"><a href="kelola_jenis_pelanggaran.php">Kelola Jenis Pelanggaran</a></li>
        <li class="nav-item mb-1"><a href="laporan.php" class="active">Laporan</a></li>
        <li class="nav-item mb-1"><a href="about_me.php">About Me</a></li>
    </ul>
    <hr>
    <a href="logout.php" class="text-danger">Logout</a>
</div>

<!-- KONTEN UTAMA -->
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Laporan Pelanggaran Siswa</h2>
        <button onclick="window.print()" class="btn btn-success no-print">Cetak Laporan</button>
    </div>

    <!-- FILTER FORM -->
    <div class="card shadow-sm mb-4 no-print">
        <div class="card-header bg-primary text-white">Filter Laporan</div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="<?= htmlspecialchars($tgl_mulai); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="<?= htmlspecialchars($tgl_selesai); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-control">
                        <option value="">Semua Kelas</option>
                        <?php while ($k = mysqli_fetch_assoc($data_kelas)): ?>
                            <option value="<?= $k['id']; ?>" <?= ($kelas_id == $k['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($k['nama']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL LAPORAN -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Data Laporan Pelanggaran</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelLaporan" class="table table-bordered table-striped table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Pelanggaran</th>
                            <th>Poin</th>
                            <th>Guru Pelapor</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($data_laporan)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['tanggal'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($row['nis'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($row['nama_siswa'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($row['nama_kelas'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($row['nama_pelanggaran'] ?? ''); ?></td>
                                <td><span class="badge bg-danger"><?= htmlspecialchars($row['poin'] ?? 0); ?></span></td>
                                <td><?= htmlspecialchars($row['nama_guru'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($row['tindakan'] ?? '-'); ?></td>
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

<script>
$(document).ready(function () {
    $('#tabelLaporan').DataTable({
        language: {
            search: "Cari data:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data laporan",
            infoEmpty: "Tidak ada data laporan",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data laporan tidak ditemukan",
            emptyTable: "Belum ada data laporan",
            paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" }
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[0, 'asc']] // Diurutkan berdasarkan kolom No secara Ascending (sesuai id ASC dari database)
    });
});
</script>

</body>
</html>