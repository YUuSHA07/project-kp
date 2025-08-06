<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Password</title>
</head>
<body>
<div>
    <div>
        <h4>Login Pertama Kali</h4>
        <p>Silakan ganti password Anda untuk melanjutkan.</p>

        <form action="login_update_proses.php" method="POST">
            <div>
                <label for="new_password">Password Baru</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <button type="submit">Ubah Password</button>
        </form>
    </div>
</div>

</body>
</html>
