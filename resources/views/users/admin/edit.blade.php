
@extends('index')

@section('content')

    <a href="{{ route('users.index') }}" id="btnBack" class="btn btn-primary">Retroceder</a>


    <div class="titulos-crear">
      <div>
          <h1>Editar Usuario</h1>
      </div>
    </div>

  <main class="container">
    <form action="{{ route('users.update', ['user' => $user] ,['userRoleIds'=>$userRoleIds]) }}" method="POST" class="form-body">
        @csrf
        @method('PUT')
        <div>
          <div>
              <label class="form-label" for="code" >Codigo</label>
              <input type="number" name="code" id="code" class="input-text" value="{{ $user->code }}" required>
          </div>

          <div>
              <label class="form-label" for="first_name">Nombres</label>
              <input type="text" name="first_name" id="first_name" class="input-text" step="0.01" value="{{ $user->first_name }} " required>
          </div>

          <div>
              <label class="form-label for="last_name">Apellidos</label>
              <input type="text" name="last_name" id="last_name" class="input-text" step="0.01" value="{{$user->last_name}}" required>
          </div>

          <div>
            <label class="form-label highligthed" for="status">Roles</label>
              <div class="form-footer">
                <div class="form-check">
                @if(in_array(3, $userRoleIds))
                  <input checked type="checkbox" name="aprendiz" id="aprendiz">
                @else
                  <input type="checkbox" name="aprendiz" id="aprendiz">
                @endif
                <label for="aprendiz">Aprendiz</label>
                </div>
              </div>

              <div class="form-check">
                @if(in_array(2, $userRoleIds))
                  <input  checked type="checkbox" name="instructor" id="instructor">
                @else
                  <input  type="checkbox" name="instructor" id="instructor">
                @endif
                <label for="instructor">Instructor</label>
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
        </div>

        <div class="edit">
          <div class="status">
              <label class="form-label" for="status">Estado</label>
              <select required class="form-control" name="status" id="status">
                  <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Activo</option>
                  <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
              </select>
          </div>
        
          <br>
          <div>
            <label  class="form-label" for="email">Correo Electronico</label>
            <input type="email" name="email" id="email" class="input-text" step="0.01" value="{{$user->email}}" required>
              
          </div>
          <div class="btn-crear">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
          </div>
        </div>
      </form>
  </main>
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
@endsection