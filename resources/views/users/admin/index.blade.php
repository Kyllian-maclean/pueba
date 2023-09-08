@extends('index')

@section('content')

<div class="titulos">
    <div>
        <h1>Listado de Usuarios</h1>
    </div>
</div>

<div class="botones">
    <form action="{{ route('importar.usuarios') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-3 mt-3">
            <div class="input-group-append">
                <a href="{{ route('users.create') }}" class="btn-index btn btn-success">Crear Usuario</a>
                <a href="{{ route('exportar.usuarios') }}" class="btn-index btn btn-success">Exportar a Excel</a>
                <button type="submit" class="btn-index btn btn-primary">Importar</button>
            </div>
            <div class="custom-file">  
                <input required type="file" class="btn-index custom-file-input" name="archivo" id="archivo">
                <label class="custom-file-label" for="archivo">Seleccionar Archivo Excel</label>
            </div>
        </div>
    </form>
</div>
    
    <div>
        <div class="row justify-content-center">
            <div class="content-table mt-5">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @if ($user instanceof \App\Models\User)
                                <tr>
                                    <td>{{ $user->code }}</td>
                                    <td>{{ $user->first_name }} - {{$user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->code) }}" class="btn btn-primary">Editar</a>
                                        @if ($user->status == 'inactive')
                                            <form action="{{ route('users.activate', $user) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger">Activar</button>
                                            </form>
                                        @endif
                                        @if ($user->status == 'active')
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger">Inactivar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="pagination-results">
        Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} resultados.
        <br>
        @if ($users->previousPageUrl())
            <a href="{{ $users->previousPageUrl() }}">Anterior</a>
        @endif
    
        @if ($users->nextPageUrl())
            <a href="{{ $users->nextPageUrl() }}">Siguiente</a>
        @endif
    </div>

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonText: 'Cerrar'
        });
    </script>
    @endif
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                confirmButtonText: 'Cerrar'
            });
        </script>
    @endif
@endsection