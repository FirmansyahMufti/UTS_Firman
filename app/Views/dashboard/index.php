<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - UTS Firman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">UTS Firman</a>
    <div class="d-flex">
      <a href="/logout" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5>Dashboard Sistem Sensus Penduduk</h5>
        </div>
        <div class="card-body">
            <p>Selamat datang, <strong><?= session()->get('username'); ?></strong> 👋</p>
            <p>Sistem ini berfungsi untuk pendataan dan pengelolaan sensus penduduk.</p>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-center border-primary">
                        <div class="card-body">
                            <h5 class="card-title">Data Sensus</h5>
                            <p class="card-text">Lihat, tambah, ubah, atau hapus data sensus penduduk.</p>
                            <a href="/sensus" class="btn btn-primary btn-sm">Kelola Sensus</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-success">
                        <div class="card-body">
                            <h5 class="card-title">Data Kota</h5>
                            <p class="card-text">Kelola master data kota untuk sensus.</p>
                            <a href="/kota" class="btn btn-success btn-sm">Kelola Kota</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-warning">
                        <div class="card-body">
                            <h5 class="card-title">Laporan</h5>
                            <p class="card-text">Lihat laporan hasil sensus berdasarkan kota dan kategori.</p>
                            <a href="#" class="btn btn-warning btn-sm disabled">Coming Soon</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
