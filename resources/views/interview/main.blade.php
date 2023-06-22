<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Booking (Docker)</title>
  <link rel="stylesheet" href="/bootstrap-3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="/i.css">
  @yield('css')
</head>
<body>
  <div class="row row-header">
    <div class="col-md-6">
      <i class="fa fa-home" aria-hidden="true"></i> <a href="{{ url('/') }}">Home</a>

      &nbsp;&nbsp;&nbsp;

      <i class="fa fa-search" aria-hidden="true"></i> <a href="{{ url('/') }}/search">Search</a>

      &nbsp;&nbsp;&nbsp;

      <i class="fa fa-file-text" aria-hidden="true"></i> <a href="{{ url('/') }}/requests-list">Requests List</a>

      &nbsp;&nbsp;&nbsp;

      @if (Auth::user())
        <i class="fa fa-plus" aria-hidden="true"></i> <a href="{{ url('/') }}/create">Make a booking</a>
      @endif
    </div>
    <div class="col-md-6" style="text-align: right;">
      @if (Auth::guest())
        <a href="{{ url('/login') }}"><button class="btn btn-primary">Login</button></a>
      @else
        <i class="fa fa-user" aria-hidden="true"></i> <a href="{{ url('/user') }}">{{ Auth::user()->name }}</a>

        &nbsp;&nbsp;&nbsp;

        <a href="{{ url('/logout') }}"><button class="btn btn-primary">Logout</button></a>
      @endif
    </div>
  </div>

  @if (count($data) > 0)
  <div class="alert alert-warning msg-for-user" role="alert">
    Programming
    <ul style="margin-top: .8rem">
      @foreach ($data as $m)
      <li>{{ $m->msg }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if (count($data_mktg) > 0)
  <div class="alert alert-info msg-for-user" role="alert">
    Marketing
    <ul style="margin-top: .8rem">
      @foreach ($data_mktg as $m)
      <li>{!! $m->msg !!}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @include('interview.status')

  @yield('content')

  <script src="/jquery-3.1.1.min.js"></script>
  <script src="/bootstrap-3.3.7/js/bootstrap.min.js"></script>
  <script src="/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
  @yield('js')
</body>
</html>
