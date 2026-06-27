@extends('layouts.admin')

@section('title', 'GPS API Tokens – Admin BusGoes')

@section('admin-content')
<h1 class="sub_heading">GPS API Tokens</h1>
<p>Generate tokens for GPS devices or the driver mobile app to authenticate when pushing live location updates.</p>

@if(session('new_token'))
  <div class="alert alert-success">
    <strong>New token generated — copy it now, it will not be shown again:</strong><br>
    <code style="font-size:14px;word-break:break-all;">{{ session('new_token') }}</code>
  </div>
@endif

@if(session('success') && !session('new_token'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="rounded shadow p-4 mt-3 mb-4" style="background:#eee;">
  <h2 class="sub_heading mb-3">How GPS devices use this token</h2>
  <p class="mb-1">The GPS device (or driver app) must send a <b>POST</b> request to:</p>
  <code>POST {{ url('/api/gps/update') }}</code>
  <p class="mt-3 mb-1">With the header:</p>
  <code>X-GPS-Token: &lt;your-token&gt;</code>
  <p class="mt-3 mb-1">And JSON body:</p>
  <pre style="background:#fff;padding:10px;border-radius:4px;">{
  "bus_schedule_id": 1,
  "latitude": 6.9271,
  "longitude": 79.8612
}</pre>
  <p class="mt-2 mb-0 text-muted" style="font-size:13px;">The passenger tracking map polls <code>GET /api/gps/{id}</code> every 10 seconds — no token needed for reading.</p>
</div>

<form method="POST" action="{{ route('admin.api.tokens.generate') }}" class="mb-4">
  @csrf
  <div class="row align-items-end">
    <div class="col-md-6 mb-2">
      <div class="form-floating">
        <input type="text" name="label" class="form-control" placeholder="Label" required value="{{ old('label') }}">
        <label>Token Label (e.g. "Bus 101 GPS Device")</label>
      </div>
    </div>
    <div class="col-md-3 mb-2">
      <button type="submit" class="btn btn-primary green_btn" style="height:55px;width:100%;">GENERATE TOKEN</button>
    </div>
  </div>
</form>

<h2 class="sub_heading">Active Tokens</h2>
<div class="table-responsive mt-3">
  <table class="table table-bordered table-hover">
    <thead style="background-color:#4e046c;color:#fff;">
      <tr>
        <th>#</th>
        <th>Label</th>
        <th>Token (partial)</th>
        <th>Created</th>
        <th>Revoke</th>
      </tr>
    </thead>
    <tbody>
      @forelse($tokens as $t)
      <tr>
        <td>{{ $t->id }}</td>
        <td>{{ $t->label }}</td>
        <td><code>{{ substr($t->token, 0, 12) }}…</code></td>
        <td>{{ \Carbon\Carbon::parse($t->created_at)->format('Y-m-d H:i') }}</td>
        <td>
          <form method="POST" action="{{ route('admin.api.tokens.delete', $t->id) }}" onsubmit="return confirm('Revoke this token?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Revoke</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="text-center">No tokens yet. Generate one above.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
