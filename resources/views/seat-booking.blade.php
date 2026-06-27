@extends('layouts.app')

@section('title', 'Seat Booking – BusGoes')

@push('styles')
<style>
  .bus_seat input[type="checkbox"] { display:none; }
  .bus_seat.selected { background-color:#447BCC !important; }
  .bus_seat.booked_seat { background-color:#b7b7b7 !important; cursor:not-allowed; }
</style>
@endpush

@section('content')
<div class="container-fluid header_top_div" style="background-image:url('{{ asset('images/body_bg.jpg') }}') !important;">
  <div class="container">
    <div class="row m-auto">
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="col" style="padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #f5c481;">
          <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo">
        </div>
        <p>Select your preferred seats from the layout below.</p>
      </div>
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 d-none d-lg-block">
        <img src="{{ asset('images/find.png') }}" alt="" class="img-fluid mx-auto d-block">
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div><br><br>

<div class="container">
  <div class="row">
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 mb-3">
      @if($busSchedule->bus_image)
        <img src="{{ asset('uploads/'.$busSchedule->bus_image) }}" alt="" class="d-block mx-auto w-100 rounded shadow">
      @else
        <img src="{{ asset('images/bus.jpg') }}" alt="" class="d-block mx-auto w-100 rounded shadow">
      @endif
    </div>
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12 mb-5">
      <div class="rounded shadow p-4" style="background-color:#eeeeee;">
        <p class="fst-italic mb-1">Duration: {{ $busSchedule->duration }} Hours | {{ $busSchedule->bus_type }} | {{ $busSchedule->schedule_date }}</p>
        <h1 class="sub_heading mb-3">{{ $busSchedule->route_from }} to {{ $busSchedule->route_to }}</h1>
        <p class="mb-1">Time – {{ $busSchedule->departure_time }}</p>
        <p class="mb-1">Model – {{ $busSchedule->bus_model }}</p>
        <p class="mb-1">Schedule ID – {{ $busSchedule->schedule_id }}</p>
        <p class="mb-1">Depot – {{ $busSchedule->depot_name }}</p>
        @if($busSchedule->delay_minutes > 0)
          <p class="mb-1 text-danger"><strong>Delayed by {{ $busSchedule->delay_minutes }} minutes</strong></p>
        @endif
        <h1 class="heading mb-1">Rs. {{ number_format($busSchedule->fare, 2) }} / <b style="font-size:20px;color:red;">Available Seats {{ $busSchedule->available_seats }}</b></h1>
        <a href="{{ route('track.bus', $busSchedule->id) }}" class="a_link">Track this bus live &rarr;</a>
      </div>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-lg-3 col-sm-6 col-6"><div class="color_box" style="background-color:#598527;"></div><p>Available</p></div>
    <div class="col-lg-3 col-sm-6 col-6"><div class="color_box" style="background-color:#447BCC;"></div><p>Selected</p></div>
    <div class="col-lg-3 col-sm-6 col-6"><div class="color_box" style="background-color:#b7b7b7;"></div><p>Booked</p></div>
  </div>

  @php $booked = $bookedSeats; @endphp

  <div class="row m-auto mt-5 mb-5" style="justify-content:center;">
    <div style="width:75px;"><img src="{{ asset('images/steering-wheel.png') }}" width="60px" class="float-start"></div>

    @php
      $rows = [
        [['01','02','03'],['04','05']],
        [['06','07','08'],['09','10']],
        [['11','12','13'],['14','15']],
        [['16','17','18'],['19','20']],
        [['21','22','23'],['24','25']],
        [['26','27','28'],['29','30']],
        [['31','32','33'],['34','35']],
        [['36','37','38'],['39','40']],
        [['41','42','43'],['44','45']],
        [['46','47','48'],['49','50','51']],
      ];
    @endphp

    @foreach($rows as $row)
    <div class="main_seat_row">
      <div class="bus_seat_row_3">
        @foreach($row[0] as $seat)
          @if(in_array($seat, $booked))
            <div class="bus_seat booked_seat" title="Seat {{ $seat }} – Booked">{{ $seat }}</div>
          @else
            <div class="bus_seat" data-seat="{{ $seat }}" onclick="toggleSeat(this)">{{ $seat }}</div>
          @endif
        @endforeach
      </div>
      <div class="bus_seat_row_2 {{ $loop->last ? 'mt-0' : '' }}">
        @foreach($row[1] as $seat)
          @if(in_array($seat, $booked))
            <div class="bus_seat booked_seat" title="Seat {{ $seat }} – Booked">{{ $seat }}</div>
          @else
            <div class="bus_seat" data-seat="{{ $seat }}" onclick="toggleSeat(this)">{{ $seat }}</div>
          @endif
        @endforeach
      </div>
    </div>
    @endforeach
  </div>

  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12 m-auto">
    <div id="selectedInfo" class="mb-2 text-center" style="font-weight:700;color:#4e046c;"></div>
    @auth
      <button type="button" id="proceedBtn" class="btn btn-primary green_btn mb-3" style="width:100%;height:55px;">PROCEED NOW</button>
    @else
      <a href="{{ route('login') }}">
        <button type="button" class="btn btn-primary green_btn mb-3" style="width:100%;height:55px;">LOGIN TO BOOK</button>
      </a>
    @endauth
  </div>

  <hr>
</div>

<div class="clearfix"></div><br><br>

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

@push('scripts')
<script>
  const selectedSeats = [];
  const fare = {{ $busSchedule->fare }};

  function toggleSeat(el) {
    const seat = el.dataset.seat;
    if (el.classList.contains('selected')) {
      el.classList.remove('selected');
      selectedSeats.splice(selectedSeats.indexOf(seat), 1);
    } else {
      el.classList.add('selected');
      selectedSeats.push(seat);
    }
    const total = (selectedSeats.length * fare).toFixed(2);
    document.getElementById('selectedInfo').textContent =
      selectedSeats.length > 0
        ? `Selected: ${selectedSeats.join(', ')} | Total: Rs. ${total}`
        : '';
  }

  @auth
  document.getElementById('proceedBtn').addEventListener('click', function () {
    if (selectedSeats.length === 0) {
      alert('Please select at least one seat.');
      return;
    }

    fetch('{{ route('booking.store', $busSchedule->id) }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ selected_seats: JSON.stringify(selectedSeats) })
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        window.location.href = '{{ route('my.bookings') }}?booked=1';
      } else {
        alert(data.error || 'Booking failed.');
      }
    })
    .catch(() => alert('An error occurred. Please try again.'));
  });
  @endauth
</script>
@endpush
