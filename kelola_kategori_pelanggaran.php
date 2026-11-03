
<?php
require_once 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// PROSES SIMPAN TAMBAH / EDIT
if (isset($_POST['simpan'])) {
    $id = (int)($_POST['id'] ?? 0);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $status = isset($_POST['status_aktif']) ? 1 : 0;

    if ($id) {
        mysqli_query($koneksi, "UPDATE t_pelanggaran_kategori
            SET nama='$nama', deskripsi='$deskripsi',
            status_aktif='$status' WHERE id='$id'");
    } else {
        mysqli_query($koneksi, "INSERT INTO t_pelanggaran_kategori
            (nama, deskripsi, status_aktif)
            VALUES ('$nama', '$deskripsi', '$status')");
    }

    header("Location: kelola_kategori_pelanggaran.php");
    exit();
}

// PROSES HAPUS
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    mysqli_query($koneksi,
        "DELETE FROM t_pelanggaran_kategori WHERE id='$id'");

    header("Location: kelola_kategori_pelanggaran.php");
    exit();
}

// DATA EDIT
$edit = [
    'id' => '',
    'nama' => '',
    'deskripsi' => '',
    'status_aktif' => 1
];

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];

    $resultEdit = mysqli_query($koneksi,
        "SELECT * FROM t_pelanggaran_kategori WHERE id='$id'");

    if ($resultEdit && mysqli_num_rows($resultEdit) > 0) {
        $edit = mysqli_fetch_assoc($resultEdit);
    }
}

// AMBIL DATA KATEGORI
$data = mysqli_query($koneksi,
    "SELECT * FROM t_pelanggaran_kategori ORDER BY nama ASC");

if (!$data) {
    die("Gagal mengambil data: " . e(mysqli_error($koneksi)));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Kategori Pelanggaran</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DATATABLES -->
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
            <a href="kelola_kategori_pelanggaran.php" class="active">
                Kelola Kategori Pelanggaran
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="kelola_jenis_pelanggaran.php">Kelola Jenis Pelanggaran</a>
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
<div class="main-content">

    <h2>Kelola Kategori Pelanggaran</h2>

    <div class="mb-3">
      
    </div>

    <!-- FORM TAMBAH / EDIT -->
    <div class="card shadow-sm mb-4">

        <div class="card-header bg-primary text-white">

            <?= $edit['id'] ? 'Edit Data Kategori' : 'Tambah Data Kategori'; ?>

        </div>

        <div class="card-body">

            <form method="POST">

                <input type="hidden" name="id" value="<?= e($edit['id']); ?>">

                <div class="mb-3">

                    <label class="form-label">Nama Kategori</label>

                    <input type="text"
                        name="nama"
                        class="form-control"
                        value="<?= e($edit['nama']); ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Deskripsi</label>

                    <textarea name="deskripsi"
                        class="form-control"
                        rows="3"><?= e($edit['deskripsi']); ?></textarea>

                </div>

                <div class="form-check mb-3">

                    <input class="form-check-input"
                        type="checkbox"
                        name="status_aktif"
                        id="status_aktif"
                        value="1"
                        <?= $edit['status_aktif'] == 1 ? 'checked' : ''; ?>>

                    <label class="form-check-label" for="status_aktif">
                        Status Aktif
                    </label>

                </div>

                <button type="submit" name="simpan" class="btn btn-primary">

                    <?= $edit['id'] ? 'Update Data' : 'Simpan'; ?>

                </button>

                <?php if ($edit['id']): ?>

                    <a href="kelola_kategori_pelanggaran.php"
                        class="btn btn-secondary">
                        Batal
                    </a>

                <?php endif; ?>

            </form>

        </div>
    </div>

    <!-- TABEL DATA KATEGORI -->
    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            Data Kategori Pelanggaran
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table id="tabelKategori"
                    class="table table-bordered table-striped table-hover align-middle w-100">

                    <thead class="table-dark">

                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php $no = 1; ?>

                        <?php while ($r = mysqli_fetch_assoc($data)): ?>

                            <tr>

                                <td><?= $no++; ?></td>

                                <td><?= e($r['nama']); ?></td>

                                <td>
                                    <?= $r['deskripsi'] ? e($r['deskripsi']) : '-'; ?>
                                </td>

                                <td>

                                    <?php if ($r['status_aktif'] == 1): ?>

                                        <span class="badge bg-success">
                                            Aktif
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-secondary">
                                            Tidak Aktif
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <div class="d-flex gap-1">

                                        <a href="kelola_kategori_pelanggaran.php?edit=<?= (int)$r['id']; ?>"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <a href="kelola_kategori_pelanggaran.php?hapus=<?= (int)$r['id']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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

    $('#tabelKategori').DataTable({

        language: {
            search: "Cari data:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data kategori",
            infoEmpty: "Tidak ada data kategori",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data kategori tidak ditemukan",
            emptyTable: "Belum ada kategori pelanggaran",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        order: [[1, 'asc']],

        columnDefs: [
            {
                targets: 4,
                orderable: false,
                searchable: false
            }
        ],

        stateSave: true

    });

});
</script>

</body>
</html>
