<?php
require_once 'koneksi.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Proses Update Status
if (isset($_POST['update_status'])) {
    $id = (int) $_POST['id'];
    $status_baru = mysqli_real_escape_string($koneksi, $_POST['status']);
    
    $stmt = mysqli_prepare($koneksi, "UPDATE t_pelanggaran_siswa SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $status_baru, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    header("Location: tindakan.php?msg=update");
    exit();
}

// Proses Hapus Data
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE id = $id");
    header("Location: tindakan.php?msg=hapus");
    exit();
}

$sql = "SELECT ps.*, s.nama AS nama_siswa, k.nama AS nama_kelas, p.nama AS nama_pelanggaran, g.nama AS nama_guru 
        FROM t_pelanggaran_siswa ps 
        LEFT JOIN t_siswa s ON ps.siswa_id = s.id 
        LEFT JOIN t_kelas k ON ps.kelas_id = k.id 
        LEFT JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id 
        LEFT JOIN t_guru g ON ps.guru_id = g.id 
        ORDER BY ps.tanggal DESC, ps.id DESC";
$data = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Tindakan Pelanggaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar { width: 250px; height: 100vh; position: fixed; top: 0; left: 0; background: #212529; color: #fff; padding-top: 15px; overflow-y: auto; }
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
        <li class="nav-item mb-1"><a href="catat_pelanggaran.php">Catat Pelanggaran</a></li>
        <li class="nav-item mb-1"><a href="tindakan.php" class="active">Tindakan</a></li>
        <li class="nav-item mb-1"><a href="riwayat.php">Riwayat</a></li>
        <li class="nav-item mb-1"><a href="rekap_poin.php">Rekap Poin</a></li>
        <li class="nav-item mb-1"><a href="laporan.php">Laporan</a></li>
        <li class="nav-item mb-1"><a href="about_me.php">About Me</a></li>
    </ul>
    <hr><a href="logout.php" class="text-danger">Logout</a>
</div>

<div class="main">
    <h3 class="fw-bold mb-3">Data Tindakan Pelanggaran</h3>
    
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'hapus'): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Data berhasil dihapus. <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'update'): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Status tindakan berhasil diperbarui. <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white">Daftar Tindakan Pelanggaran Siswa</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelTindakan" class="table table-bordered table-striped align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Pelanggaran</th>
                            <th>Poin</th>
                            <th>Guru</th>
                            <th>Tindakan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['tanggal'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($row['nama_kelas'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($row['nama_pelanggaran'] ?? '-'); ?></td>
                            <td><span class="badge bg-danger"><?= (int)($row['poin'] ?? 0); ?></span></td>
                            <td><?= htmlspecialchars($row['nama_guru'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($row['tindakan'] ?? '-'); ?></td>
                            <td>
                                <!-- Form untuk mengubah status secara langsung -->
                                <form method="POST" class="d-flex gap-1 align-items-center">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <select name="status" class="form-select form-select-sm" style="width: 130px;">
                                        <option value="Pending" <?= ($row['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Proses" <?= ($row['status'] === 'Proses') ? 'selected' : ''; ?>>Proses</option>
                                        <option value="Selesai" <?= ($row['status'] === 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-sm btn-primary">Simpan</button>
                                </form>
                            </td>
                            <td>
                                <a href="tindakan.php?hapus=<?= (int)$row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</a>
                            </td>
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
    $('#tabelTindakan').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            zeroRecords: "Belum ada data tindakan",
            paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" }
        }
    });
});
</script>
</body>
</html>