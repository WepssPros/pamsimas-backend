@extends('base')

@section('title', 'Transaction')

@section('header_title', 'Transaction')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('admin.pams.create') }} " class="btn btn-primary">
          <i class="far fa-plus-square"></i>
        </a>
        <div class="card-body table-responsive p-0">
          <table id="transactions" class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>NO</th>
                <th>Nomor Pam</th>
                <th>Tipe</th>
                <th>Meter</th>
                <th>Nama Pemilik</th>
                <th>Tanggal Pemasangan</th>
                <th>Alamat Rumah</th>
                <th>Aksi</th>

              </tr>
            </thead>
            <tbody>
              @foreach ($pams as $index => $pam)
              <tr>
                <td>{{$index+1}}</td>
                <td>{{ $pam->no_pam}}</td>
                <td>{{$pam->tipe}}</td>
                <td>{{$pam->meter}}</td>
                <td>{{$pam->atas_nama}}</td>
                <td>{{ $pam->tgl_pemasangan }}</td>
                <td>{{ $pam->alamat }}</td>
                <td>
                  <form action="{{route('admin.pams.destroy' ,$pam->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger" type="submit">
                      <i class="fa fa-trash"></i>

                    </button>
                  </form>

                </td>
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