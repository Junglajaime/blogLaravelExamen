@extends('footerHeader')

@section('titulo', 'Título de la página')

@section('contenido')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Listado de Entradas</h3>
                        <div>
                            <a href="{{ route('entradas.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <!-- Ícono SVG descargado de http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                Añadir Entrada
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body border-bottom py-3">
                        <div class="d-flex">
                            <div class="text-muted">
                                Mostrar
                                <div class="mx-2 d-inline-block">
                                    <select id="entries-select" class="form-select form-select-sm">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                entradas
                            </div>
                            
                            <div class="ms-auto text-muted">
                                Buscar:
                                <div class="ms-2 d-inline-block">
                                    <input type="text" id="search-input" class="form-control form-control-sm"
                                           aria-label="Buscar entrada">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Título</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Fecha de Creación</th>                
                                    <th scope="col">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entradas as $entrada)
                                <tr>
                                    <td class="align-middle">{{ $entrada->titulo }}</td>
                                    <td class="align-middle"><img src="{{ asset('assets/' . $entrada->imagen) }}" class="img-thumbnail" style="max-width: 100px;"></td>
                                    <td class="align-middle">{{ $entrada->usuario->name }}</td>
                                    <td class="align-middle">{{ $entrada->categoria->nombre }}</td>
                                    <td class="align-middle">{{ $entrada->created_at }}</td>
                                    <td class="align-middle">
                                        <a href="{{ route('entradas.show', $entrada->id) }}" class="btn btn-sm btn-info">Ver</a>
                                        <a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta entrada?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-muted">Mostrando {{ $entradas->firstItem() }} de {{ $entradas->lastItem() }} Total: {{ $entradas->total() }} entradas</p>
                        <div class="ms-auto">
                            {{ $entradas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
