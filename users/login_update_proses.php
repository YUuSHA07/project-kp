<?php
session_start();
include '../koneksi.php';

// Pastikan user login dan password baru diisi
if (!isset($_SESSION['id_user']) || !isset($_POST['new_password'])) {
    header("Location: login_form.php");
    exit;
}

$id = $_SESSION['id_user'];
$newPass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

// Update password dan set first_login = 0
$query = "UPDATE users SET password_user = ?, first_login = 0 WHERE id_user = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $newPass, $id);

if (mysqli_stmt_execute($stmt)) {
    // Arahkan ke satu dashboard umum
    header("Location: ../dashboard/dashboard.php");
    exit;
} else {
    echo "Gagal mengganti password. Silakan coba lagi.";
}
?>
