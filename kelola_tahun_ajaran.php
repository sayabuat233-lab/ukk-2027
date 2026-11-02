
<?php
require_once 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$nama_user = $_SESSION['nama_user'] ?? 'Administrator Utama';

// SIMPAN / UPDATE DATA
if (isset($_POST['simpan'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tanggal_mulai = mysqli_real_escape_string($koneksi, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($koneksi, $_POST['tanggal_selesai']);
    $status_aktif = (int) $_POST['status_aktif'];

    if ($id !== '') {
        $query = "UPDATE t_tahun_ajaran
                  SET nama='$nama',
                      tanggal_mulai='$tanggal_mulai',
                      tanggal_selesai='$tanggal_selesai',
                      status_aktif='$status_aktif'
                  WHERE id='$id'";
    } else {
        $query = "INSERT INTO t_tahun_ajaran
                  (nama, tanggal_mulai, tanggal_selesai, status_aktif)
                  VALUES
                  ('$nama', '$tanggal_mulai', '$tanggal_selesai', '$status_aktif')";
    }

    if (mysqli_query($koneksi, $query)) {
        header("Location: kelola_tahun_ajaran.php");
        exit();
    } else {
        die("Gagal menyimpan data: " . mysqli_error($koneksi));
    }
}

// HAPUS DATA
if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($koneksi, $_GET['hapus']);

    if (mysqli_query($koneksi, "DELETE FROM t_tahun_ajaran WHERE id='$id_hapus'")) {
        header("Location: kelola_tahun_ajaran.php");
        exit();
    } else {
        die("Gagal menghapus data: " . mysqli_error($koneksi));
    }
}

// DATA FORM EDIT
$edit = [
    'id' => '',
    'nama' => '',
    'tanggal_mulai' => '',
    'tanggal_selesai' => '',
    'status_aktif' => '1'
];

if (isset($_GET['edit'])) {
    $id_edit = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $hasil_edit = mysqli_query(
        $koneksi,
        "SELECT * FROM t_tahun_ajaran WHERE id='$id_edit'"
    );

    if ($hasil_edit && mysqli_num_rows($hasil_edit) > 0) {
        $edit = mysqli_fetch_assoc($hasil_edit);
    }
}

// AMBIL SEMUA DATA
$data = mysqli_query($koneksi, "SELECT * FROM t_tahun_ajaran");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tahun Ajaran</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS DataTables -->
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

        .table-responsive {
            overflow-x: auto;
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
                    <a href="kelola_tahun_ajaran.php" class="active">Kelola Tahun Ajaran</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="penempatan_siswa.php">Penempatan Siswa</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="kelola_wali_kelas.php">Kelola Wali Kelas</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="kelola_kategori_pelanggaran.php">Kelola Kategori Pelanggaran</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="laporan.php">Laporan</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="kelola_jenis_pelanggaran.php">Kelola Jenis Pelanggaran</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="about_me.php">About Me</a>
                </li>
            <?php endif; ?>

            <?php if ($role === 'guru'): ?>
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
            <?php endif; ?>
        </ul>

        <hr>
        <a href="logout.php" class="text-danger">Logout</a>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="main-content">
        <h2>Kelola Tahun Ajaran</h2>
        <div class="mb-3">

         <a href="dashboard.php" class="btn btn-secondary">
            Kembali ke Dashboard
        </a>


    </div>

        <!-- FORM TAMBAH / EDIT -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <?= $edit['id'] ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran'; ?>
            </div>

            <div class="card-body">
                <form method="POST" action="kelola_tahun_ajaran.php">
                    <input type="hidden" name="id"
                           value="<?= htmlspecialchars((string)$edit['id']); ?>">

                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" name="nama" class="form-control"
                               placeholder="Contoh: 2026/2027"
                               value="<?= htmlspecialchars((string)$edit['nama']); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control"
                               value="<?= htmlspecialchars((string)$edit['tanggal_mulai']); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control"
                               value="<?= htmlspecialchars((string)$edit['tanggal_selesai']); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Aktif</label>
                        <select name="status_aktif" class="form-select" required>
                            <option value="1"
                                <?= (string)$edit['status_aktif'] === '1' ? 'selected' : ''; ?>>
                                Aktif
                            </option>
                            <option value="0"
                                <?= (string)$edit['status_aktif'] === '0' ? 'selected' : ''; ?>>
                                Tidak Aktif
                            </option>
                        </select>
                    </div>

                    <button type="submit" name="simpan" class="btn btn-primary">
                        Simpan
                    </button>

                    <?php if ($edit['id']): ?>
                        <a href="kelola_tahun_ajaran.php" class="btn btn-secondary">
                            Batal
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- TABEL DATA DENGAN DATATABLES -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                Data Tahun Ajaran
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelTahunAjaran"
                           class="table table-bordered table-striped table-hover align-middle w-100">

                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tahun Ajaran</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status Aktif</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            if ($data && mysqli_num_rows($data) > 0):
                                while ($r = mysqli_fetch_assoc($data)):
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars((string)$r['nama']); ?></td>
                                    <td><?= htmlspecialchars((string)$r['tanggal_mulai']); ?></td>
                                    <td><?= htmlspecialchars((string)$r['tanggal_selesai']); ?></td>
                                    <td>
                                        <?php if ((int)$r['status_aktif'] === 1): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="kelola_tahun_ajaran.php?edit=<?= urlencode((string)$r['id']); ?>"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <a href="kelola_tahun_ajaran.php?hapus=<?= urlencode((string)$r['id']); ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                endwhile;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- JavaScript DataTables -->
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- KONFIGURASI DATATABLES -->
    <script>
        $(document).ready(function () {
            $('#tabelTahunAjaran').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
                searching: true,
                ordering: true,
                paging: true,
                info: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data yang ditampilkan",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Data tidak ditemukan",
                    emptyTable: "Belum ada data tahun ajaran",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                },
                columnDefs: [
                    {
                        targets: 5,
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>

</body>
</html>
