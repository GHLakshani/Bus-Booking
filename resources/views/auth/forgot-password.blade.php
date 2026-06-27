<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password – BusGoes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/bus_booking.css') }}" rel="stylesheet">
</head>
<body class="body_bg">
<div class="container">
  <div class="row login_section_div">
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
      <img src="{{ asset('images/p_reset.gif') }}" alt="" class="img-fluid mx-auto d-block p_reset_img d-none d-lg-block">
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
      <div class="shadow p-5 mb-1 bg-body rounded">
        <div class="col" style="padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #f5c481;">
          <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo">
        </div><br>
        <h1 class="heading mb-2"><b>FORGOT PASSWORD</b></h1>
        <p>Enter your registered email and we'll send you a reset link.</p>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('forgot.password') }}">
          @csrf
          <div class="row">
            <div class="col-12 mb-3">
              <div class="form-floating">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <label>Your Email Address</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary green_btn" style="width:100%;font-weight:900;height:55px;">SEND RESET LINK</button>
            </div>
            <p style="text-align:center;font-weight:700;margin-top:15px;"><a href="{{ route('home') }}" class="a_link">Back to Home</a></p>
            <p class="mb-0" style="text-align:center;font-weight:500;color:#999999;">Copyright &copy; 2024 BusGoes All Rights Reserved.</p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
