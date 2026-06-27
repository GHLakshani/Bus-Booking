@extends('layouts.admin')

@section('title', 'Add Bus – Admin BusGoes')

@section('admin-content')
<h1 class="sub_heading">Add Bus Schedule</h1>

@if($errors->any())
  <div class="alert alert-danger">
    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
  </div>
@endif

<form method="POST" action="{{ route('admin.buses.store') }}" enctype="multipart/form-data" class="mt-3">
  @csrf
  <div class="row">
    <div class="col-md-6 mb-3">
      <div class="form-floating">
        <input type="text" name="schedule_id" class="form-control" placeholder="Schedule ID" value="{{ old('schedule_id') }}" required>
        <label>Schedule ID</label>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="form-floating">
        <select name="route_from" class="form-select" required>
          <option value="">Select Origin</option>
          @foreach(['Colombo','Kandy','Galle','Matale','Jaffna','Kurunegala','Anuradhapura','Badulla','Ratnapura','Matara'] as $r)
            <option value="{{ $r }}" {{ old('route_from')==$r?'selected':'' }}>{{ $r }}</option>
          @endforeach
        </select>
        <label>Route From</label>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="form-floating">
        <select name="route_to" class="form-select" required>
          <option value="">Select Destination</option>
          @foreach(['Colombo','Kandy','Galle','Matale','Jaffna','Kurunegala','Anuradhapura','Badulla','Ratnapura','Matara'] as $r)
            <option value="{{ $r }}" {{ old('route_to')==$r?'selected':'' }}>{{ $r }}</option>
          @endforeach
        </select>
        <label>Route To</label>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="form-floating">
        <input type="time" name="departure_time" class="form-control" value="{{ old('departure_time') }}" required>
        <label>Departure Time</label>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="form-floating">
        <input type="text" name="bus_model" class="form-control" placeholder="Bus Model" value="{{ old('bus_model') }}" required>
        <label>Bus Model</label>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="form-floating">
        <input type="text" name="depot_name" class="form-control" placeholder="Depot Name" value="{{ old('depot_name') }}" required>
        <label>Depot Name</label>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="form-floating">
        <input type="number" name="fare" class="form-control" placeholder="Fare" value="{{ old('fare') }}" step="0.01" min="0" required>
        <label>Fare (Rs.)</label>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="form-floating">
        <input type="number" name="available_seats" class="form-control" placeholder="Seats" value="{{ old('available_seats', 51) }}" min="1" max="100" required>
        <label>Available Seats</label>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="form-floating">
        <input type="text" name="duration" class="form-control" placeholder="Duration" value="{{ old('duration') }}" required>
        <label>Duration (hours)</label>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="form-floating">
        <select name="bus_type" class="form-select" required>
          <option value="">Select Type</option>
          @foreach(['Normal Bus','AC Bus','Semi','Highway'] as $t)
            <option value="{{ $t }}" {{ old('bus_type')==$t?'selected':'' }}>{{ $t }}</option>
          @endforeach
        </select>
        <label>Bus Type</label>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="form-floating">
        <input type="date" name="schedule_date" class="form-control" value="{{ old('schedule_date') }}" required>
        <label>Schedule Date</label>
      </div>
    </div>
    <div class="col-md-12 mb-3">
      <label class="form-label" style="font-weight:600;">Bus Image (optional)</label>
      <input type="file" name="bus_image" class="form-control" accept="image/*">
    </div>
    <div class="col-12 mt-2">
      <button type="submit" class="btn btn-primary green_btn" style="height:50px;width:200px;font-weight:900;">ADD SCHEDULE</button>
      <a href="{{ route('admin.buses') }}" class="btn btn-secondary ms-2">Cancel</a>
    </div>
  </div>
</form>
@endsection
