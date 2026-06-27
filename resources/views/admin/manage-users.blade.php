@extends('layouts.admin')

@section('title', 'Manage Users – Admin BusGoes')

@push('styles')
<style>#users_table { width:100% !important; }</style>
@endpush

@section('admin-content')
<h1 class="sub_heading">Manage Users</h1>

<div class="table-responsive mt-3 mb-4">
  <table id="users_table" class="display">
    <thead>
      <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Province</th>
        <th>District</th>
        <th>Role</th>
        <th>Joined</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $u)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $u->first_name }}</td>
        <td>{{ $u->last_name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->telephone }}</td>
        <td>{{ $u->province }}</td>
        <td>{{ $u->district }}</td>
        <td>
          @if($u->user_type==='admin')
            <span class="badge" style="background-color:#4e046c;color:#fff;">Admin</span>
          @else
            <span class="badge" style="background-color:#82ca9c;color:#000;">User</span>
          @endif
        </td>
        <td>{{ $u->created_at->format('Y-m-d') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() { $('#users_table').DataTable(); });
</script>
@endpush
