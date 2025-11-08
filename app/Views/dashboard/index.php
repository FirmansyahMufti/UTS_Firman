<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Sensus Penduduk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-stat { border-left: 5px solid #0d6efd; }
        .navbar-brand { font-weight: bold; }
        .table th { background-color: #0d6efd; color: white; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">UTS Firman</a>
    <div class="d-flex">
      <a href="/logout" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Dashboard Sistem Sensus Penduduk</h3>
        <p class="text-muted">Selamat datang di sistem pendataan sensus penduduk Indonesia</p>
    </div>

    <div class="row text-center mb-4">
        <div class="col-md-6 mb-3">
            <div class="card card-stat shadow-sm">
                <div class="card-body">
                    <h5 class="text-primary">Total Penduduk Terdaftar</h5>
                    <h2><?= isset($totalSensus) ? $totalSensus : 0; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card card-stat shadow-sm border-success">
                <div class="card-body">
                    <h5 class="text-success">Total Kota Terdaftar</h5>
                    <h2><?= isset($totalCity) ? $totalCity : 0; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📋 Data Sensus Terbaru</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Penduduk</th>
                        <th>Kota</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentSensus)): ?>
                        <?php $no = 1; foreach ($recentSensus as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= esc($row['nama_penduduk']); ?></td>
                                <td><?= esc($row['nama_kota']); ?></td>
                                <td><?= esc($row['alamat']); ?></td>
                                <td><?= esc($row['jenis_kelamin']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data sensus</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="text-center mt-4 mb-3 text-muted small">
    &copy; <?= date('Y'); ?> Sistem Sensus Penduduk - UTS Firman
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
