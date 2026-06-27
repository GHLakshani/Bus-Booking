@extends('layouts.app')

@section('title', 'Search Results – BusGoes')

@section('content')
<div class="container-fluid header_top_div" style="background-image:url('{{ asset('images/body_bg.jpg') }}') !important;">
  <div class="container">
    <div class="row m-auto">
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="col" style="padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #f5c481;">
          <img src="{{ asset('images/logo.png') }}" alt="" class="d-block top_logo">
        </div>
        <p>Search results for your selected route and date.</p>
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
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      <h1 class="heading mb-4">{{ $request->route_from }} to {{ $request->route_to }} Buses</h1>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-end">
      <p class="fst-italic mb-1">Showing {{ $buses->count() }} result(s) for {{ $request->date }}</p>
    </div>
  </div>

  @if($buses->isEmpty())
    <div class="alert alert-warning">
      No buses found for your search. <a href="{{ route('home') }}" class="a_link">Try a different search</a>.
    </div>
  @else
    @foreach($buses as $bus)
    <div class="row mb-4">
      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 mb-3">
        @if($bus->bus_image)
          <img src="{{ asset('uploads/'.$bus->bus_image) }}" alt="" class="d-block mx-auto w-100 rounded shadow">
        @else
          <img src="{{ asset('images/bus.jpg') }}" alt="" class="d-block mx-auto w-100 rounded shadow">
        @endif
      </div>
      <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12 mb-5">
        <div class="rounded shadow p-4" style="background-color:#eeeeee;">
          <p class="fst-italic mb-1">Duration: {{ $bus->duration }} Hours | {{ $bus->bus_type }} | {{ $bus->schedule_date }}</p>
          <h1 class="sub_heading mb-3">{{ $bus->route_from }} to {{ $bus->route_to }}</h1>
          <p class="mb-1">Time – {{ $bus->departure_time }}</p>
          <p class="mb-1">Model – {{ $bus->bus_model }}</p>
          <p class="mb-1">Schedule ID – {{ $bus->schedule_id }}</p>
          <p class="mb-1">Depot – {{ $bus->depot_name }}</p>
          @if($bus->delay_minutes > 0)
            <p class="mb-1 text-danger"><strong>Delayed by {{ $bus->delay_minutes }} minutes</strong></p>
          @endif
          <h1 class="heading mb-3">Rs. {{ number_format($bus->fare, 2) }} / <b style="font-size:20px;color:red;">Available Seats {{ $bus->available_seats }}</b></h1>
          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('seat.booking', $bus->id) }}">
              <button type="button" class="btn btn-primary green_btn" style="height:45px;">BOOK SEATS</button>
            </a>
            <a href="{{ route('track.bus', $bus->id) }}">
              <button type="button" class="btn btn-primary magenta_btn" style="height:45px;">TRACK BUS</button>
            </a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  @endif

  <div class="mt-3">
    <a href="{{ route('home') }}" class="a_link">&#8592; Back to Search</a>
  </div>
</div>

<div class="clearfix"></div><br><br>
@endsection
