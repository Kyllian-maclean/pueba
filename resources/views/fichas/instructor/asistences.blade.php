
@extends('index_instructor')

@section('content')

    <a href="{{ route('fichas.instructor.view', ['ficha' => $ficha]) }}" id="btnBack" class="btn btn-primary">Retroceder</a>

    <br>
    <br>

    <h1>Aprendiz</h1>

    <form >
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="code">Codigo:</label>
            <input type="number" name="code" id="code" class="form-control" value="{{ $user->code }}" disabled>
        </div>

        <div class="form-group">
            <label for="first_name">Nombres</label>
            <input type="text" name="first_name" id="first_name" class="form-control" step="0.01" value="{{ $user->first_name }} " disabled>
        </div>

        <div class="form-group">
            <label for="last_name">Apellidos</label>
            <input type="text" name="last_name" id="last_name" class="form-control" step="0.01" value="{{$user->last_name}}" disabled>
        </div>

        <div class="form-group">
            <label for="email">Correo Electronico</label>
            <input type="email" name="email" id="email" class="form-control" step="0.01" value="{{$user->email}}" disabled>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select disabled class="form-control" name="status" id="status">
                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Activo</option>
                <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        
    </form>
    <br>
    <h1>Asistencias del aprendiz</h1>
    <a href="{{ route('exportar.asistencias', ['code' => $user->code, 'ficha' => $ficha]) }}" class="btn btn-success">Exportar a Excel</a>

    <br>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Codigo Aprendiz</th>
                <th>Entrada</th>
                <th>Salida</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($asistences as $asist)
               
                <tr>
                    <td>{{ $asist->user_id }}</td>
                    <td>{{ $asist->date }}</td>
                    <td>{{ $asist->create_at_salida }}</td>
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