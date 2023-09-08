@extends('index_instructor')

@section('content')
    <a href="{{ route('fichas.instructor.index') }}" id="btnBack" class="btn btn-primary">Retroceder</a>
    <br>
    <br>

    <h1>Ficha</h1>
    <br>

    <form action="{{ route('fichas.update', ['ficha' => $ficha]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="code">Codigo:</label>
            <input disabled type="number" name="code" id="code" class="form-control" value="{{ $ficha->code }}" required>
        </div>

        <div class="form-group">
            <label for="programa_formacion">Nombres</label>
            <input disabled type="text" name="programa_formacion" id="programa_formacion" class="form-control" step="0.01" value="{{ $ficha->programa_formacion }} " required>
        </div>

        <div  class="form-group">
            <label for="status">Estado</label>
            <select disabled required class="form-control" name="status" id="status">
                <option value="active" {{ $ficha->status === 'active' ? 'selected' : '' }}>Activo</option>
                <option value="inactive" {{ $ficha->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        
        <br>
    </form>
    <br>
    <br>
    <h1>Aprendices</h1>
    <a href="{{ route('fichas.instructor.marcar', $ficha->code) }}" class="btn btn-primary">QR</a>
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
            @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->code }}</td>
                        <td>{{ $student->first_name }} {{$student->last_name}}</td>
                        <td>{{ $student->status }}</td>
                        <td>
                            <a  class="btn btn-primary" href="{{ route('fichas.instructor.asistences', ['user' => $student->code,'ficha' => $ficha]) }}">Ver asistencias</a>
                            <form  style="display: inline;" action="{{ route('fichas.instructor.asistence', ['user' => $student->code,'ficha' => $ficha->code]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Marcar Asistencia</button>
                            </form>
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>

    <h1>Asistencias</h1>
    <br>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>User_ID</th>
                <th>Nombre</th>
                <th>Entrada</th>
                <th>Salida</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($asistencias as $asistencia)
            <tr>
                <td>{{ $asistencia->user_id}}</td>
                <td>{{ $asistencia->first_name}} {{ $asistencia->last_name}}</td>
                <td>{{ $asistencia->date}}</td>
                <td>{{ $asistencia->create_at_salida }}</td>
            </tr>
        @endforeach
            
        </tbody>
    </table>

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