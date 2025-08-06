<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Insert User</title>
</head>
<body>

<div>
  <div>
    <div>
      <h4>Tambah Pengguna</h4>

      <form action="insert_user_proses.php" method="POST" enctype="multipart/form-data">
        <div>
          <label>ID User</label>
          <input type="text" name="id_user" id="idInput" required>
        </div>

        <div>
          <label>Nama</label>
          <input type="text" name="nama_user" required>
        </div>

        <div>
          <input type="checkbox" id="autoPasswordCheckbox" onchange="togglePasswordInput(this)">
          <label for="autoPasswordCheckbox">
            Gunakan ID sebagai Password
          </label>
        </div>

        <div>
          <label>Password</label>
          <input type="password" name="password_user" id="passwordInput" required>
        </div>

        <div>
          <label>Role</label>
          <select name="role_user" required>
            <option value="" disabled selected>-- Pilih Role --</option>
            <option value="Mahasiswa">Mahasiswa</option>
            <option value="Dosen">Dosen</option>
            <option value="Aslab">Admin Prodi</option>
          </select>
        </div>

        <div>
          <label>Foto Profil</label>
          <input type="file" name="foto_user" accept="image/*">
        </div>

        <div>
          <button type="submit"> Simpan</button>
        </div>
      </form>

      <div>
          <a href="../dashboard/dashboard.php">
            Kembali ke Dashboard
          </a>
      </div>
    </div>
  </div>
</div>

<script src="../css/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

<script>
function togglePasswordInput(checkbox) {
  const passwordInput = document.getElementById('passwordInput');
  const idInput = document.getElementById('idInput');
  if (checkbox.checked) {
    passwordInput.value = idInput.value;
    passwordInput.readOnly = true;
  } else {
    passwordInput.value = '';
    passwordInput.readOnly = false;
  }
}
</script>
</body>
</html>
