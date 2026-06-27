@extends('layouts.app')

@section('title', 'My Account – BusGoes')

@section('content')
<div class="container-fluid header_top_div" style="background-image:url('{{ asset('images/body_bg.jpg') }}') !important;">
  <div class="container">
    <div class="row m-auto">
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="col" style="padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #f5c481;">
          <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo">
        </div>
        <p>Your personal profile and account settings.</p>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div><br><br>

<div class="container">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
      <h1 class="heading">ACCOUNT</h1>
      <a href="#"><div class="left_side_btn_div">Hi... {{ $user->first_name }}</div></a>
      <a href="{{ route('my.bookings') }}"><div class="left_side_btn_div">My Bookings</div></a>
      <a href="{{ route('my.account') }}"><div class="left_side_btn_div left_side_btn_div_active">My Account</div></a>
      <a href="{{ route('home') }}"><div class="left_side_btn_div">Search Buses</div></a>
    </div>

    <!-- Content -->
    <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
      <h1 class="heading">Welcome {{ $user->first_name }} {{ $user->last_name }}</h1>
      <h1 class="sub_heading">Your Personal Details</h1>

      <div class="row mt-3 mb-4">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
          <div class="form-floating">
            <input type="text" class="form-control" value="{{ $user->first_name }}" readonly>
            <label>First Name</label>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
          <div class="form-floating">
            <input type="text" class="form-control" value="{{ $user->last_name }}" readonly>
            <label>Last Name</label>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
          <div class="form-floating">
            <input type="email" class="form-control" value="{{ $user->email }}" readonly>
            <label>Email</label>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
          <div class="form-floating">
            <input type="tel" class="form-control" value="{{ $user->telephone }}" readonly>
            <label>Phone Number</label>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
          <div class="form-floating">
            <input type="text" class="form-control" value="{{ $user->province }}" readonly>
            <label>Province</label>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
          <div class="form-floating">
            <input type="text" class="form-control" value="{{ $user->district }}" readonly>
            <label>District</label>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
          <div class="form-floating">
            <input type="text" class="form-control" value="{{ $user->address }}" readonly>
            <label>Address</label>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
          <div class="form-floating">
            <input type="text" class="form-control" value="{{ $user->postal_code }}" readonly>
            <label>Postal Code</label>
          </div>
        </div>
      </div>

      <div class="mt-2">
        <a href="{{ route('my.bookings') }}">
          <button type="button" class="btn btn-primary magenta_btn">View My Bookings</button>
        </a>
        <a href="{{ route('forgot.password') }}">
          <button type="button" class="btn btn-primary blue_btn ms-2">Change Password</button>
        </a>
      </div>
    </div>

  </div>
</div>

<div class="clearfix"></div><br><br>
@endsection
