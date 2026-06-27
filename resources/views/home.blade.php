@extends('layouts.app')

@section('title', 'BusGoes – Book Your Bus Online')

@section('content')
<!-- Hero Section -->
<div class="container-fluid header_top_div" style="background-image:url('{{ asset('images/body_bg.jpg') }}') !important;">
  <div class="container">
    <div class="row m-auto">
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="col" style="padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #f5c481;">
          <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo">
        </div>
        <div class="clearfix"></div>
        <p>Book bus seats online with real-time availability. Track your bus live with GPS. Fast, easy, reliable.</p>
        <div class="clearfix"></div>
      </div>
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 d-none d-lg-block">
        <img src="{{ asset('images/find.png') }}" alt="" class="img-fluid mx-auto d-block">
      </div>

      <!-- Search Form -->
      <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 slider_search_col home_search_col">
        <div class="shadow p-4 mb-1 rounded" style="background-color:#eeeeee;">
          <h2 class="sub_heading"><img src="{{ asset('images/search.png') }}" alt="" width="30px"> SEARCH</h2>
          <div class="clearfix"></div>
          <form action="{{ route('search') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <div class="form-floating mb-3">
                  <select class="form-select" name="route_from" required>
                    <option value="Colombo">Colombo</option>
                    <option value="Kandy">Kandy</option>
                    <option value="Galle">Galle</option>
                    <option value="Matale">Matale</option>
                    <option value="Jaffna">Jaffna</option>
                    <option value="Kurunegala">Kurunegala</option>
                    <option value="Anuradhapura">Anuradhapura</option>
                    <option value="Badulla">Badulla</option>
                    <option value="Ratnapura">Ratnapura</option>
                    <option value="Matara">Matara</option>
                  </select>
                  <label>From</label>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <div class="form-floating mb-3">
                  <select class="form-select" name="route_to" required>
                    <option value="Kandy">Kandy</option>
                    <option value="Colombo">Colombo</option>
                    <option value="Galle">Galle</option>
                    <option value="Matale">Matale</option>
                    <option value="Jaffna">Jaffna</option>
                    <option value="Kurunegala">Kurunegala</option>
                    <option value="Anuradhapura">Anuradhapura</option>
                    <option value="Badulla">Badulla</option>
                    <option value="Ratnapura">Ratnapura</option>
                    <option value="Matara">Matara</option>
                  </select>
                  <label>To</label>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <div class="form-floating mb-3">
                  <select class="form-select" name="bus_type" required>
                    <option value="Normal Bus">Normal Bus</option>
                    <option value="AC Bus">AC Bus</option>
                    <option value="Semi">Semi</option>
                    <option value="Highway">Highway</option>
                  </select>
                  <label>Bus Type</label>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <div class="form-floating mb-3">
                  <input type="date" class="form-control" name="date" required>
                  <label>Date</label>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12 m-auto">
                <button type="submit" class="btn btn-primary green_btn mb-3" style="width:100%;height:55px;">SEARCH NOW</button>
              </div>
            </div>
          </form>
        </div>
        <div class="clearfix"></div><br>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div><br><br>
<div class="container">
  <div class="row">
    <h1 class="heading">Welcome to BusGoes</h1>
    <p>Book your bus seats online with real-time seat availability. Track your bus live using GPS. Our platform provides a seamless, digital bus travel experience.</p>
  </div>
</div>
<div class="clearfix"></div><br><br>

<!-- Banners -->
<div class="container">
  <div class="row">
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
      <div class="banner_div shadow rounded" style="background-image:url('{{ asset('images/banner01.jpg') }}') !important;"></div>
    </div>
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
      <div class="banner_div shadow rounded" style="background-image:url('{{ asset('images/banner02.jpg') }}') !important;"></div>
    </div>
  </div>
</div>
<div class="clearfix"></div><br><br>
@endsection
