@extends('index_instructor')


@section('content')

    <form  action="{{ route('fichas.instructor.asistenceQr') }}" method="POST">
        @csrf
        <input readonly hidden type="text" placeholder="" value="{{ $ficha->code }}"  name="ficha">
        <input type="text" placeholder="Escanar el QR" id='datos'  name="datos" autofocus>
        <button type="submit" value="ok" name="capturar" id="ejecutar" class="btn btn-primary">Enviar</button>
    </form>


    
    <div class="container">
        <div class="left">
            <div class="col-mb-6">
                <video id="preview" width="40%"></video>
            </div>
        </div>
    </div>
    <script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
      scanner.addListener('scan', function (content) {
        console.log(content);
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });

      scanner.addListener('scan',function(c){
        document.getElementById('datos').value=c;
        document.getElementById('ejecutar').click();
      })
    </script>


    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'Cerrar',
                timer: 1500
            });
            document.getElementById("datos").focus();
        </script>
    @endif
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                confirmButtonText: 'Cerrar',
                timer: 1500
            });
            document.getElementById("datos").focus();
        </script>
    @endif
    
@endsection