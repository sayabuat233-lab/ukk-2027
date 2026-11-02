<?php
require_once 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// PROSES SIMPAN (TAMBAH / EDIT)
if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jk = $_POST['jenis_kelamin'];
    $tgl = $_POST['tanggal_lahir'];
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $status = $_POST['status_aktif'] == 'Aktif' ? 1 : 0;

    // VALIDASI NIS DAN NISN
    if (!preg_match('/^[0-9]{10}$/', $nis)) {
        echo "<script>alert('NIS harus terdiri dari 10 angka!');history.back();</script>";
        exit();
    }

    if ($nisn != '' && !preg_match('/^[0-9]{10}$/', $nisn)) {
        echo "<script>alert('NISN harus terdiri dari 10 angka!');history.back();</script>";
        exit();
    }

    // CEK NIS DUPLIKAT
    $cek = mysqli_query($koneksi, "SELECT id FROM t_siswa WHERE nis='$nis' AND id!='$id'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('NIS sudah digunakan!');history.back();</script>";
        exit();
    }

    // CEK NISN DUPLIKAT
    if ($nisn != '') {
        $cek = mysqli_query($koneksi, "SELECT id FROM t_siswa WHERE nisn='$nisn' AND id!='$id'");

        if (mysqli_num_rows($cek) > 0) {
            echo "<script>alert('NISN sudah digunakan!');history.back();</script>";
            exit();
        }
    }

    if ($id) {
        mysqli_query($koneksi, "UPDATE t_siswa SET nis='$nis', nisn='$nisn', nama='$nama', jenis_kelamin='$jk', tanggal_lahir='$tgl', alamat='$alamat', status_aktif='$status', updated_at=NOW() WHERE id='$id'");
    } else {
        mysqli_query($koneksi, "INSERT INTO t_siswa (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif, created_at, updated_at) VALUES ('$nis', '$nisn', '$nama', '$jk', '$tgl', '$alamat', '$status', NOW(), NOW())");
    }

    header("Location: kelola_siswa.php");
    exit();
}

// PROSES HAPUS
if (isset($_GET['hapus'])) {
    $id_siswa = $_GET['hapus'];

    mysqli_query($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE siswa_id='$id_siswa'");
    mysqli_query($koneksi, "DELETE FROM t_kelas_siswa WHERE siswa_id='$id_siswa'");
    mysqli_query($koneksi, "DELETE FROM t_siswa WHERE id='$id_siswa'");

    header("Location: kelola_siswa.php");
    exit();
}

// EDIT DATA
$edit_id = $_GET['edit'] ?? '';
$edit = $edit_id ? mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE id='$edit_id'")) : null;

// PAGINATION
$limit = 10;
$h = max(1, (int)($_GET['halaman'] ?? 1));
$cari = mysqli_real_escape_string($koneksi, $_GET['cari'] ?? '');

$where = $cari ? "WHERE nis LIKE '%$cari%' OR nisn LIKE '%$cari%' OR nama LIKE '%$cari%'" : "";

$total = mysqli_num_rows(mysqli_query($koneksi, "SELECT 1 FROM t_siswa $where"));
$pages = max(1, ceil($total / $limit));

$offset = ($h - 1) * $limit;

$data = mysqli_query($koneksi, "SELECT * FROM t_siswa $where LIMIT $offset, $limit");
$no = $offset + 1;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #212529;
            color: #fff;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
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
            background: #0d6efd;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .btn-dashboard {
            background-color: #6c757d;
            color: #fff;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-dashboard:hover {
            background-color: #5a6268;
            color: #fff;
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
                <a href="kelola_siswa.php" class="active">Kelola Siswa</a>
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

        </ul>

        <hr>

        <a href="logout.php" class="text-danger">Logout</a>

    </div>

    <!-- KONTEN UTAMA -->
    <div class="main-content">

        <h2>Kelola Siswa</h2>

        <div class="mb-3">
            <a href="dashboard.php" class="btn btn-secondary">
                Kembali ke Dashboard
            </a>
        </div>

        <!-- FORM TAMBAH / EDIT DATA SISWA -->
        <div class="card shadow-sm mb-4">

            <div class="card-header bg-primary text-white py-2">
                <?= $edit ? 'Edit Data Siswa' : 'Tambah Data Siswa'; ?>
            </div>

            <div class="card-body">

                <form method="POST">

                    <input type="hidden" name="id" value="<?= $edit['id'] ?? ''; ?>">

                    <div class="mb-3">
                        <label class="form-label">NIS</label>

                        <input type="text"
                            name="nis"
                            class="form-control"
                            value="<?= htmlspecialchars($edit['nis'] ?? ''); ?>"
                            maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NISN</label>

                        <input type="text"
                            name="nisn"
                            class="form-control"
                            value="<?= htmlspecialchars($edit['nisn'] ?? ''); ?>"
                            maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>

                        <input type="text"
                            name="nama"
                            class="form-control"
                            value="<?= htmlspecialchars($edit['nama'] ?? ''); ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>

                        <select name="jenis_kelamin" class="form-control" required>

                            <option value="">Pilih Jenis Kelamin</option>

                            <option value="L" <?= (($edit['jenis_kelamin'] ?? '') == 'L') ? 'selected' : ''; ?>>
                                Laki-laki
                            </option>

                            <option value="P" <?= (($edit['jenis_kelamin'] ?? '') == 'P') ? 'selected' : ''; ?>>
                                Perempuan
                            </option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>

                        <input type="date"
                            name="tanggal_lahir"
                            class="form-control"
                            value="<?= htmlspecialchars($edit['tanggal_lahir'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>

                        <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($edit['alamat'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Aktif</label>

                        <select name="status_aktif" class="form-control" required>

                            <option value="Aktif" <?= (($edit['status_aktif'] ?? 1) == 1 || ($edit['status_aktif'] ?? '') == 'Aktif') ? 'selected' : ''; ?>>
                                Aktif
                            </option>

                            <option value="Tidak Aktif" <?= (($edit['status_aktif'] ?? 1) == 0 || ($edit['status_aktif'] ?? '') == 'Tidak Aktif') ? 'selected' : ''; ?>>
                                Tidak Aktif
                            </option>

                        </select>
                    </div>

                    <button type="submit" name="simpan" class="btn btn-primary">
                        Simpan
                    </button>

                    <?php if ($edit): ?>
                        <a href="kelola_siswa.php" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>

                </form>

            </div>
        </div>

        <!-- TABEL DATA SISWA -->
        <div class="card shadow-sm" id="data-siswa">

            <div class="card-header bg-dark text-white py-2">
                Data Siswa
            </div>

            <div class="card-body">

                <div class="row mb-3 justify-content-between align-items-center">

                    <div class="col-auto">
                        Tampilkan

                        <select class="form-select form-select-sm d-inline-block w-auto">
                            <option>10</option>
                        </select>

                        data
                    </div>

                    <div class="col-auto">

                        <form method="GET" class="d-flex align-items-center">

                            <label class="me-2 mb-0">Cari data:</label>

                            <input type="text"
                                name="cari"
                                class="form-control form-control-sm"
                                value="<?= htmlspecialchars($cari); ?>">

                        </form>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>L/P</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($r = mysqli_fetch_assoc($data)): ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td><?= htmlspecialchars($r['nis']); ?></td>

                                    <td><?= htmlspecialchars($r['nisn']); ?></td>

                                    <td><?= htmlspecialchars($r['nama']); ?></td>

                                    <td><?= htmlspecialchars($r['jenis_kelamin']); ?></td>

                                    <td><?= htmlspecialchars($r['alamat']); ?></td>

                                    <td>
                                        <span class="badge bg-<?= ($r['status_aktif'] == 1 || $r['status_aktif'] == 'Aktif') ? 'success' : 'secondary'; ?>">

                                            <?= ($r['status_aktif'] == 1 || $r['status_aktif'] == 'Aktif') ? 'Aktif' : 'Tidak Aktif'; ?>

                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <a href="?edit=<?= $r['id']; ?>"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <a href="?hapus=<?= $r['id']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus data siswa ini?')">
                                            Hapus
                                        </a>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                            <?php if (!$total): ?>

                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Data siswa tidak ditemukan.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

                <!-- PAGINATION -->
                <div class="d-flex justify-content-between align-items-center mt-3">

                    <small class="text-muted">

                        Menampilkan <?= $total ? $offset + 1 : 0; ?>
                        s.d. <?= min($offset + $limit, $total); ?>
                        dari <?= $total; ?> data

                    </small>

                    <ul class="pagination pagination-sm mb-0">

                        <li class="page-item <?= $h <= 1 ? 'disabled' : ''; ?>">

                            <a class="page-link"
                                href="?halaman=1&cari=<?= urlencode($cari); ?>#data-siswa">
                                Pertama
                            </a>

                        </li>

                        <li class="page-item <?= $h <= 1 ? 'disabled' : ''; ?>">

                            <a class="page-link"
                                href="?halaman=<?= $h - 1; ?>&cari=<?= urlencode($cari); ?>#data-siswa">
                                Sebelumnya
                            </a>

                        </li>

                        <?php for ($i = 1; $i <= $pages; $i++): ?>

                            <li class="page-item <?= $h == $i ? 'active' : ''; ?>">

                                <a class="page-link"
                                    href="?halaman=<?= $i; ?>&cari=<?= urlencode($cari); ?>#data-siswa">
                                    <?= $i; ?>
                                </a>

                            </li>

                        <?php endfor; ?>

                        <li class="page-item <?= $h >= $pages ? 'disabled' : ''; ?>">

                            <a class="page-link"
                                href="?halaman=<?= $h + 1; ?>&cari=<?= urlencode($cari); ?>#data-siswa">
                                Berikutnya
                            </a>

                        </li>

                        <li class="page-item <?= $h >= $pages ? 'disabled' : ''; ?>">

                            <a class="page-link"
                                href="?halaman=<?= $pages; ?>&cari=<?= urlencode($cari); ?>#data-siswa">
                                Terakhir
                            </a>

                        </li>

                    </ul>

                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>