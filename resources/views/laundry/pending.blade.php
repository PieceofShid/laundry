@extends('layout.index')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Input Laundry Sisa</h6>
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
                    <option></option>
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
                        <input type="number" class="form-control" name="jumlah_item_selesai" id="jumlah_item_selesai" readonly>
                    </div>
                    <div class="col">
                        <label for="jumlah_item_pending">Jumlah Item Sisa</label>
                        <input type="number" class="form-control" name="jumlah_item_pending" id="jumlah_item_pending" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="tanggal_input_pending">Tanggal Input Pending</label>
                        <input type="date" name="tanggal_input_pending" id="tanggal_input_pending" class="form-control" value="{{ date('Y-m-d', strtotime(now()))}}" required>
                    </div>
                    <div class="col">
                        <label for="total">Total Rp</label>
                        <input type="number" class="form-control" name="total" id="total" readonly>
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
        $(document).ready(function(){
            $('#select_invoice').select2({
                placeholder: 'Pilih Invoice'
            });
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

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
                        var upd = "{{ route('laundry.pending.post', ":key")}}";
                        upd     = upd.replace(":key", key);
                        $('#nama_counter').val(data['counter']['nama']);
                        $('#no_invoice').val(data['no_invoice']);
                        $('#tanggal_input').val(data['tanggal_input']);
                        $('#jumlah_item').val(data['jumlah_item']);
                        $('#jumlah_item_pending').val(data['jumlah_item_pending']);
                        $('#jumlah_item_selesai').val(data['jumlah_item_selesai']);
                        $('#total').val(data['total']);
                        $('#jumlah_item_pending').attr('max', data['jumlah_item_pending']);
                        $('#form').attr('action', upd);
                        $('#detail').show();
                        $('#jumlah_item_pending').focus();
                    }
                })
            }
        });
    </script>
@endsection