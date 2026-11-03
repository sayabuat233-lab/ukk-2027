<?php
require_once 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// SIMPAN DATA
if (isset($_POST['simpan'])) {
    $id = (int)($_POST['id'] ?? 0);
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jk = $_POST['jenis_kelamin'];
    $tgl = $_POST['tanggal_lahir'];
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $status = $_POST['status_aktif'] == 'Aktif' ? 1 : 0;

    if (!preg_match('/^[0-9]{10}$/', $nis)) {
        echo "<script>alert('NIS harus 10 angka!');history.back();</script>";
        exit();
    }

    if ($nisn != '' && !preg_match('/^[0-9]{10}$/', $nisn)) {
        echo "<script>alert('NISN harus 10 angka!');history.back();</script>";
        exit();
    }

    // CEK DUPLIKAT
    $cek = mysqli_query($koneksi, "SELECT id FROM t_siswa
        WHERE (nis='$nis' OR (nisn='$nisn' AND nisn!=''))
        AND id!='$id'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('NIS atau NISN sudah digunakan!');history.back();</script>";
        exit();
    }

    if ($id) {
        mysqli_query($koneksi, "UPDATE t_siswa SET
            nis='$nis', nisn='$nisn', nama='$nama',
            jenis_kelamin='$jk', tanggal_lahir='$tgl',
            alamat='$alamat', status_aktif='$status',
            updated_at=NOW() WHERE id='$id'");
    } else {
        mysqli_query($koneksi, "INSERT INTO t_siswa
            (nis, nisn, nama, jenis_kelamin, tanggal_lahir,
            alamat, status_aktif, created_at, updated_at)
            VALUES ('$nis','$nisn','$nama','$jk','$tgl',
            '$alamat','$status',NOW(),NOW())");
    }

    header("Location: kelola_siswa.php");
    exit();
}

// HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    mysqli_query($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE siswa_id='$id'");
    mysqli_query($koneksi, "DELETE FROM t_kelas_siswa WHERE siswa_id='$id'");
    mysqli_query($koneksi, "DELETE FROM t_siswa WHERE id='$id'");

    header("Location: kelola_siswa.php");
    exit();
}

// EDIT DATA
$edit_id = (int)($_GET['edit'] ?? 0);
$edit = $edit_id ? mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE id='$edit_id'")
) : null;

// AMBIL DATA SISWA (Diubah urutannya berdasarkan ID atau waktu input secara Ascending agar input terakhir di bawah)
$data = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY id ASC");

if (!$data) {
    die("Gagal mengambil data siswa: " . htmlspecialchars(mysqli_error($koneksi)));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Siswa</title>

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
            <li class="nav-item mb-1"><a href="dashboard.php">Dashboard</a></li>
            <li class="nav-item mb-1"><a href="kelola_guru.php">Kelola Guru</a></li>
            <li class="nav-item mb-1"><a href="kelola_siswa.php" class="active">Kelola Siswa</a></li>
            <li class="nav-item mb-1"><a href="kelola_kelas.php">Kelola Kelas</a></li>
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

        <h2>Kelola Siswa</h2>

        <div class="mb-3">
         
        </div>

        <!-- FORM TAMBAH / EDIT -->
        <div class="card shadow-sm mb-4">

            <div class="card-header bg-primary text-white">
                <?= $edit ? 'Edit Data Siswa' : 'Tambah Data Siswa'; ?>
            </div>

            <div class="card-body">

                <form method="POST">

                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit['id'] ?? ''); ?>">

                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control"
                            value="<?= htmlspecialchars($edit['nis'] ?? ''); ?>"
                            maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control"
                            value="<?= htmlspecialchars($edit['nisn'] ?? ''); ?>"
                            maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" name="nama" class="form-control"
                            value="<?= htmlspecialchars($edit['nama'] ?? ''); ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" <?= ($edit['jenis_kelamin'] ?? '') == 'L' ? 'selected' : ''; ?>>
                                Laki-laki
                            </option>
                            <option value="P" <?= ($edit['jenis_kelamin'] ?? '') == 'P' ? 'selected' : ''; ?>>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="<?= htmlspecialchars($edit['tanggal_lahir'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($edit['alamat'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Aktif</label>
                        <select name="status_aktif" class="form-control" required>
                            <option value="Aktif" <?= ($edit['status_aktif'] ?? 1) == 1 ? 'selected' : ''; ?>>
                                Aktif
                            </option>
                            <option value="Tidak Aktif" <?= ($edit['status_aktif'] ?? 1) == 0 ? 'selected' : ''; ?>>
                                Tidak Aktif
                            </option>
                        </select>
                    </div>

                    <button type="submit" name="simpan" class="btn btn-primary">
                        <?= $edit ? 'Update Data' : 'Simpan'; ?>
                    </button>

                    <?php if ($edit): ?>
                        <a href="kelola_siswa.php" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>

                </form>

            </div>
        </div>

        <!-- TABEL DATA SISWA -->
        <div class="card shadow-sm">

            <div class="card-header bg-dark text-white">
                Data Siswa
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table id="tabelSiswa" class="table table-bordered table-striped table-hover align-middle w-100">

                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>L/P</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $no = 1; ?>

                            <?php while ($r = mysqli_fetch_assoc($data)): ?>

                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td><?= htmlspecialchars($r['nis']); ?></td>

                                    <td><?= htmlspecialchars($r['nisn']); ?></td>

                                    <td><?= htmlspecialchars($r['nama']); ?></td>

                                    <td><?= htmlspecialchars($r['jenis_kelamin']); ?></td>

                                    <td><?= htmlspecialchars($r['alamat']); ?></td>

                                    <td>
                                        <span class="badge bg-<?= $r['status_aktif'] ? 'success' : 'secondary'; ?>">
                                            <?= $r['status_aktif'] ? 'Aktif' : 'Tidak Aktif'; ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="kelola_siswa.php?edit=<?= (int)$r['id']; ?>"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <a href="kelola_siswa.php?hapus=<?= (int)$r['id']; ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus siswa ini?')">
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

    <!-- DATATABLES -->
    <script>
        $(document).ready(function () {

            $('#tabelSiswa').DataTable({
                language: {
                    search: "Cari data:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data siswa",
                    infoEmpty: "Tidak ada data siswa",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Data siswa tidak ditemukan",
                    emptyTable: "Belum ada data siswa",

                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                },

                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
                // Diubah agar DataTables tidak memaksa sorting berdasarkan kolom Nama (indeks 3), 
                // melainkan mengikuti urutan asli dari database (urutan input berdasarkan ID)
                order: [[0, 'asc']], 

                columnDefs: [{
                    targets: 7,
                    orderable: false,
                    searchable: false
                }]
            });

        });
    </script>

</body>
</html>