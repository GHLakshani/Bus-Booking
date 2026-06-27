@extends('layouts.admin')

@section('title', 'View Bookings – Admin BusGoes')

@push('styles')
<style>#bookings_table { width:100% !important; }</style>
@endpush

@section('admin-content')
<h1 class="sub_heading">All Bookings</h1>

<div class="table-responsive mt-3 mb-4">
  <table id="bookings_table" class="display">
    <thead>
      <tr>
        <th>#</th>
        <th>Passenger</th>
        <th>Email</th>
        <th>Route</th>
        <th>Date</th>
        <th>Departure</th>
        <th>Seats</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($bookings as $b)
      <tr>
        <td>#{{ $b->id }}</td>
        <td>{{ $b->user->first_name }} {{ $b->user->last_name }}</td>
        <td>{{ $b->user->email }}</td>
        <td>{{ $b->busSchedule->route_from }} &rarr; {{ $b->busSchedule->route_to }}</td>
        <td>{{ $b->busSchedule->schedule_date }}</td>
        <td>{{ $b->busSchedule->departure_time }}</td>
        <td>{{ $b->seat_numbers }}</td>
        <td>
          @if($b->status==='confirmed')
            <span class="badge" style="background-color:#82ca9c;color:#000;">Confirmed</span>
          @else
            <span class="badge bg-secondary">Cancelled</span>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() { $('#bookings_table').DataTable(); });
</script>
@endpush
