
@extends('index')

@section('content')
    <a href="{{ route('fichas.index') }}" id="btnBack" class="btn btn-primary">Retroceder</a>

    <br>
    <br>
    <h1>Crear Ficha</h1>

    <form action="{{ route('fichas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code">Codigo</label>
            <input type="number" name="code" id="code" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="programa_formacion">Nombre</label>
            <input type="text" name="programa_formacion" id="programa_formacion" class="form-control" step="0.01" required>
        </div>
        
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('fichas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

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
