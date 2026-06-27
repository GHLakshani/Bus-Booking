<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin – BusGoes')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/bus_booking.css') }}" rel="stylesheet">
  <link href="{{ asset('css/mediaquery.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
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
          <a href="{{ route('admin.dashboard') }}"><button type="button" class="btn btn-primary magenta_btn"><img src="{{ asset('images/account.png') }}" width="20px">&nbsp;Admin: {{ auth()->user()->first_name }}</button></a>
          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-primary blue_btn">Log Out</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<!-- Hero Banner -->
<div class="container-fluid header_top_div" style="background-image:url('{{ asset('images/body_bg.jpg') }}') !important;">
  <div class="container">
    <div class="row m-auto">
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="col" style="padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #f5c481;">
          <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo">
        </div>
        <p>Manage buses, routes, bookings and GPS tracking from your admin panel.</p>
      </div>
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 d-none d-lg-block">
        <img src="{{ asset('images/find.png') }}" alt="" class="img-fluid mx-auto d-block">
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div><br><br>

<!-- Page Body -->
<div class="container">
  <div class="row">

    <!-- Sidebar Nav -->
    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
      <h1 class="heading">ADMIN</h1>

      <a href="{{ route('admin.dashboard') }}">
        <div class="left_side_btn_div {{ request()->routeIs('admin.dashboard') ? 'left_side_btn_div_active' : '' }}">
          Dashboard
        </div>
      </a>
      <a href="{{ route('admin.buses') }}">
        <div class="left_side_btn_div {{ request()->routeIs('admin.buses*') ? 'left_side_btn_div_active' : '' }}">
          Bus Schedules
        </div>
      </a>
      <a href="{{ route('admin.buses.create') }}">
        <div class="left_side_btn_div {{ request()->routeIs('admin.buses.create') ? 'left_side_btn_div_active' : '' }}">
          Add Bus
        </div>
      </a>
      <a href="{{ route('admin.bookings') }}">
        <div class="left_side_btn_div {{ request()->routeIs('admin.bookings') ? 'left_side_btn_div_active' : '' }}">
          View Bookings
        </div>
      </a>
      <a href="{{ route('admin.users') }}">
        <div class="left_side_btn_div {{ request()->routeIs('admin.users') ? 'left_side_btn_div_active' : '' }}">
          Manage Users
        </div>
      </a>
      <a href="{{ route('admin.notify.delay') }}">
        <div class="left_side_btn_div {{ request()->routeIs('admin.notify.delay') ? 'left_side_btn_div_active' : '' }}">
          Notify Delay
        </div>
      </a>
      <a href="{{ route('admin.update.gps') }}">
        <div class="left_side_btn_div {{ request()->routeIs('admin.update.gps') ? 'left_side_btn_div_active' : '' }}">
          Update GPS
        </div>
      </a>
    </div>

    <!-- Main Content -->
    <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @yield('admin-content')
    </div>

  </div>
</div>

<div class="clearfix"></div><br><br>

<!-- Footer -->
<div class="container-fluid footer_row text-center">
  <div class="container">
    <div class="row">
      <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo mx-auto mb-3">
      <p class="mb-0" style="text-align:center;font-weight:500;color:#999999;">Copyright &copy; 2024 BusGoes All Rights Reserved.<br>Solution by Lakshan Basnayaka</p>
    </div>
  </div>
</div>

<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
@stack('scripts')
</body>
</html>
