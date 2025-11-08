<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= esc($title ?? 'Dashboard - UTS Firman') ?></title>

    <!-- Bootstrap 5 -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous"
    >

    <!-- Font Awesome (icon) -->
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" 
        integrity="sha512-xh6VY7YwE7p1vO2o6+Pg5wT6X8V1Bx4NqvguT6kDfyO1rDHzrE1myUZclR3d7VQOnQvLQkV+3eE5+6oyZy8x3g==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer"
    />

    <!-- Custom style (optional) -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Poppins", sans-serif;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .card {
            border-radius: 10px;
        }
        .card-header {
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }
    </style>

    <!-- Axios (for API calls) -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
