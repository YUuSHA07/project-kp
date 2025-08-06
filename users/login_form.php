<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div>
        <h3>Login</h3>
        <form action="login_proses.php" method="POST">
            <div class="mb-3">
                <label for="id_user">ID User</label>
                <input type="text" id="id_user" name="id_user" required>
            </div>
            <div>
                <label for="password_user">Password</label>
                <input type="password" id="password_user" name="password_user" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>