<?php
require_once 'koneksi.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($koneksi, "SELECT * FROM t_users WHERE email='$email' LIMIT 1");
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikasi password (mendukung hash password default atau teks biasa '123456')
        if (password_verify($password, $user['password']) || $password === '123456') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Jika role adalah guru, cek apakah guru tersebut terdaftar sebagai wali kelas aktif
            if ($user['role'] === 'guru') {
                $q_guru = mysqli_query($koneksi, "SELECT id FROM t_guru WHERE user_id = '{$user['id']}' LIMIT 1");
                if ($d_guru = mysqli_fetch_assoc($q_guru)) {
                    $_SESSION['guru_id'] = $d_guru['id'];
                    
                    // Cek ke tabel t_wali_kelas
                    $q_wk = mysqli_query($koneksi, "SELECT 1 FROM t_wali_kelas WHERE guru_id = '{$d_guru['id']}' AND status_aktif = 1 LIMIT 1");
                    if (mysqli_num_rows($q_wk) > 0) {
                        $_SESSION['is_wali_kelas'] = true; // Berhak akses laporan
                    } else {
                        $_SESSION['is_wali_kelas'] = false; // Guru biasa
                    }
                } else {
                    $_SESSION['is_wali_kelas'] = false;
                }
            } else {
                $_SESSION['is_wali_kelas'] = false;
            }

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Pelanggaran Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { width: 100%; max-width: 400px; padding: 20px; }
    </style>
</head>
<body>
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="text-center mb-4">Login Sistem</h3>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger py-2"><?= $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>