<?php
session_start();
include '../koneksi.php';
if (!$conn) {
    die("Koneksi tidak berhasil: " . mysqli_connect_error());
}

$id = $_POST['id_user'];
$pass = $_POST['password_user'];

$query = "SELECT * FROM users WHERE id_user = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($pass, $user['password_user'])) {
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['role_user'] = $user['role_user'];
    $_SESSION['nama_user'] = $user['nama_user'];
    $_SESSION['first_login'] = $user['first_login'];
    $_SESSION['foto_user'] = $user['foto_user']; 

    if ($user['first_login'] == 1) {
        header("Location: login_update_form.php");
    } else {
        header("Location: ../dashboard/dashboard.php");
    }
} else {
    echo "Login gagal. <a href='login_form.php'>Coba Lagi</a>";
}
?>
