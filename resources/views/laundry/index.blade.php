@extends('layout.index')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Laundry</h6>
                <div>
                    @if (auth()->user()->readonly == 'Tidak')
                        <a href="{{ route('counter.create')}}" class="btn btn-primary">Tambah</a>                    
                    @endif
                    <button type="button" class="btn btn-success" onclick="laporan()">Laporan</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Counter</th>
                            <th>No. Invoice</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Selesai</th>
                            <th>Total Rp</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laundries as $key => $laundry)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{ $laundry->counter->nama}}</td>
                                <td>{{ $laundry->no_invoice}}</td>
                                <td>{{ $laundry->tanggal_input}}</td>
                                <td>{{ $laundry->jumlah_item}}</td>
                                <td>{{ $laundry->jumlah_item_selesai}}</td>
                                <td>Rp. {{ number_format($laundry->total, 1)}}</td>
                                <td>
                                    @if ($laundry->status == 'N')
                                        <span class="text-danger">Belum Selesai</span>
                                    @elseif ($laundry->status == 'W')
                                        <span class="text-primary">Sebagian</span>
                                    @elseif ($laundry->status == 'Y')
                                        <span class="text-success">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="userLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLabel">Laporan Laundry</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('laundry.laporan')}}" method="POST">
            @csrf
            @method('post')
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col">
                            <label for="dari">Dari</label>
                            <input type="date" name="dari" id="dari" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="sampai">Sampai</label>
                            <input type="date" name="sampai" id="sampai" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="tipe">Tipe Laporan</label>
                            <select name="tipe" id="tipe" class="form-control" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="masuk">Detail laundry masuk</option>
                                <option value="proses">Detail laundry proses</option>
                                <option value="keluar">Detail laundry keluar</option>
                                <option value="spotting">Detail penggunaan kartu spotting</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#table').DataTable();
        })

        function laporan(){
            $('#laporanModal').modal('show');
        }
    </script>
@endsection