
@extends('index')

@section('content')
    <a href="{{ route('users.index') }}" id="btnBack" class="btn btn-primary">Retroceder</a>

    <br>
    <br>
    <h1>Crear Producto</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code">Codigo</label>
            <input type="number" name="code" id="code" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="first_name">Nombres</label>
            <input type="text" name="first_name" id="first_name" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="last_name">Apellidos</label>
            <input type="text" name="last_name" id="last_name" class="form-control" step="0.01"  required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electronico</label>
            <input type="email" name="email" id="email" class="form-control" step="0.01"  required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select  required class="form-control" name="status" id="status">
                <option value="active">Activo</option>
                <option value="inactive">Inactivo</option>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="status">Roles</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="aprendiz" id="aprendiz">
              <label class="form-check-label" for="aprendiz">Aprendiz</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="instructor" id="instructor">
              <label class="form-check-label" for="instructor">Instructor</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="admin" id="admin">
              <label class="form-check-label" for="admin">Administrador</label>
            </div>
          </div>
        <br>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <br>

        
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
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
