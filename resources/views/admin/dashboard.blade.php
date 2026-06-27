@extends('layouts.admin')

@section('title', 'Dashboard – Admin BusGoes')

@section('admin-content')
<h1 class="sub_heading">Dashboard</h1>

<div class="row mt-4 mb-4">
  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
    <div class="rounded shadow p-4 text-center" style="background-color:#4e046c;color:#fff;">
      <h2 style="font-size:40px;font-weight:900;">{{ $totalBuses }}</h2>
      <p class="mb-0" style="font-weight:700;color:#f5c481;">Total Bus Schedules</p>
    </div>
  </div>
  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
    <div class="rounded shadow p-4 text-center" style="background-color:#82ca9c;color:#000;">
      <h2 style="font-size:40px;font-weight:900;">{{ $totalBookings }}</h2>
      <p class="mb-0" style="font-weight:700;">Total Bookings</p>
    </div>
  </div>
  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
    <div class="rounded shadow p-4 text-center" style="background-color:#f5c481;color:#000;">
      <h2 style="font-size:40px;font-weight:900;">{{ $totalUsers }}</h2>
      <p class="mb-0" style="font-weight:700;">Registered Users</p>
    </div>
  </div>
</div>

<h1 class="sub_heading mt-4">Recent Bookings</h1>
<div class="table-responsive mt-3">
  <table class="table table-bordered table-hover">
    <thead style="background-color:#4e046c;color:#fff;">
      <tr>
        <th>Booking ID</th>
        <th>Passenger</th>
        <th>Route</th>
        <th>Date</th>
        <th>Seats</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse($recentBookings as $b)
      <tr>
        <td>#{{ $b->id }}</td>
        <td>{{ $b->user->first_name }} {{ $b->user->last_name }}</td>
        <td>{{ $b->busSchedule->route_from }} &rarr; {{ $b->busSchedule->route_to }}</td>
        <td>{{ $b->busSchedule->schedule_date }}</td>
        <td>{{ $b->seat_numbers }}</td>
        <td>
          @if($b->status==='confirmed')
            <span class="badge" style="background-color:#82ca9c;color:#000;">Confirmed</span>
          @else
            <span class="badge bg-secondary">Cancelled</span>
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center">No bookings yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<a href="{{ route('admin.bookings') }}" class="a_link">View all bookings &rarr;</a>
@endsection
