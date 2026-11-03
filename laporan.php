
<?php
require_once 'koneksi.php';

if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: login.php");
    exit();
}

// FUNGSI KEAMANAN OUTPUT
function e($nilai) {
    return htmlspecialchars((string)($nilai ?? ''), ENT_QUOTES, 'UTF-8');
}

// TANGKAP FILTER
$tahun_id = $_GET['tahun_id'] ?? '';
$kelas_id = $_GET['kelas_id'] ?? '';
$action   = $_GET['action'] ?? '';

// VALIDASI FILTER
$tahun_id = ctype_digit((string)$tahun_id) ? (int)$tahun_id : '';
$kelas_id = ctype_digit((string)$kelas_id) ? (int)$kelas_id : '';

$where = [];
$params = [];
$types = '';

if ($tahun_id !== '') {
    $where[] = "ks.tahun_ajaran_id = ?";
    $params[] = $tahun_id;
    $types .= 'i';
}

if ($kelas_id !== '') {
    $where[] = "ks.kelas_id = ?";
    $params[] = $kelas_id;
    $types .= 'i';
}

$sqlWhere = $where ? "WHERE " . implode(" AND ", $where) : "";

// QUERY LAPORAN
$query = "SELECT
            ks.*,
            s.nis,
            s.nama AS nama_siswa,
            s.jenis_kelamin,
            k.nama AS nama_kelas,
            ta.nama AS nama_tahun
          FROM t_kelas_siswa ks
          JOIN t_siswa s ON ks.siswa_id = s.id
          JOIN t_kelas k ON ks.kelas_id = k.id
          JOIN t_tahun_ajaran ta ON ks.tahun_ajaran_id = ta.id
          $sqlWhere
          ORDER BY ks.id DESC";

$stmt = mysqli_prepare($koneksi, $query);

if (!$stmt) {
    die("Query laporan gagal: " . mysqli_error($koneksi));
}

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);

if (!$data) {
    die("Gagal mengambil data laporan.");
}

// EXPORT EXCEL
if ($action === 'excel') {
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header(
        "Content-Disposition: attachment; filename=Laporan_Penempatan_Siswa_" .
        date('Ymd') . ".xls"
    );

    echo "\xEF\xBB\xBF";
    ?>
    <h3>Laporan Penempatan Siswa</h3>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun Ajaran</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>L/P</th>
                <th>Kelas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;

            while ($r = mysqli_fetch_assoc($data)):
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= e($r['nama_tahun']); ?></td>
                    <td><?= e($r['nis']); ?></td>
                    <td><?= e($r['nama_siswa']); ?></td>
                    <td><?= e($r['jenis_kelamin']); ?></td>
                    <td><?= e($r['nama_kelas']); ?></td>
                    <td>
                        <?= (int)$r['status_aktif'] === 1
                            ? 'Aktif'
                            : 'Tidak Aktif'; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php
    mysqli_stmt_close($stmt);
    exit();
}

// DATA FILTER TAHUN AJARAN DAN KELAS
$listTahun = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_tahun_ajaran ORDER BY nama DESC"
);

$listKelas = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_kelas ORDER BY nama ASC"
);

if (!$listTahun || !$listKelas) {
    die("Gagal mengambil data filter: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laporan Penempatan Siswa</title>

    <!-- BOOTSTRAP -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- DATATABLES BOOTSTRAP 5 -->
    <link
        href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css"
        rel="stylesheet"
    >

    <style>
        body {
            background-color: #f8f9fa;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            color: #fff;
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
        }

        .sidebar a:hover,
        .sidebar a.active {
            color: #fff;
            background-color: #0d6efd;
        }

        /* KONTEN UTAMA */
        .main-content {
            margin-left: 250px;
            height: 100vh;
            overflow-y: auto;
            padding: 20px;
        }

        /* DATATABLES */
        #tabelLaporan {
            width: 100% !important;
        }

        .dt-search input,
        .dt-length select {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 6px 10px;
        }

        .dt-search input {
            margin-left: 8px;
        }

        .dt-length select {
            margin: 0 5px;
        }

        .dt-info {
            padding-top: 12px !important;
        }

        .dt-paging {
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
                padding: 12px;
            }
        }

        /* CETAK */
        @media print {
            .sidebar,
            .no-print,
            .dt-search,
            .dt-length,
            .dt-paging,
            .dt-info {
                display: none !important;
            }

            .main-content {
                margin-left: 0;
                padding: 0;
                overflow: visible;
                height: auto;
            }

            body {
                overflow: visible;
                background-color: #fff;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            .table {
                width: 100% !important;
                font-size: 11px;
            }
        }
    </style>
</head>

<body <?= $action === 'print' ? 'onload="window.print()"' : ''; ?>>

    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column p-3">

        <h4 class="text-white mb-4">Pelanggaran Siswa</h4>

        <ul class="nav nav-pills flex-column mb-auto">

            <li class="nav-item mb-1">
                <a href="dashboard.php">Dashboard</a>
            </li>

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
                     <li class="nav-item mb-1">
                <a href="laporan.php" class="active">Laporan</a>
            </li>
            
            <li class="nav-item mb-1">
               <a href="about_me.php">About Me</a>
            </li>
            
           

        </ul>

        <hr>

        <a href="logout.php" class="text-danger">Logout</a>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <h2>Laporan Penempatan Siswa</h2>

         <div class="mb-3">
        
        
    </div>
        <hr>

        <!-- FILTER DAN AKSI -->
        <div class="card shadow-sm mb-4 no-print">

            <div class="card-body">

                <form method="GET" action="laporan.php" class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Tahun Ajaran:</label>

                        <select name="tahun_id" class="form-select">

                            <option value="">-- Semua Tahun Ajaran --</option>

                            <?php while ($t = mysqli_fetch_assoc($listTahun)): ?>
                                <option
                                    value="<?= (int)$t['id']; ?>"
                                    <?= (string)$tahun_id === (string)$t['id']
                                        ? 'selected'
                                        : ''; ?>
                                >
                                    <?= e($t['nama']); ?>
                                </option>
                            <?php endwhile; ?>

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kelas:</label>

                        <select name="kelas_id" class="form-select">

                            <option value="">-- Semua Kelas --</option>

                            <?php while ($k = mysqli_fetch_assoc($listKelas)): ?>
                                <option
                                    value="<?= (int)$k['id']; ?>"
                                    <?= (string)$kelas_id === (string)$k['id']
                                        ? 'selected'
                                        : ''; ?>
                                >
                                    <?= e($k['nama']); ?>
                                </option>
                            <?php endwhile; ?>

                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">

                        <button type="submit" class="btn btn-primary me-2">
                            Filter
                        </button>

                        <a href="laporan.php" class="btn btn-secondary">
                            Reset
                        </a>

                    </div>

                </form>

                <hr>

                <!-- TOMBOL CETAK DAN EXPORT -->
                <div>

                    <a
                        href="laporan.php?<?= e(http_build_query(array_merge($_GET, ['action' => 'print']))); ?>"
                        target="_blank"
                        class="btn btn-dark btn-sm"
                    >
                        Cetak / Print
                    </a>

                    <a
                        href="laporan.php?<?= e(http_build_query(array_merge($_GET, ['action' => 'excel']))); ?>"
                        class="btn btn-success btn-sm ms-2"
                    >
                        Export Excel
                    </a>

                </div>

            </div>
        </div>

        <!-- TABEL LAPORAN -->
        <div class="card shadow-sm mb-4">

            <div class="card-header bg-dark text-white">
                Daftar Laporan Penempatan Siswa
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table
                        id="tabelLaporan"
                        class="table table-bordered table-striped table-hover align-middle"
                    >

                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tahun Ajaran</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>L/P</th>
                                <th>Kelas</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $no = 1;

                            while ($r = mysqli_fetch_assoc($data)):
                            ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td><?= e($r['nama_tahun']); ?></td>

                                    <td><?= e($r['nis']); ?></td>

                                    <td><?= e($r['nama_siswa']); ?></td>

                                    <td class="text-center">
                                        <?= e($r['jenis_kelamin']); ?>
                                    </td>

                                    <td><?= e($r['nama_kelas']); ?></td>

                                    <td class="text-center">

                                        <?php if ((int)$r['status_aktif'] === 1): ?>

                                            <span class="badge bg-success">
                                                Aktif
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-secondary">
                                                Tidak Aktif
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>

    <!-- BOOTSTRAP JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DATATABLES JAVASCRIPT -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <!-- KONFIGURASI JAVASCRIPT TABLE -->
    <script>
        $(document).ready(function () {

            $('#tabelLaporan').DataTable({

                language: {
                    search: "Cari:",
                    searchPlaceholder: "Cari nama siswa, NIS, atau kelas...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Data tidak ditemukan",
                    emptyTable: "Tidak ada data laporan",

                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },

                pageLength: 10,

                lengthMenu: [5, 10, 25, 50, 100],

                order: [[0, 'asc']],

                autoWidth: false,

                responsive: false

            });

        });
    </script>

</body>
</html>
