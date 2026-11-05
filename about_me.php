
<?php
require_once 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$nama = "Sherly Satriani";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Me</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #212529;
            color: white;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
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
            color: white;
            background: #0d6efd;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .profile-card {
            max-width: 800px;
            margin: 10px 0;
        }

        @media(max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
                padding: 12px;
            }
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar d-flex flex-column p-3">
    <h4 class="text-white mb-4">Pelanggaran Siswa</h4>

    <ul class="nav nav-pills flex-column mb-auto">

        <li class="nav-item mb-1">
            <a href="dashboard.php">Dashboard</a>
        </li>

        <?php if ($role === 'admin'): ?>

            <li class="nav-item mb-1">
                <a href="kelola_guru.php">Kelola Guru</a>
            </li>

            <li class="nav-item mb-1">
                <a href="kelola_siswa.php">Kelola Siswa</a>
            </li>

            <li class="nav-item mb-1">
                <a href="kelola_kelas.php">Kelola Kelas</a>
            </li>

            <li class="nav-item mb-1">
                <a href="kelola_tahun_ajaran.php">Kelola Tahun Ajaran</a>
            </li>

            <li class="nav-item mb-1">
                <a href="penempatan_siswa.php">Penempatan Siswa</a>
            </li>

            <li class="nav-item mb-1">
                <a href="kelola_wali_kelas.php">Kelola Wali Kelas</a>
            </li>

            <li class="nav-item mb-1">
                <a href="kelola_kategori_pelanggaran.php">
                    Kelola Kategori Pelanggaran
                </a>
            </li>

            <li class="nav-item mb-1">
                <a href="kelola_jenis_pelanggaran.php">
                    Kelola Jenis Pelanggaran
                </a>
            </li>
             
                 

        <?php elseif ($role === 'guru'): ?>

            <li class="nav-item mb-1">
                <a href="catat_pelanggaran.php">Catat Pelanggaran</a>
            </li>

            <li class="nav-item mb-1">
                <a href="tindakan.php">Tindakan</a>
            </li>

            <li class="nav-item mb-1">
                <a href="riwayat.php">Riwayat</a>
            </li>
        

            <li class="nav-item mb-1">
                <a href="rekap_poin.php">Rekap Poin</a>
            </li>
            </li>
                     <li class="nav-item mb-1">
                    <a href="laporan.php">Laporan</a>
                </li>

        <?php endif; ?>
                 
                
        <li class="nav-item mb-1">
            <a href="about_me.php" class="active">About Me</a>
        </li>
        

    </ul>

    <hr>
    <a href="logout.php" class="text-danger">Logout</a>
</div>

        <!-- Konten -->
        <div class="col-md-9 col-lg-10 main-content">
            <h1 class="fw-bold">About Me</h1>
            <p class="text-secondary">Informasi profil pengembang atau pengguna sistem.</p>
            <hr>

            <div class="profile-wrapper">
                <div class="card profile-card">
                    <div class="card-body text-center p-4">

                        <img src="serli.jpeg" alt="Foto Sherly Satriani" class="profile-photo mb-3" width="150" height="200">

                        <h3 class="fw-bold">
                            <?= htmlspecialchars($nama); ?>
                        </h3>

                        <span class="badge bg-danger">
                            <?= strtoupper(htmlspecialchars($role)); ?>
                        </span>

                        <hr>

                        <div class="profile-info">
                            <p><strong>Aplikasi:</strong> Sistem Informasi Pelanggaran Siswa</p>
                            <p><strong>Institusi:</strong> SMK Muhammadiyah</p>
                            <p><strong>Tahun:</strong> 2026</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
