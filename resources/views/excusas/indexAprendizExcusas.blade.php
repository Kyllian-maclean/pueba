
@extends('index_aprendiz')

@section('content')

    <a href="{{ route('excusas.create.index') }}" class="btn btn-success">Crear Excusa</a>
    <br>
    <br>
    <h1>Excusas del aprendiz</h1>
    <br>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Codigo Aprendiz</th>
                <th>Instructor</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Archivo</th>


            </tr>
        </thead>
        <tbody>
            @foreach ($excusas as $excusa)
               
                <tr>
                    <td>{{ $excusa->aprendiz_id }}</td>
                    <td>{{ $excusa->first_name }} - {{ $excusa->last_name }}</td>
                    <td>{{ $excusa->estado }}</td>
                    <td>{{ $excusa->date }}</td>
                    <td>
                        <div class="textarea-container">
                            <textarea class="form-control excusa-motivo" rows="3" readonly>{{ $excusa->motivo }}</textarea>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('descargar.pdf', ['nombreArchivo' => $excusa->file_path]) }}" class="btn btn-primary">Descargar PDF</a>
                    </td>
                
                </tr>
            
            @endforeach
        </tbody>
    </table>

    <div class="pagination-results">
        Mostrando {{ $excusas->firstItem() }} a {{ $excusas->lastItem() }} de {{ $excusas->total() }} resultados.
        <br>
        @if ($excusas->previousPageUrl())
            <a href="{{ $excusas->previousPageUrl() }}">Anterior</a>
        @endif
    
        @if ($excusas->nextPageUrl())
            <a href="{{ $excusas->nextPageUrl() }}">Siguiente</a>
        @endif
    </div>
    <br>
    <br>


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
@endsection