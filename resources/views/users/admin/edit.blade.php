
@extends('index')

@section('content')

    <a href="{{ route('users.index') }}" id="btnBack" class="btn btn-primary">Retroceder</a>

    <br>
    <br>

    <h1>Editar Usuario</h1>

    <form action="{{ route('users.update', ['user' => $user] ,['userRoleIds'=>$userRoleIds]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="code">Codigo:</label>
            <input type="number" name="code" id="code" class="form-control" value="{{ $user->code }}" required>
        </div>

        <div class="form-group">
            <label for="first_name">Nombres</label>
            <input type="text" name="first_name" id="first_name" class="form-control" step="0.01" value="{{ $user->first_name }} " required>
        </div>

        <div class="form-group">
            <label for="last_name">Apellidos</label>
            <input type="text" name="last_name" id="last_name" class="form-control" step="0.01" value="{{$user->last_name}}" required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electronico</label>
            <input type="email" name="email" id="email" class="form-control" step="0.01" value="{{$user->email}}" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select required class="form-control" name="status" id="status">
                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Activo</option>
                <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        
        <br>
        <div class="form-group">
            <label for="status">Roles</label>
            <div class="form-check">
              @if(in_array(3, $userRoleIds))
                <input class="form-check-input" checked type="checkbox" name="aprendiz" id="aprendiz">
              @else
                <input class="form-check-input" type="checkbox" name="aprendiz" id="aprendiz">
              @endif
              <label class="form-check-label" for="aprendiz">Aprendiz</label>
            </div>
            <div class="form-check">
              @if(in_array(2, $userRoleIds))
                <input class="form-check-input" checked type="checkbox" name="instructor" id="instructor">
              @else
                <input class="form-check-input" type="checkbox" name="instructor" id="instructor">
              @endif
              <label class="form-check-label" for="instructor">Instructor</label>
            </div>
            <div class="form-check">
              @if(in_array(1, $userRoleIds))
                <input class="form-check-input" checked type="checkbox" name="admin" id="admin">
              @else
                <input class="form-check-input" type="checkbox" name="admin" id="admin">
              @endif
              <label class="form-check-label" for="admin">Administrador</label>
            </div>
          </div>
          

        <button type="submit" class="btn btn-primary">Actualizar</button>
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