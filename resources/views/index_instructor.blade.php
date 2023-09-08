<!DOCTYPE html>
<html lang="en">
<head>
    @notifyCss
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="instascan.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <title>Biometric</title>

</head>
<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark py-2">
    <div class="container">
      <a class="navbar-brand" href="#">Biometric</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('fichas.instructor.index') }}">Fichas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('excusas.instructor.index') }}">Excusas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users.instructor.profile') }}">Contacto</a>
          </li>
          <li class="nav-item ml-auto">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<div class="container mt-4">
    @yield('content')
</div>
  @notifyJs
  @include('notify::components.notify')
</body>
</html>