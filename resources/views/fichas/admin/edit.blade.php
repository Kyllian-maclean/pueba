
@extends('index')

@section('content')

    <a href="{{ route('fichas.index') }}" id="btnBack" class="btn btn-primary">Retroceder</a>

    <br>
    <br>

    <h1>Editar Ficha</h1>

    <form action="{{ route('fichas.update', ['ficha' => $ficha]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="code">Codigo:</label>
            <input type="number" name="code" id="code" class="form-control" value="{{ $ficha->code }}" required>
        </div>

        <div class="form-group">
            <label for="programa_formacion">Nombres</label>
            <input type="text" name="programa_formacion" id="programa_formacion" class="form-control" step="0.01" value="{{ $ficha->programa_formacion }} " required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select required class="form-control" name="status" id="status">
                <option value="active" {{ $ficha->status === 'active' ? 'selected' : '' }}>Activo</option>
                <option value="inactive" {{ $ficha->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        
        <br>
          
        <button type="submit" class="btn btn-primary">Actualizar</button>
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