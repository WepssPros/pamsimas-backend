@extends('base')

@section('title', 'Tagihan Methods')

@section('header_title', 'Tagihan Methods')

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
          <form method="POST" action="{{ route('admin.tagihan.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="form-group">
                <label for="user">Pilih Nomor PAM Teraftar </label>
                <select class="form-control" name="pam_id" id="">
                  @foreach ($pams as $pam)
                  <option value="">Pilih Nomor Pam</option>
                  <option value="{{$pam->id}}">{{$pam->no_pam}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="Tanggal Tagihan">Pilih Tanggal Tagihan </label>
                <input type="date" class="form-control" name="tanggal_tagihan" id="tanggal_tagihan"
                  value="{{ old('tanggal_tagihan') }}" placeholder="Tanggal Tagihan">
              </div>
              <div class="form-group">
                <label for="Jatuh Tempo">Pilih Tanggal Jatuh Tempo * Per Tanggal 20 </label>
                <input type="date" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') }}"
                  placeholder="Tanggal Tagihan">
              </div>
              <div class="form-group">
                <label for="pemakaian">Buat Pemakaian Sesuai Data </label>
                <input type="number" class="form-control" name="pemakaian" id="pemakaian" value="{{ old('pemakaian') }}"
                  placeholder="pemakaian">
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