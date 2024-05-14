<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
   
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>
<body class="d-flex flex-column">

<header class="bg-dark py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="text-light">Tareas</h1>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-info">Cerrar Sesión</button>
        </form>
    </div>
</header>

<main class="py-4 flex-grow-1">
    <div class="container">
        @yield('contenido')
    </div>
</main>

<footer class="bg-dark text-light py-3">
    <div class="container">
        <p>Tarea Presencial 6 - Desarrollo web entorno servidor</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
