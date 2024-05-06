@extends('base')

@section('title', 'Payment Methods')

@section('header_title', 'Payment Methods')

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
          <form method="POST" action="{{ route('admin.pams.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="form-group">
                <label for="user">Pilih User Terdata</label>
                <select class="form-control" name="user_id" id="">
                  @foreach ($users as $user)
                  <option value="">Pilih User</option>
                  <option value="{{$user->id}}">{{$user->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="Atas Nama">Atas Nama </label>
                <input type="text" class="form-control" name="atas_nama" id="atas_nama" value="{{ old('atas_nama') }}"
                  placeholder="Atas Nama">
              </div>
              <div class="form-group">
                <label for="nomorpam">Nomor Pam </label>
                <input type="text" class="form-control" name="no_pam" id="no_pam" value="{{ old('no_pam') }}"
                  placeholder="nomorpam">
              </div>
              <div class="form-group">
                <label for="Tanggal Pemasanagan">Tanggal Pemasangan </label>
                <input type="date" class="form-control" name="tgl_pemasangan" id="tgl_pemasangan"
                  value="{{ old('tgl_pemasangan') }}" placeholder="Tanggal Pemasanagan">
              </div>
              <div class="form-group">
                <label for="alamat">Alamat lengkap Pemasangan </label>
                <textarea class="form-control" name="alamat" id="" cols="30" rows="10"></textarea>
              </div>
              <div class="form-group">
                <label for="tipe">Tanggal Pemasangan </label>
                <select name="tipe" id="" class="form-control">
                  <option value="M1">M1</option>
                  <option value="M2">M2</option>
                  <option value="M3">M3</option>

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