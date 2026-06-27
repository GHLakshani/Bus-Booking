@extends('layouts.app')

@section('title', 'My Bookings – BusGoes')

@section('content')
<div class="container-fluid header_top_div" style="background-image:url('{{ asset('images/body_bg.jpg') }}') !important;">
  <div class="container">
    <div class="row m-auto">
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="col" style="padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #f5c481;">
          <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo">
        </div>
        <p>View and manage all your bus bookings.</p>
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
      <a href="#"><div class="left_side_btn_div">Hi... {{ auth()->user()->first_name }}</div></a>
      <a href="{{ route('my.bookings') }}"><div class="left_side_btn_div left_side_btn_div_active">My Bookings</div></a>
      <a href="{{ route('my.account') }}"><div class="left_side_btn_div">My Account</div></a>
      <a href="{{ route('home') }}"><div class="left_side_btn_div">Search Buses</div></a>
    </div>

    <!-- Content -->
    <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
      <h1 class="heading">My Bookings</h1>

      @if(request('booked'))
        <div class="alert alert-success">
          Your booking is confirmed! A confirmation email has been sent to your email address.
        </div>
      @endif

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if($bookings->isEmpty())
        <div class="alert alert-info">You have no bookings yet. <a href="{{ route('home') }}" class="a_link">Search for buses</a>.</div>
      @else
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover">
            <thead style="background-color:#4e046c;color:#fff;">
              <tr>
                <th>#</th>
                <th>Route</th>
                <th>Date</th>
                <th>Departure</th>
                <th>Seats</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bookings as $booking)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $booking->busSchedule->route_from }} &rarr; {{ $booking->busSchedule->route_to }}</td>
                <td>{{ $booking->busSchedule->schedule_date }}</td>
                <td>{{ $booking->busSchedule->departure_time }}</td>
                <td>{{ $booking->seat_numbers }}</td>
                <td>
                  @if($booking->status === 'confirmed')
                    <span class="badge" style="background-color:#82ca9c;color:#000;">Confirmed</span>
                  @else
                    <span class="badge bg-secondary">Cancelled</span>
                  @endif
                </td>
                <td>
                  @if($booking->status === 'confirmed')
                    <form method="POST" action="{{ route('booking.cancel', $booking->id) }}" onsubmit="return confirm('Cancel this booking?')">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                    </form>
                  @else
                    –
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

  </div>
</div>

<div class="clearfix"></div><br><br>
@endsection
