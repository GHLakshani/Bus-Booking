<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Online Bus Seats Booking System')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/bus_booking.css') }}" rel="stylesheet">
  <link href="{{ asset('css/mediaquery.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  @stack('styles')
  <style>
    ::-webkit-scrollbar { background:#eee; height:5px; width:5px; }
    ::-webkit-scrollbar-track { box-shadow:inset 0 0 2px #002367; }
    ::-webkit-scrollbar-thumb { background:#002367; border-radius:2px; }
  </style>
</head>
<body>

<!-- Top Bar -->
<div class="clearfix"></div>
<div class="container-fluid top_logo_row" style="background-color:#f8f8fa;">
  <div class="container">
    <div class="row">
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="d-grid gap-2 d-md-flex justify-content-md-start top_btn_set_div">
          <p class="top_social_icon mb-0">
            Follow Us on -
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-instagram"></a>
            <a href="#" class="fa fa-twitter"></a>
            <a href="#" class="fa fa-linkedin"></a>
          </p>
        </div>
      </div>
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end top_btn_set_div">
          @guest
            <a href="{{ route('register') }}"><button type="button" class="btn btn-primary blue_white_btn">Sign Up</button></a>
            <a href="{{ route('login') }}"><button type="button" class="btn btn-primary blue_btn">Login</button></a>
          @else
            <a href="{{ route('my.account') }}"><button type="button" class="btn btn-primary magenta_btn"><img src="{{ asset('images/account.png') }}" width="20px">&nbsp;Hi.. {{ auth()->user()->first_name }}</button></a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
              @csrf
              <button type="submit" class="btn btn-primary blue_btn">Log Out</button>
            </form>
          @endguest
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>

@yield('content')

<!-- Footer -->
<div class="container-fluid footer_row text-center">
  <div class="container">
    <div class="row">
      <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo mx-auto mb-3">
      <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
      <p class="top_social_icon mb-5">
        Follow Us on<br>
        <a href="#" class="fa fa-facebook"></a>
        <a href="#" class="fa fa-instagram"></a>
        <a href="#" class="fa fa-twitter"></a>
        <a href="#" class="fa fa-linkedin"></a>
      </p>
      <p class="mb-0" style="text-align:center;font-weight:500;color:#999999;">Copyright &copy; 2024 BusGoes All Rights Reserved.<br>Solution by Lakshan Basnayaka</p>
    </div>
  </div>
</div>

<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@stack('scripts')
</body>
</html>
