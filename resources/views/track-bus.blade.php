@extends('layouts.app')

@section('title', 'Track Bus – BusGoes')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
  #mapContainer { height: 420px; width: 100%; border-radius:8px; border:2px solid #4e046c; }
  #statusBadge { font-size:13px; font-weight:700; padding:6px 14px; border-radius:20px; }
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
        <p>Track your bus in real-time on the map below.</p>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div><br><br>

<div class="container">
  <div class="row mb-4">
    <div class="col-12">
      <div class="rounded shadow p-4" style="background-color:#eeeeee;">
        <h1 class="sub_heading mb-2">{{ $busSchedule->route_from }} &rarr; {{ $busSchedule->route_to }}</h1>
        <p class="mb-1">Schedule ID: <b>{{ $busSchedule->schedule_id }}</b> &nbsp;|&nbsp; Date: <b>{{ $busSchedule->schedule_date }}</b> &nbsp;|&nbsp; Departure: <b>{{ $busSchedule->departure_time }}</b></p>
        @if($busSchedule->delay_minutes > 0)
          <p class="mb-1 text-danger"><strong>Delayed by {{ $busSchedule->delay_minutes }} minutes</strong></p>
        @endif
        <span id="statusBadge" style="background-color:#82ca9c;">
          Waiting for GPS signal…
        </span>
        <span id="lastUpdated" class="ms-3 text-muted" style="font-size:12px;"></span>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div id="mapContainer"></div>
      <p class="text-muted mt-2" style="font-size:12px;">Map updates every 10 seconds. Bus position is shown as a marker.</p>
    </div>
  </div>

  <div class="mt-4">
    <a href="{{ route('home') }}" class="a_link">&#8592; Back to Search</a>
  </div>
</div>

<div class="clearfix"></div><br><br>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  const scheduleId = {{ $busSchedule->id }};
  const apiUrl = `/api/gps/${scheduleId}`;

  // Default center: Sri Lanka
  const defaultCenter = [7.8731, 80.7718];
  const map = L.map('mapContainer').setView(defaultCenter, 8);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  let marker = null;

  function updateMap() {
    fetch(apiUrl)
      .then(r => r.json())
      .then(data => {
        if (!data.available) {
          document.getElementById('statusBadge').textContent = 'GPS signal not yet available';
          document.getElementById('statusBadge').style.backgroundColor = '#f5c481';
          return;
        }
        const lat = parseFloat(data.latitude);
        const lng = parseFloat(data.longitude);
        const latlng = [lat, lng];

        if (!marker) {
          marker = L.marker(latlng)
            .addTo(map)
            .bindPopup('{{ $busSchedule->route_from }} → {{ $busSchedule->route_to }}<br>{{ $busSchedule->schedule_id }}')
            .openPopup();
        } else {
          marker.setLatLng(latlng);
        }
        map.setView(latlng, 13);
        document.getElementById('statusBadge').textContent = 'Live – Bus Located';
        document.getElementById('statusBadge').style.backgroundColor = '#82ca9c';
        document.getElementById('lastUpdated').textContent = 'Updated ' + data.updated_at;
      })
      .catch(() => {});
  }

  updateMap();
  setInterval(updateMap, 10000);
</script>
@endpush
