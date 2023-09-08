
@extends('index_instructor')

@section('content')

    <br>
    <h1>Excusas del aprendiz</h1>
    <br>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Codigo Aprendiz</th>
                <th>Aprendiz</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Archivo</th>
                <th>Acciones</th>


            </tr>
        </thead>
        <tbody>
            @foreach ($excusas as $excusa)
               
                <tr>
                    <td>{{ $excusa->aprendiz_id }}</td>
                    <td>{{ $excusa->first_name }} - {{ $excusa->last_name }} - {{$excusa->code}}</td>
                    <td>
                        {{ $excusa->estado }}
                    </td>
                    <td>{{ $excusa->date }}</td>
                    <td>
                        <div class="textarea-container">
                            <textarea class="form-control excusa-motivo" rows="3" readonly>{{ $excusa->motivo }}</textarea>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('descargar.pdf', ['nombreArchivo' => $excusa->file_path]) }}" class="btn btn-primary">Descargar PDF</a>
                    </td>
                    <td>
                        @if($excusa->estado == 'Pendiente')
                       
                        <form  style="display: inline;" action="{{ route('fichas.instructor.aprobar', ['excusa' => $excusa]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Aprobar</button>
                        </form>

                        <form  style="display: inline;" action="{{ route('fichas.instructor.rechazar', ['excusa' => $excusa]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Rechazar</button>
                        </form>
                        
                        @elseif($excusa->estado == 'Aprobado')
                        <form  style="display: inline;" action="{{ route('fichas.instructor.rechazar', ['excusa' => $excusa]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Rechazar</button>
                        </form>

                        @else
                        <form  style="display: inline;" action="{{ route('fichas.instructor.aprobar', ['excusa' => $excusa]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Aprobar</button>
                        </form>
                        @endif
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