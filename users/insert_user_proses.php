<?php
include '../koneksi.php';
if (!$conn) {
    die("Koneksi tidak berhasil: " . mysqli_connect_error());
}

$id = $_POST['id_user'];
$nama = $_POST['nama_user'];
$role = $_POST['role_user'];

if (!isset($_POST['password_user'])) {
    echo "Password tidak terkirim. <a href='insert_user_form.php'>Kembali</a>";
    exit;
}

$password_raw = $_POST['password_user'];
$pass = password_hash($password_raw, PASSWORD_DEFAULT);

// Periksa apakah ID sudah digunakan
$cek = mysqli_prepare($conn, "SELECT COUNT(*) FROM users WHERE id_user = ?");
mysqli_stmt_bind_param($cek, "s", $id);
mysqli_stmt_execute($cek);
mysqli_stmt_bind_result($cek, $jumlah);
mysqli_stmt_fetch($cek);
mysqli_stmt_close($cek);

if ($jumlah > 0) {
    echo "ID sudah digunakan. Silakan pilih ID lain. <br><a href='insert_user_form.php'>Kembali</a>";
    exit;
}

// Upload foto
$fotoName = $_FILES['foto_user']['name'];
$tmp = $_FILES['foto_user']['tmp_name'];

$fotoBaru = null;
if ($fotoName != "") {
    $ext = pathinfo($fotoName, PATHINFO_EXTENSION);
    $safe_nama = strtolower(str_replace(" ", "", $nama));
    $fotoBaru = "{$safe_nama}_{$id}_{$role}." . $ext;
    $target = "../Penyimpanan/img/" . $fotoBaru;
    move_uploaded_file($tmp, $target);
}

$query = "INSERT INTO users (id_user, nama_user, password_user, role_user, foto_user, first_login) 
          VALUES (?, ?, ?, ?, ?, 1)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssss", $id, $nama, $pass, $role, $fotoBaru);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>  
        alert('User berhasil ditambahkan.');
        window.location.href = 'insert_user_form.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menambahkan user.');
        window.location.href = 'insert_user_form.php';
    </script>";
}
