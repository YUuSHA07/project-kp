<?php
session_start();
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role_user'])) {
    header("Location: ../Users/login_form.php");
    exit;
}

include '../koneksi.php';

$role = $_SESSION['role_user'];
$id_user = $_SESSION['id_user'];

// Ambil nama dan foto user
$query = mysqli_prepare($conn, "SELECT nama_user, foto_user FROM users WHERE id_user = ?");
mysqli_stmt_bind_param($query, "s", $id_user);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$data_user = mysqli_fetch_assoc($result);

$nama_user = $data_user['nama_user'];
$foto_user = !empty($data_user['foto_user']) ? "../Penyimpanan/img/" . $data_user['foto_user'] : "../Penyimpanan/img/default.jpg";

function tampilkanKelasCard($kelas_list, $conn) {
    if (empty($kelas_list)) {
        echo "<p>Tidak ada kelas yang ditemukan.</p>";
        return;
    }
    echo "<div class='row'>";
    foreach ($kelas_list as $kelas) {
        $q_dosen = mysqli_prepare($conn, "SELECT u.foto_user, u.nama_user FROM kelas_anggota ka 
                                          JOIN users u ON ka.id_user = u.id_user 
                                          WHERE ka.id_kelas = ? AND ka.role_di_kelas = 'Dosen' LIMIT 1");
        mysqli_stmt_bind_param($q_dosen, "s", $kelas['id_kelas']);
        mysqli_stmt_execute($q_dosen);
        $res_dosen = mysqli_stmt_get_result($q_dosen);
        $dosen = mysqli_fetch_assoc($res_dosen);

        $foto_dosen = isset($dosen['foto_user']) && $dosen['foto_user'] != ''
                        ? "../Penyimpanan/img/" . $dosen['foto_user']
                        : "../Penyimpanan/img/default.jpg";

        $nama_dosen = $dosen['nama_user'] ?? 'Dosen Tidak Terdaftar';

        echo "<div class='col-md-4 mb-4'>";
        echo "<div class='card shadow'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($kelas['mata_kuliah']) . "</h5>";
        echo "<p class='card-text'><strong>Kelas:</strong> " . htmlspecialchars($kelas['kelas_ik']) . "</p>";
        echo "<p class='card-text'><strong>Semester:</strong> " . htmlspecialchars($kelas['semester']) . " / " . htmlspecialchars($kelas['tahun']) . "</p>";
        echo "<div class='d-flex align-items-center mb-3'>";
        echo "<img src='$foto_dosen' class='rounded-circle me-2' width='40' height='40' alt='Dosen'>";
        echo "<small class='text-muted'>$nama_dosen</small>";
        echo "</div>";
        echo "<a href='../Kelas/lihat_kelas.php?id={$kelas['id_kelas']}' class='btn btn-primary btn-sm'>Lihat Kelas</a>";
        echo "</div></div></div>";
    }
    echo "</div>";
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
<div>
    <h2>Dashboard</h2>
    <p>Selamat datang, <?= htmlspecialchars($nama_user) ?>!</p>

    <?php
    if ($role === 'Mahasiswa') {
        $stmt = mysqli_prepare($conn, "SELECT k.id_kelas, k.mata_kuliah, k.kelas_ik, k.semester, k.tahun 
                                        FROM kelas k JOIN kelas_anggota ka ON k.id_kelas = ka.id_kelas 
                                        WHERE ka.id_user = ?");
        mysqli_stmt_bind_param($stmt, "s", $id_user);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $kelas_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
        echo "<h4>Kelas yang Anda Ikuti</h4>";
        tampilkanKelasCard($kelas_list, $conn);

    } elseif ($role === 'Admin Prodi') {
        $stmt = mysqli_prepare($conn, "SELECT k.* FROM kelas k JOIN kelas_anggota ka ON k.id_kelas = ka.id_kelas WHERE ka.id_user = ? AND ka.role_di_kelas = 'Aslab'");
        mysqli_stmt_bind_param($stmt, "s", $id_user);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $kelas_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
        echo "<h4>Kelas Aslab Anda</h4>";
        tampilkanKelasCard($kelas_list, $conn);

    } elseif ($role === 'Dosen') {
        $stmt = mysqli_prepare($conn, "SELECT k.* FROM kelas k JOIN kelas_anggota ka ON k.id_kelas = ka.id_kelas WHERE ka.id_user = ? AND ka.role_di_kelas = 'Dosen'");
        mysqli_stmt_bind_param($stmt, "s", $id_user);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $kelas_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
        echo "<h4>Kelas yang Anda Ampu</h4>";
        tampilkanKelasCard($kelas_list, $conn);
    }
    ?>
</div>

<script src="../css/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
