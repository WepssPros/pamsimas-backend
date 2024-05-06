@extends('base')

@section('title', 'Informasi Tagihan')

@section('header_title', 'Informasi Tagihan')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('admin.tagihan.create') }} " class="btn btn-primary">
          <i class="far fa-plus-square"></i>
        </a>
        <div class="card-body table-responsive p-0">
          <table id="transactions" class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>NO</th>
                <th>Pelanggan</th>
                <th>Nomor Pam</th>
                <th>Tanggal Tagihan </th>
                <th>Biaya Tagihan</th>
                <th>Pemakain Awal</th>
                <th>Pemakaian Akhir</th>
                <th>Pemakaian</th>
                <th>Jatuh Tempo</th>
                <th>Status Tagihan</th>
                <th>Tenggang Bulan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tagihanpams as $index=>$tagihan)
              <tr>
                <td>{{$index+1}}</td>
                <td>{{$tagihan->user->name}}</td>
                <td>{{$tagihan->noPam->no_pam}}</td>
                <td>{{$tagihan->tanggal_tagihan}}</td>
                <td>
                  @if($tagihan->jarak_bulan == "0")

                  Rp.{{number_format($tagihan->harga )}}
                  @elseif($tagihan->jarak_bulan == "1")
                  Rp.{{number_format($tagihan->harga * 2 )}}
                  @else
                  Rp.{{number_format($tagihan->harga * $tagihan->jarak_bulan)}}
                  @endif
                </td>
                <td>{{$tagihan->meter_awal}}</td>
                <td>{{$tagihan->meter_akhir}}</td>
                <td>{{$tagihan->pemakaian}}</td>
                <td>{{$tagihan->due_date}}</td>
                <td>
                  <span class="rounded px-2 py-1"
                    style="background-color: {{ $tagihan->status_pembayaran === 'belum dibayar' ? 'red' : 'green' }}; color: white;">
                    {{ $tagihan->status_pembayaran }}
                  </span>
                </td>
                <td>
                  @if($tagihan->status_pembayaran == "belum dibayar")
                  <span class="rounded px-2 py-1"
                    style="background-color: {{ $tagihan->jarak_bulan === '0' ? 'green' : 'red' }}; color: white;">
                    {{ $tagihan->jarak_bulan }} Bulan
                  </span>
                  @else
                  <span class="rounded px-2 py-1" style="background-color: green; color: white;">
                    {{$tagihan->status_pembayaran}}
                  </span>
                  @endif
                </td>
                <td>
                  <form action="{{route('admin.tagihan.destroy' ,$tagihan->id)}}" method="post">
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