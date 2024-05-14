<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Entradas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Contenido</th>
                <th>Usuario</th>
                <th>Categoría</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entradas as $entrada)
            <tr>
                <td>{{ $entrada->titulo }}</td>
                <td>{{ $entrada->contenido }}</td>
                <td>{{ $entrada->usuario->name }}</td>
                <td>{{ $entrada->categoria->nombre }}</td>
                <td>{{ $entrada->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
