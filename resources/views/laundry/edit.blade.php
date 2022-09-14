@extends('layout.index')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Input Laundry Keluar</h6>
        </div>
        <div class="card-body">
            @php
                if(session('success')){
                    echo '<div class="alert alert-success">'.session('success').'</div>';
                }elseif(session('error')){
                    echo '<div class="alert alert-error">'.session('error').'</div>';
                }
            @endphp
            <div class="form-group">
                <label for="select_invoice">No. Invoice</label>
                <select name="select_invoice" id="select_invoice" class="form-control">
                    <option value="">-- Pilih Invoive --</option>
                    @foreach ($laundries as $laundry)
                        <option value="{{ $laundry->id}}">{{$laundry->no_invoice}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body" id="detail" style="display: none">
            <form action="" method="post" id="form">
            @csrf
            @method('post')
                <div class="form-group row">
                    <div class="col">
                        <label for="nama_counter">Nama Counter</label>
                        <input type="text" class="form-control" name="nama_counter" id="nama_counter" readonly>
                    </div>
                    <div class="col">
                        <label for="no_invoice">No. Invoice</label>
                        <input type="text" class="form-control" name="no_invoice" id="no_invoice" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="tanggal_input">Tanggal Input</label>
                        <input type="date" class="form-control" name="tanggal_input" id="tanggal_input" readonly>
                    </div>
                    <div class="col">
                        <label for="jumlah_item">Jumlah Item</label>
                        <input type="number" class="form-control" name="jumlah_item" id="jumlah_item" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="jumlah_item_selesai">Jumlah Item Selesai</label>
                        <input type="number" class="form-control" name="jumlah_item_selesai" id="jumlah_item_selesai" required>
                    </div>
                    <div class="col">
                        <label for="total">Total Rp</label>
                        <input type="number" class="form-control" name="total" id="total" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ date('Y-m-d', strtotime(now()))}}" required>
                    </div>
                    <div class="col">
                        <label for="menggunakan_kartu_spotting">Menggunakan Kartu Spotting</label>
                        <select name="menggunakan_kartu_spotting" id="menggunakan_kartu_spotting" class="form-control">
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="catatan">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control"></textarea>
                    </div>
                </div>
                @if (auth()->user()->readonly == 'Tidak')
                    <button class="btn btn-primary" type="submit">Update</button>
                @endif
                <a href="{{ route('laundry.index')}}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#select_invoice').change(function(){
            if($(this).val() == ''){
                $('#detail').hide();
            }else{
                var id = $(this).val();
                var url = "{{ route('laundry.select', ":id")}}";
                url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data){
                        var key = data['id'];
                        var upd = "{{ route('laundry.update', ":key")}}";
                        upd     = upd.replace(":key", key);
                        $('#nama_counter').val(data['counter']['nama']);
                        $('#no_invoice').val(data['no_invoice']);
                        $('#tanggal_input').val(data['tanggal_input']);
                        $('#jumlah_item').val(data['jumlah_item']);
                        $('#jumlah_item_selesai').val(data['jumlah_item_selesai']);
                        $('#total').val(data['total']);
                        // $('#tanggal_selesai').val(data['tanggal_selesai']);
                        $('#menggunakan_kartu_spotting').val(data['menggunakan_kartu_spotting']);
                        $('#catatan').val(data['catatan']);
                        $('#jumlah_item_selesai').attr('max', data['jumlah_item']);
                        $('#form').attr('action', upd);
                        $('#detail').show();
                    }
                })
            }
        });
    </script>
@endsection