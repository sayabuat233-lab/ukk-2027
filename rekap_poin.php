<?php
require_once 'koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =========================
// KONEKSI DATABASE
// =========================
if (!isset($conn) || !($conn instanceof mysqli)) {
    if (isset($koneksi) && $koneksi instanceof mysqli) {
        $conn = $koneksi;
    }
}

if (!isset($conn) || !($conn instanceof mysqli)) {
    die("Koneksi database tidak tersedia. Periksa file koneksi.php.");
}

// =========================
// AMBIL DATA REKAP POIN
// =========================
$sql = "
    SELECT
        s.id AS siswa_id,
        s.nis,
        s.nama AS nama_siswa,
        k.nama AS nama_kelas,
        COUNT(DISTINCT ps.id) AS jumlah_pelanggaran,
        COALESCE(SUM(ps.poin), 0) AS total_poin
    FROM t_siswa AS s
    LEFT JOIN t_kelas_siswa AS ks
        ON ks.siswa_id = s.id
        AND ks.status_aktif = 1
    LEFT JOIN t_kelas AS k
        ON k.id = ks.kelas_id
    LEFT JOIN t_pelanggaran_siswa AS ps
        ON ps.siswa_id = s.id
    GROUP BY
        s.id,
        s.nis,
        s.nama,
        k.nama
    ORDER BY
        s.nama ASC
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Gagal mengambil data rekap poin: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rekap Poin Siswa</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- DataTables CSS -->
    <link
        href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #212529;
            color: #fff;
            padding-top: 15px;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            padding: 10px 20px;
            color: #adb5bd;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #0d6efd;
            color: #fff;
        }

        .main {
            margin-left: 250px;
            padding: 30px;
            min-width: 0;
        }

        .card {
            border-radius: 10px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
                padding: 15px;
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
                <a href="rekap_poin.php" class="active">Rekap Poin</a>
            </li>
            </li>
                     <li class="nav-item mb-1">
                    <a href="laporan.php">Laporan</a>
                </li>

            <li class="nav-item mb-1">
                <a href="about_me.php">About Me</a>
            </li>

        </ul>

        <hr>

        <a href="logout.php" class="text-danger">Logout</a>

    </div>

    <!-- KONTEN UTAMA -->
    <div class="main">

        <h3 class="fw-bold mb-3">Rekap Poin Siswa</h3>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-dark text-white">
                Data Rekap Poin Siswa
            </div>

            <div class="card-body">

                <p class="text-muted">
                    Ringkasan jumlah pelanggaran dan total poin setiap siswa.
                </p>

                <div class="table-responsive">

                    <table
                        id="tabelRekap"
                        class="table table-bordered table-striped table-hover w-100"
                    >

                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jumlah Pelanggaran</th>
                                <th>Total Poin</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                                <tr>
                                    <td></td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($row['nis'] ?? '-'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($row['nama_siswa'] ?? '-'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($row['nama_kelas'] ?? '-'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td class="text-center">
                                        <?= number_format(
                                            (int) $row['jumlah_pelanggaran'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-danger">
                                            <?= number_format(
                                                (int) $row['total_poin'],
                                                0,
                                                ',',
                                                '.'
                                            ); ?>
                                        </span>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {

            const tabel = $('#tabelRekap').DataTable({

                pageLength: 10,

                lengthMenu: [5, 10, 25, 50, 100],

                // Diurutkan berdasarkan kolom indeks ke-2 (Nama Siswa) dari A ke Z (asc)
                order: [[2, 'asc']],

                columnDefs: [
                    {
                        targets: 0,
                        orderable: false,
                        searchable: false
                    }
                ],

                language: {
                    search: 'Cari:',
                    searchPlaceholder: 'Cari NIS atau nama siswa...',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(disaring dari _MAX_ data)',
                    zeroRecords: 'Data tidak ditemukan',
                    emptyTable: 'Belum ada data rekap poin',

                    paginate: {
                        first: 'Pertama',
                        last: 'Terakhir',
                        next: 'Berikutnya',
                        previous: 'Sebelumnya'
                    }
                }

            });

            // Nomor urut otomatis
            function perbaruiNomor() {

                const info = tabel.page.info();

                tabel
                    .column(0, { page: 'current' })
                    .nodes()
                    .each(function (cell, index) {
                        cell.textContent = info.start + index + 1;
                    });

            }

            tabel.on('order.dt search.dt draw.dt', perbaruiNomor);

            perbaruiNomor();

        });
    </script>

</body>
</html>