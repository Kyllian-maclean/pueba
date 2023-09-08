
@extends('index')

@section('content')
    <a href="{{ route('users.index') }}" id="btnBack" class="btn btn-primary">Retroceder</a>
    
<div class="titulos-crear">
    <div>
        <h1>Crear Usuario</h1>
    </div>
</div>
    <!-- <header>
        <h1 class="form-title">Crear Usuario</h1>
    </header> -->

    <main class="container">

        <form action="{{ route('users.store') }}" method="POST" class="form-body">
            @csrf
            <div>
                <div>
                    <label class="form-label" for="code" >Codigo</label>
                    <input type="number" name="code" id="code" class="input-text" required>
                </div>

                <div>
                    <label class="form-label" for="first_name">Nombres</label>
                    <input type="text" name="first_name" id="first_name" class="input-text" step="0.01" required>
                </div>

                <div >
                    <label class="form-label" for="last_name">Apellidos</label>
                    <input type="text" name="last_name" id="last_name" class="input-text" step="0.01"  required>
                </div>

                <div>
                <label class="form-label highligthed" for="status">Roles</label>
                    <div class="form-footer">
                        <div class="form-check">
                            <input  type="checkbox" name="aprendiz" id="aprendiz">
                            <label  for="aprendiz">Aprendiz</label>
                        </div>

                        <div class="form-check">
                            <input  type="checkbox" name="instructor" id="instructor">
                            <label  for="instructor">Instructor</label>
                        </div>

                        <div class="form-check">
                            <input  type="checkbox" name="admin" id="admin">
                            <label  for="admin">Administrador</label>
                        </div>
                    </div>
                    
                </div>
            </div>
        
            <div class="create">
                <div class="status">
                    <label for="form-label" class="form-label">Estado</label>
                    <select  required class="form-control" name="status" id="status">
                        <option value="active">Activo</option>
                        <option value="inactive">Inactivo</option>
                    </select>
                </div>
                <br>
                
                <div>
                    <label class="form-label" for="email">Correo Electronico</label>
                    <input type="email" name="email" id="email" class="input-text" step="0.01"  required>                   
                </div>
                

                <div>
                    <label class="form-label  "for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="input-text" required>
                </div>
                
                <div class="btn-crear">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </main>
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
