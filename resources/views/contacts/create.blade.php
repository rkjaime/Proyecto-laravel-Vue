<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{  asset('css/app.css') }}">
    <title>Cidenet Laravel & Vue</title>
</head>
<body>
<div id="app">
    <navbar-component></navbar-component>

 <div>
    <h1 style="font-weight:bold;">Nuevo Usuario</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post"  action="{{ route('contacts.store') }}" >
          @csrf
          <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" placeholder="Nombre del usuario" class="form-control" name="name"/>
          </div>

          <div class="form-group">
              <label for="email">Email:</label>
              <input type="text" placeholder="Correo del usuario" class="form-control" name="email"/>
          </div>

          <button type="submit" onclick="window.location.href = '/';" class="btn btn-success">Save</button>
          <button type="submit" class="btn btn-secondary">Close</button>

      </form>
  </div>
</div>
</div>
</body>
<script src="{{  asset('js/app.js') }}"></script>
</html>
