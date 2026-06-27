@extends('layouts.admin')

@section('title', 'Update GPS – Admin BusGoes')

@section('admin-content')
<h1 class="sub_heading">Update Bus GPS Location</h1>
<p>Manually enter GPS coordinates for a bus schedule. This simulates a real-time GPS device update.</p>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="alert alert-danger">
    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
  </div>
@endif

<form method="POST" action="{{ route('admin.gps.submit') }}" class="mt-4">
  @csrf
  <div class="row">
    <div class="col-md-5 mb-3">
      <div class="form-floating">
        <select name="bus_schedule_id" class="form-select" required>
          <option value="">Select Bus Schedule</option>
          @foreach($buses as $bus)
            <option value="{{ $bus->id }}" {{ old('bus_schedule_id')==$bus->id?'selected':'' }}>
              {{ $bus->schedule_id }} – {{ $bus->route_from }} to {{ $bus->route_to }} ({{ $bus->schedule_date }})
            </option>
          @endforeach
        </select>
        <label>Bus Schedule</label>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="form-floating">
        <input type="number" name="latitude" class="form-control" placeholder="Latitude" step="0.00000001" min="-90" max="90" value="{{ old('latitude', '6.9271') }}" required>
        <label>Latitude</label>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="form-floating">
        <input type="number" name="longitude" class="form-control" placeholder="Longitude" step="0.00000001" min="-180" max="180" value="{{ old('longitude', '79.8612') }}" required>
        <label>Longitude</label>
      </div>
    </div>
    <div class="col-md-1 mb-3 d-flex align-items-center">
      <button type="submit" class="btn btn-primary green_btn" style="height:55px;width:100%;">SET</button>
    </div>
  </div>
</form>

<div class="mt-4 p-3 rounded" style="background-color:#eee;">
  <h2 class="sub_heading">Sri Lanka City Coordinates (Reference)</h2>
  <table class="table table-sm mt-2">
    <thead><tr><th>City</th><th>Latitude</th><th>Longitude</th></tr></thead>
    <tbody>
      <tr><td>Colombo</td><td>6.9271</td><td>79.8612</td></tr>
      <tr><td>Kandy</td><td>7.2906</td><td>80.6337</td></tr>
      <tr><td>Galle</td><td>6.0535</td><td>80.2210</td></tr>
      <tr><td>Jaffna</td><td>9.6615</td><td>80.0255</td></tr>
      <tr><td>Matara</td><td>5.9485</td><td>80.5353</td></tr>
      <tr><td>Anuradhapura</td><td>8.3114</td><td>80.4037</td></tr>
      <tr><td>Badulla</td><td>6.9934</td><td>81.0550</td></tr>
    </tbody>
  </table>
</div>
@endsection
