<?php
require_once 'koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'] ?? 'user';
$nama = $_SESSION['name'] ?? ($_SESSION['nama_user'] ?? ($_SESSION['nama'] ?? 'Pengguna'));
$db = isset($conn) ? $conn : $koneksi;

// Deteksi otomatis apakah akun adalah Aldi / Wali Kelas aktif di database
$display_role = $role;
if ($role === 'guru') {
    $user_id = (int)$_SESSION['user_id'];
    $q_wk = mysqli_query($db, "SELECT wk.id FROM t_wali_kelas wk JOIN t_guru g ON wk.guru_id = g.id WHERE g.user_id = $user_id AND wk.status_aktif = 1 LIMIT 1");
    if (($q_wk && mysqli_num_rows($q_wk) > 0) || stripos($nama, 'Aldi') !== false) {
        $display_role = 'wali_kelas';
    }
}

// Menghitung jumlah data dari database
$query_siswa = mysqli_query($db, "SELECT COUNT(*) AS total FROM t_siswa");
$query_guru  = mysqli_query($db, "SELECT COUNT(*) AS total FROM t_guru");
$query_kelas = mysqli_query($db, "SELECT COUNT(*) AS total FROM t_kelas");

$total_siswa = $query_siswa ? (int) mysqli_fetch_assoc($query_siswa)['total'] : 0;
$total_guru = $query_guru ? (int) mysqli_fetch_assoc($query_guru)['total'] : 0;
$total_kelas = $query_kelas ? (int) mysqli_fetch_assoc($query_kelas)['total'] : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #212529; color: #fff; position: fixed; width: 250px; top: 0; left: 0; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 10px 20px; }
        .sidebar a:hover, .sidebar a.active { color: #fff; background-color: #0d6efd; }
        .main-content { margin-left: 250px; padding: 20px; }
        .card { border-radius: 6px; }
        .card h2 { margin-bottom: 0; }
        @media (max-width: 768px) {
            .sidebar { width: 200px; }
            .main-content { margin-left: 200px; padding: 12px; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column p-3">
        <h4 class="text-white mb-4">Pelanggaran Siswa</h4>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                <a href="dashboard.php" class="active">Dashboard</a>
            </li>

            <?php if ($role === 'admin'): ?>
                <li class="nav-item mb-1"><a href="kelola_guru.php">Kelola Guru</a></li>
                <li class="nav-item mb-1"><a href="kelola_siswa.php">Kelola Siswa</a></li>
                <li class="nav-item mb-1"><a href="kelola_kelas.php">Kelola Kelas</a></li>
                <li class="nav-item mb-1"><a href="kelola_tahun_ajaran.php">Kelola Tahun Ajaran</a></li>
                <li class="nav-item mb-1"><a href="penempatan_siswa.php">Penempatan Siswa</a></li>
                <li class="nav-item mb-1"><a href="kelola_wali_kelas.php">Kelola Wali Kelas</a></li>
                <li class="nav-item mb-1"><a href="kelola_kategori_pelanggaran.php">Kelola Kategori Pelanggaran</a></li>
                <li class="nav-item mb-1"><a href="kelola_jenis_pelanggaran.php">Kelola Jenis Pelanggaran</a></li>
                <li class="nav-item mb-1"><a href="laporan.php">Laporan</a></li>
                <li class="nav-item mb-1"><a href="about_me.php">About Me</a></li>
            <?php endif; ?>

            <?php if ($role === 'guru' || $display_role === 'wali_kelas'): ?>
                <li class="nav-item mb-1"><a href="catat_pelanggaran.php">Catat Pelanggaran</a></li>
                <li class="nav-item mb-1"><a href="tindakan.php">Tindakan</a></li>
                <li class="nav-item mb-1"><a href="riwayat.php">Riwayat</a></li>
                <li class="nav-item mb-1"><a href="rekap_poin.php">Rekap Poin</a></li>
                <li class="nav-item mb-1"><a href="laporan.php">Laporan</a></li>
                <li class="nav-item mb-1"><a href="about_me.php">About Me</a></li>
            <?php endif; ?>
            
        </ul>
        <hr>
        <a href="logout.php" class="text-danger">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h2>Dashboard</h2>
        <p>
            Pengguna: <strong><?= htmlspecialchars($nama); ?></strong> | 
            Akses: <strong><?= strtoupper(htmlspecialchars($display_role === 'wali_kelas' ? 'Wali Kelas' : $role)); ?></strong>
        </p>
        <hr>

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Data Siswa</h5>
                        <h2><?= $total_siswa; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Data Guru</h5>
                        <h2><?= $total_guru; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Kelas</h5>
                        <h2><?= $total_kelas; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>