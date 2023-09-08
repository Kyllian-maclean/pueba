@extends('index_instructor')

@section('content')

<div class="container mt-4">
    <h1>Perfil de Usuario</h1>
    <br>
    <form action="{{ route('users.update', ['user' => $user] ,['userRoleIds'=>$userRoleIds]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="code">Codigo:</label>
            <input disabled type="number" name="code" id="code" class="form-control" value="{{ $user->code }}" required>
        </div>

        <div class="form-group">
            <label for="first_name">Nombres</label>
            <input disabled type="text" name="first_name" id="first_name" class="form-control" step="0.01" value="{{ $user->first_name }} " required>
        </div>

        <div class="form-group">
            <label for="last_name">Apellidos</label>
            <input disabled type="text" name="last_name" id="last_name" class="form-control" step="0.01" value="{{$user->last_name}}" required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electronico</label>
            <input disabled type="email" name="email" id="email" class="form-control" step="0.01" value="{{$user->email}}" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select disabled required class="form-control" name="status" id="status">
                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Activo</option>
                <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        
        <br>
        <div class="form-group">
            <label for="status">Roles</label>
            <div class="form-check">
              @if(in_array(3, $userRoleIds))
                <input disabled class="form-check-input" checked type="checkbox" name="aprendiz" id="aprendiz">
              @else
                <input disabled class="form-check-input" type="checkbox" name="aprendiz" id="aprendiz">
              @endif
              <label class="form-check-label" for="aprendiz">Aprendiz</label>
            </div>
            <div class="form-check">
              @if(in_array(2, $userRoleIds))
                <input disabled class="form-check-input" checked type="checkbox" name="instructor" id="instructor">
              @else
                <input disabled class="form-check-input" type="checkbox" name="instructor" id="instructor">
              @endif
              <label class="form-check-label" for="instructor">Instructor</label>
            </div>
            <div class="form-check">
              @if(in_array(1, $userRoleIds))
                <input disabled class="form-check-input" checked type="checkbox" name="admin" id="admin">
              @else
                <input disabled class="form-check-input" type="checkbox" name="admin" id="admin">
              @endif
              <label class="form-check-label" for="admin">Administrador</label>
            </div>
          </div>
    </form>
    <div class="mt-4">
      <form action="{{ route('updatesPassword') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="currentPassword">Contraseña actual</label>
          <input type="password" name="currentPassword" id="currentPassword" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
          <label for="newPassword">Contraseña nueva</label>
          <input type="password" name="newPassword" id="newPassword" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
          <label for="confirmation">Confirmar</label>
          <input type="password" name="confirmation" id="confirmation" class="form-control" step="0.01" required>
        </div>

        <input class="btn btn-danger" type="submit" value="Cambiar Contraseña">
      </form>
    </div>
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