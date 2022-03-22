<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sigestor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="{{ asset('css/public.css') }}">
</head>
<body>
  <header class="header" id="header">
    <div class="header_toggle"></div>
    <div class="header_text">
      <a type="button" href="/inicio" class="btn btn-primary">Login</a>
    </div>
  </header>
  <div class="container">
    <div class="main">
      <div class="img">
        <img src="{{ asset('storage/img/logo-sigestor.png') }}" alt="" height="300px" class="logo">
      </div>
      <div class="card links-container">
        <div class="card-body d-grid gap-2">
          <a href="#" class="btn btn-lg btn-secondary" type="button">Matriz Orçamentária</a>
          <a href="#" class="btn btn-lg btn-secondary" type="button">Metas Estratégicas</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>