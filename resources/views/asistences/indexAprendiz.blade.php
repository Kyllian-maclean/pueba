
@extends('index_aprendiz')

@section('content')
    <br>
    <h1>Asistencias del aprendiz</h1>
    <br>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Codigo Aprendiz</th>
                <th>Fecha</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($asistences as $asist)
               
                <tr>
                    <td>{{ $asist->user_id }}</td>
                    <td>{{ $asist->date }}</td>
                </tr>
            
            @endforeach
        </tbody>
    </table>

    <div class="pagination-results">
        Mostrando {{ $asistences->firstItem() }} a {{ $asistences->lastItem() }} de {{ $asistences->total() }} resultados.
        <br>
        @if ($asistences->previousPageUrl())
            <a href="{{ $asistences->previousPageUrl() }}">Anterior</a>
        @endif
    
        @if ($asistences->nextPageUrl())
            <a href="{{ $asistences->nextPageUrl() }}">Siguiente</a>
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