<?php
// Mulai session dan hubungkan ke database
require_once 'koneksi.php';

// 1. Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$nama_user = isset($_SESSION['nama_user']) ? $_SESSION['nama_user'] : (isset($_SESSION['name']) ? $_SESSION['name'] : '');
$is_wali_kelas = isset($_SESSION['is_wali_kelas']) && $_SESSION['is_wali_kelas'] === true;

// 2. Proteksi Akses: Jika role adalah guru, tapi bukan wali kelas, tolak aksesnya
if ($role === 'guru' && !$is_wali_kelas) {
    echo "<script>alert('Akses ditolak! Menu laporan ini hanya untuk Admin dan Wali Kelas.'); window.location='dashboard.php';</script>";
    exit();
}

// 3. Logika Query Laporan Berdasarkan Hak Akses (Admin vs Wali Kelas)
if ($role === 'admin') {
    // Admin dapat melihat seluruh laporan pelanggaran
    $query_laporan = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_siswa ORDER BY tanggal DESC");
    $nama_kelas_binaan = '';
} else {
    // Wali Kelas hanya melihat laporan pelanggaran siswa di kelas yang diampunya
    $q_kelas_wali = mysqli_query($koneksi, "
        SELECT k.nama AS nama_kelas 
        FROM t_wali_kelas tw
        JOIN t_kelas k ON tw.kelas_id = k.id
        JOIN t_guru g ON tw.guru_id = g.id
        WHERE (g.user_id = '$user_id' OR g.nama LIKE '%$nama_user%') AND tw.status_aktif = 1
        LIMIT 1
    ");
    
    $nama_kelas_binaan = '';
    if ($row_wk = mysqli_fetch_assoc($q_kelas_wali)) {
        $nama_kelas_binaan = $row_wk['nama_kelas'];
    }

    // Query filter berdasarkan nama kelas binaan wali kelas
    $query_laporan = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_siswa WHERE nama_kelas = '$nama_kelas_binaan' ORDER BY tanggal DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pelanggaran Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: #fff; position: fixed; width: 250px; top: 0; left: 0; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 10px 20px; }
        .sidebar a:hover, .sidebar a.active { color: #fff; background: #0d6efd; }
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Dinamis Berdasarkan Role -->
        <div class="sidebar d-flex flex-column p-3">
            <h4 class="text-white mb-4">Pelanggaran Siswa</h4>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-1"><a href="dashboard.php">Dashboard</a></li>

                <?php if ($role === 'admin'): ?>
                    <!-- Menu Khusus Admin -->
                    <li class="nav-item mb-1"><a href="kelola_guru.php">Kelola Guru</a></li>
                    <li class="nav-item mb-1"><a href="kelola_siswa.php">Kelola Siswa</a></li>
                    <li class="nav-item mb-1"><a href="kelola_kelas.php">Kelola Kelas</a></li>
                    <li class="nav-item mb-1"><a href="kelola_tahun_ajaran.php">Kelola Tahun Ajaran</a></li>
                    <li class="nav-item mb-1"><a href="penempatan_siswa.php">Penempatan Siswa</a></li>
                    <li class="nav-item mb-1"><a href="kelola_wali_kelas.php">Kelola Wali Kelas</a></li>
                    <li class="nav-item mb-1"><a href="kelola_kategori_pelanggaran.php">Kelola Kategori Pelanggaran</a></li>
                    <li class="nav-item mb-1"><a href="kelola_jenis_pelanggaran.php">Kelola Jenis Pelanggaran</a></li>
                    <li class="nav-item mb-1"><a href="laporan.php" class="active">Laporan</a></li>
                <?php endif; ?>

                <?php if ($role === 'guru'): ?>
                    <!-- Menu Standar Guru + Menu Laporan Khusus Wali Kelas -->
                    <li class="nav-item mb-1"><a href="catat_pelanggaran.php">Catat Pelanggaran</a></li>
                    <li class="nav-item mb-1"><a href="tindakan.php">Tindakan</a></li>
                    <li class="nav-item mb-1"><a href="riwayat.php">Riwayat</a></li>
                    <li class="nav-item mb-1"><a href="rekap_poin.php">Rekap Poin</a></li>
                    
                    <?php if ($is_wali_kelas): ?>
                        <li class="nav-item mb-1"><a href="laporan.php" class="active">Laporan</a></li>
                    <?php endif; ?>
                <?php endif; ?>

                <li class="nav-item mb-1"><a href="about_me.php">About Me</a></li>
            </ul>
            <hr><a href="logout.php" class="text-danger">Logout</a>
        </div>

        <!-- Konten Utama Laporan -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Halaman Laporan Pelanggaran Siswa</h2>
                <span class="badge bg-secondary">Login sebagai: <?= htmlspecialchars($nama_user); ?> (<?= ucfirst($role); ?>)</span>
            </div>

            <?php if ($role !== 'admin' && !empty($nama_kelas_binaan)): ?>
                <div class="alert alert-info">
                    Menampilkan laporan khusus kelas binaan Anda: <strong><?= htmlspecialchars($nama_kelas_binaan); ?></strong>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Rekapitulasi Data Pelanggaran</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Pencatat (Guru)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($query_laporan && mysqli_num_rows($query_laporan) > 0): ?>
                                    <?php $no = 1; while ($row = mysqli_fetch_assoc($query_laporan)): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['tanggal']; ?></td>
                                            <td><?= htmlspecialchars($row['nama_siswa']); ?></td>
                                            <td><?= htmlspecialchars($row['nama_kelas']); ?></td>
                                            <td><?= htmlspecialchars($row['nama_pelanggaran']); ?></td>
                                            <td><span class="badge bg-danger"><?= $row['poin']; ?></span></td>
                                            <td><?= htmlspecialchars($row['nama_guru']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada data laporan pelanggaran untuk kelas ini.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>