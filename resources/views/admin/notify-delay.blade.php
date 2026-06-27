@extends('layouts.admin')

@section('title', 'Notify Delay – Admin BusGoes')

@section('admin-content')
<h1 class="sub_heading">Notify Bus Delay</h1>
<p>Select a bus schedule, set the delay in minutes, and all confirmed passengers will receive an email notification.</p>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('admin.notify.submit') }}" class="mt-4">
  @csrf
  <div class="row">
    <div class="col-md-6 mb-3">
      <div class="form-floating">
        <select name="bus_schedule_id" class="form-select" required>
          <option value="">Select Bus Schedule</option>
          @foreach($buses as $bus)
            <option value="{{ $bus->id }}">
              {{ $bus->schedule_id }} – {{ $bus->route_from }} to {{ $bus->route_to }} ({{ $bus->schedule_date }}, {{ $bus->departure_time }})
            </option>
          @endforeach
        </select>
        <label>Bus Schedule</label>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="form-floating">
        <input type="number" name="delay_minutes" class="form-control" placeholder="Delay (minutes)" min="1" value="{{ old('delay_minutes', 15) }}" required>
        <label>Delay (minutes)</label>
      </div>
    </div>
    <div class="col-md-2 mb-3 d-flex align-items-center">
      <button type="submit" class="btn btn-primary magenta_btn" style="height:55px;width:100%;">NOTIFY</button>
    </div>
  </div>
</form>
@endsection
