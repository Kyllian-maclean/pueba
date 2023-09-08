@extends('index_aprendiz')

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
        <hr>
        <div class="mb-4">
          {!!QrCode::size(200)->generate($user->code); !!}
        </div>

        
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