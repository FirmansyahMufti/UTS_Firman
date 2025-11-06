<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - UTS Firman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-success text-white">
                    <h4>Daftar Akun</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($validation)): ?>
                        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                    <?php endif; ?>

                    <form action="/register" method="post">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button class="btn btn-success w-100">Register</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="/login">Sudah punya akun? Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
