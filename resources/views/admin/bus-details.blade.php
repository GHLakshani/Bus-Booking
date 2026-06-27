@extends('layouts.admin')

@section('title', 'Bus Schedules – Admin BusGoes')

@push('styles')
<style>
  #bus_table { width:100% !important; }
</style>
@endpush

@section('admin-content')
<h1 class="sub_heading">Bus Schedule Details</h1>

<div class="table-responsive mt-3 mb-4">
  <table id="bus_table" class="display">
    <thead>
      <tr>
        <th>Schedule ID</th>
        <th>From</th>
        <th>To</th>
        <th>Departure</th>
        <th>Bus Model</th>
        <th>Depot</th>
        <th>Fare</th>
        <th>Seats</th>
        <th>Type</th>
        <th>Date</th>
        <th>Delay</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      @foreach($buses as $bus)
      <tr>
        <td>{{ $bus->schedule_id }}</td>
        <td>{{ $bus->route_from }}</td>
        <td>{{ $bus->route_to }}</td>
        <td>{{ $bus->departure_time }}</td>
        <td>{{ $bus->bus_model }}</td>
        <td>{{ $bus->depot_name }}</td>
        <td>Rs. {{ number_format($bus->fare,2) }}</td>
        <td>{{ $bus->available_seats }}</td>
        <td>{{ $bus->bus_type }}</td>
        <td>{{ $bus->schedule_date }}</td>
        <td>{{ $bus->delay_minutes > 0 ? $bus->delay_minutes.' min' : '–' }}</td>
        <td>
          <a href="{{ route('admin.buses.edit', $bus->id) }}" class="btn btn-sm btn-warning">Edit</a>
        </td>
        <td>
          <form method="POST" action="{{ route('admin.buses.destroy', $bus->id) }}" onsubmit="return confirm('Delete this schedule?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() { $('#bus_table').DataTable(); });
</script>
@endpush
