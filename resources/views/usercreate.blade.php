@extends('base')

@section('title', 'Pelanggan Methods')

@section('header_title', 'Pelanggan Methods')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-body table-responsive p-0">
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="form-group">
                <label for="name">Nama Pelanggan</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
                  placeholder="Enter name">
              </div>
              <div class="form-group">
                <label for="name">Email Pelanggan</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}"
                  placeholder="Enter Email">
              </div>
              <div class="form-group">
                <label for="password">Password Pelanggan</label>
                <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}"
                  placeholder="Enter name">
              </div>
              <div class="form-group">
                <label for="username">Username Pelanggan</label>
                <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}"
                  placeholder="Enter name">
              </div>
              <div class="form-group">
                <label for="name">Foto Profile</label>
                <input type="file" class="form-control" name="profile_picture" id="profile_picture"
                  value="{{ old('profile_picture') }}" placeholder="Enter name">
              </div>
              <div class="form-group">
                <label for="name">Foto KTPs</label>
                <input type="file" class="form-control" name="ktp" id="ktp" value="{{ old('ktp') }}"
                  placeholder="Enter name">
              </div>


              <div class="form-group">
                <label for="status">Verified</label>
                <select name="verified" class="custom-select" id="action">
                  <option value="">- No Action -</option>
                  <option value="1" {{ (old('action') === '1') ? "selected" : "" }}>Verified</option>
                  <option value="0" {{ (old('action') === '0') ? "selected" : "" }}>Tidak - Verified</option>
                </select>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection