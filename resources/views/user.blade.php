@extends('base')

@section('title', 'Pelanggan Pamsimas')

@section('header_title', 'Pelanggan Pam')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('admin.users.create') }} " class="btn btn-primary">
          <i class="far fa-plus-square"></i>
        </a>
        <div class="card-body table-responsive p-0">
          <table id="transactions" class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>FOTO</th>
                <th>Nama Pelanggan</th>
                <th>Email Pelanggan</th>
                <th>User Name Pelanggan</th>
                <th>Verified</th>
                <th>ktp</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td>
                  <div class="image">
                    <img src="{{ asset($user->profile_picture) }}" class="img-circle elevation-2" alt="User Image"
                      style="width: 60px; height: 60px">
                  </div>
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->verified }}</td>
                <td>
                  <div class="image-rounded">
                    <img src="{{ asset($user->ktp) }}" class="img-fluid rounded" alt="User Image"
                      style="width: 100px; height: 100px">
                  </div>
                </td>
                <td>{{ $user->updated_at }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  $('#transactions').DataTable();
</script>
@endsection