<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up – BusGoes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/bus_booking.css') }}" rel="stylesheet">
  <link href="{{ asset('css/mediaquery.css') }}" rel="stylesheet">
</head>
<body class="body_bg">
<div class="container">
  <div class="row login_section_div">
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12">
      <img src="{{ asset('images/reg.gif') }}" alt="" class="img-fluid mx-auto d-block p_reset_img d-none d-lg-block">
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
      <div class="shadow p-5 mb-1 bg-body rounded">
        <div class="col" style="padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #f5c481;">
          <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo">
        </div>
        <br>
        <h1 class="heading mb-2"><b>SIGN UP</b></h1>

        @if($errors->any())
          <div class="alert alert-danger">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="row">
            <div class="col-6 mb-3">
              <div class="form-floating">
                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') }}" required>
                <label>First Name</label>
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-floating">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}" required>
                <label>Last Name</label>
              </div>
            </div>
            <div class="col-12 mb-3">
              <div class="form-floating">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                <label>Email Address</label>
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-floating">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <label>Password</label>
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-floating">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                <label>Confirm Password</label>
              </div>
            </div>
            <div class="col-12 mb-3">
              <div class="form-floating">
                <input type="tel" name="telephone" class="form-control" placeholder="Telephone" value="{{ old('telephone') }}">
                <label>Telephone</label>
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-floating">
                <select name="province" class="form-select">
                  <option value="">Choose Province</option>
                  @foreach(['Western','Central','Northern','Eastern','Southern','North Western','North Central','Uva','Sabaragamuwa'] as $p)
                    <option value="{{ $p }}" {{ old('province')==$p?'selected':'' }}>{{ $p }}</option>
                  @endforeach
                </select>
                <label>Province</label>
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-floating">
                <select name="district" class="form-select">
                  <option value="">Choose District</option>
                  @foreach(['Colombo','Gampaha','Kalutara','Kandy','Matale','Nuwara Eliya','Galle','Matara','Hambantota','Jaffna','Kurunegala','Anuradhapura','Badulla','Ratnapura','Kegalle','Batticaloa','Trincomalee'] as $d)
                    <option value="{{ $d }}" {{ old('district')==$d?'selected':'' }}>{{ $d }}</option>
                  @endforeach
                </select>
                <label>District</label>
              </div>
            </div>
            <div class="col-12 mb-3">
              <button type="submit" class="btn btn-primary green_btn" style="width:100%;font-weight:900;height:55px;">REGISTER NOW</button>
            </div>
            <p style="text-align:center;">Already have an account? <a href="{{ route('login') }}" class="a_link"><b>Login Here</b></a></p>
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
