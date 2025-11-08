<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - UTS Firman</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

  <div class="card shadow p-4" style="width: 400px;">
    <h4 class="text-center mb-3 text-primary fw-bold">Login Sistem Sensus</h4>
    <form id="loginForm">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" id="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" id="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <div id="alertBox" class="alert alert-danger mt-3 d-none"></div>
  </div>

  <script>
  document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const alertBox = document.getElementById('alertBox');

    try {
      const res = await fetch('<?= base_url("api/login") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
      });

      const data = await res.json();

      if (res.ok) {
        localStorage.setItem('jwt_token', data.token);
        window.location.href = '<?= base_url("dashboard") ?>';
      } else {
        alertBox.classList.remove('d-none');
        alertBox.innerText = data.message || 'Login gagal!';
      }
    } catch (err) {
      alertBox.classList.remove('d-none');
      alertBox.innerText = 'Terjadi kesalahan server.';
    }
  });
</script>

</body>
</html>
