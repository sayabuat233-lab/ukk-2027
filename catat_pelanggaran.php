<?php
require_once 'koneksi.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (isset($_POST['simpan'])) {
    $s_id    = (int)$_POST['siswa_id'];
    $k_id    = (int)$_POST['kelas_id'];
    $p_id    = (int)$_POST['pelanggaran_id'];
    $g_id    = (int)$_POST['guru_id'];
    $tgl     = $_POST['tanggal'];

    $ta = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id FROM t_tahun_ajaran WHERE status_aktif = 1 LIMIT 1"))['id'] ?? 1;
    $s  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama FROM t_siswa WHERE id = $s_id"))['nama'];
    $k  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama FROM t_kelas WHERE id = $k_id"))['nama'];
    $p  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama, poin, pelanggaran_kategori_id FROM t_pelanggaran WHERE id = $p_id"));
    $g  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama FROM t_guru WHERE id = $g_id"))['nama'];

    // Nilai default untuk kolom lainnya
    $keterangan = '';
    $tindakan   = '';
    $status     = 'Pending';

    $stmt = mysqli_prepare($koneksi, "INSERT INTO t_pelanggaran_siswa (tahun_ajaran_id, siswa_id, nama_siswa, kelas_id, nama_kelas, pelanggaran_id, nama_pelanggaran, pelanggaran_kategori_id, guru_id, nama_guru, tanggal, keterangan, poin, tindakan, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, "iisisisiisssiss", $ta, $s_id, $s, $k_id, $k, $p_id, $p['nama'], $p['pelanggaran_kategori_id'], $g_id, $g, $tgl, $keterangan, $p['poin'], $tindakan, $status);
    mysqli_stmt_execute($stmt);
    header("Location: catat_pelanggaran.php"); exit();
}

if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE id = " . (int)$_GET['hapus']);
    header("Location: catat_pelanggaran.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Catat Pelanggaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar { width: 250px; height: 100vh; position: fixed; top: 0; left: 0; background: #212529; color: #fff; padding-top: 15px; }
        .sidebar a { display: block; padding: 10px 20px; color: #adb5bd; text-decoration: none; }
        .sidebar a:hover, .sidebar a.active { background: #0d6efd; color: #fff; }
        .main { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>
<div class="sidebar d-flex flex-column p-3">
    <h4 class="text-white mb-4">Pelanggaran Siswa</h4>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1"><a href="dashboard.php">Dashboard</a></li>
        <li class="nav-item mb-1"><a href="catat_pelanggaran.php" class="active">Catat Pelanggaran</a></li>
        <li class="nav-item mb-1"><a href="tindakan.php">Tindakan</a></li>
        <li class="nav-item mb-1"><a href="riwayat.php">Riwayat</a></li>
        <li class="nav-item mb-1"><a href="rekap_poin.php">Rekap Poin</a></li>
        <li class="nav-item mb-1"><a href="about_me.php">About Me</a></li>
    </ul>
    <hr><a href="logout.php" class="text-danger">Logout</a>
</div>

<div class="main">
    <h3 class="fw-bold mb-3">Catat Pelanggaran</h3>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">Form Tambah Catatan Pelanggaran</div>
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" class="form-select" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php $q = mysqli_query($koneksi, "SELECT id, nis, nama FROM t_siswa ORDER BY nama ASC"); while($r = mysqli_fetch_assoc($q)): ?>
                                <option value="<?= $r['id'] ?>"><?= $r['nis'].' - '.$r['nama'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php $q = mysqli_query($koneksi, "SELECT id, nama FROM t_kelas ORDER BY nama ASC"); while($r = mysqli_fetch_assoc($q)): ?>
                                <option value="<?= $r['id'] ?>"><?= $r['nama'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pelanggaran</label>
                        <select name="pelanggaran_id" class="form-select" required>
                            <option value="">-- Pilih Pelanggaran --</option>
                            <?php $q = mysqli_query($koneksi, "SELECT id, kode, nama, poin FROM t_pelanggaran ORDER BY kode ASC"); while($r = mysqli_fetch_assoc($q)): ?>
                                <option value="<?= $r['id'] ?>"><?= $r['kode'].' - '.$r['nama'].' ('.$r['poin'].' Poin)' ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Guru Pencatat</label>
                        <select name="guru_id" class="form-select" required>
                            <option value="">-- Pilih Guru Pencatat --</option>
                            <?php $q = mysqli_query($koneksi, "SELECT id, nip, nama FROM t_guru ORDER BY nama ASC"); while($r = mysqli_fetch_assoc($q)): ?>
                                <option value="<?= $r['id'] ?>"><?= $r['nama'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white">Data Pelanggaran Siswa</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelPelanggaran" class="table table-bordered table-striped align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Pelanggaran</th>
                            <th>Poin</th>
                            <th>Guru Pencatat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; $data = mysqli_query($koneksi, "SELECT ps.*, s.nama AS s_nama, k.nama AS k_nama, p.nama AS p_nama FROM t_pelanggaran_siswa ps LEFT JOIN t_siswa s ON ps.siswa_id = s.id LEFT JOIN t_kelas k ON ps.kelas_id = k.id LEFT JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id ORDER BY ps.id DESC");
                        while($row = mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['tanggal']; ?></td>
                            <td><?= $row['s_nama'] ?? '-'; ?></td>
                            <td><?= $row['k_nama'] ?? '-'; ?></td>
                            <td><?= $row['p_nama'] ?? '-'; ?></td>
                            <td><span class="badge bg-danger"><?= $row['poin']; ?></span></td>
                            <td><?= $row['nama_guru'] ?? '-'; ?></td>
                            <td><a href="catat_pelanggaran.php?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () { 
    $('#tabelPelanggaran').DataTable({
        language: {
            paginate: {
                first: "Pertama",
                previous: "Sebelumnya",
                next: "Berikutnya",
                last: "Terakhir"
            },
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
            infoFiltered: "(disaring dari _MAX_ total entri)",
            lengthMenu: "Tampilkan _MENU_ entri",
            search: "Cari:",
            zeroRecords: "Tidak ditemukan data yang sesuai"
        }
    }); 
});
</script>
</body>
</html>