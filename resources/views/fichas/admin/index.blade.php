@extends('index')

@section('content')
    <h1>Listado de Fichas</h1>


    <form action="{{ route('importar.fichas') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-append">
                <a href="{{ route('fichas.create') }}" class="btn btn-success">Crear Ficha</a>
                <a href="{{ route('exportar.fichas') }}" class="btn btn-success">Exportar a Excel</a>
                <button type="submit" class="btn btn-primary">Importar</button>
            </div>
            <div class="custom-file">
                <br>
                <input required type="file" class="custom-file-input" name="archivo" id="archivo">
                <label class="custom-file-label" for="archivo">Seleccionar Archivo Excel</label>
            </div>
        </div>
    </form>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fichas as $ficha)
                @if ($ficha instanceof \App\Models\Ficha)
                    <tr>
                        <td>{{ $ficha->code }}</td>
                        <td>{{ $ficha->programa_formacion }}</td>
                        <td>{{ $ficha->status }}</td>
                        <td>
                            <a href="{{ route('fichas.edit', $ficha->code) }}" class="btn btn-primary">Editar</a>
                            @if ($ficha->status == 'inactive')
                                <form action="{{ route('fichas.activate', $ficha->code) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger">Activar</button>
                                </form>
                            @endif
                            @if ($ficha->status == 'active')
                                <form action="{{ route('fichas.destroy', $ficha->code) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger">Inactivar</button>
                                </form>
                            @endif
                            <a href="{{ route('fichas.view', $ficha->code) }}" class="btn btn-primary">Visualizar</a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="pagination-results">
        Mostrando {{ $fichas->firstItem() }} a {{ $fichas->lastItem() }} de {{ $fichas->total() }} resultados.
        <br>
        @if ($fichas->previousPageUrl())
            <a href="{{ $fichas->previousPageUrl() }}">Anterior</a>
        @endif
    
        @if ($fichas->nextPageUrl())
            <a href="{{ $fichas->nextPageUrl() }}">Siguiente</a>
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