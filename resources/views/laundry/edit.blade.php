@extends('layout.index')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Laundry Masuk</h6>
        </div>
        <div class="card-body">
            @php
                if(session('success')){
                    echo '<div class="alert alert-success">'.session('success').'</div>';
                }elseif(session('error')){
                    echo '<div class="alert alert-danger">'.session('error').'</div>';
                }
            @endphp
            @error('no_invoice')
                <div class="alert alert-danger">{{ $message}}</div>
            @enderror
            <form action="{{ route('laundry.update', $laundry->id)}}" method="post">
            @csrf
            @method('post')
                <div class="form-group row">
                    <div class="col">
                        <label for="counter_id">Nama Counter</label>
                        <select class="form-control" name="counter_id" id="counter_id" required>
                            <option></option>
                            @foreach ($counters as $counter)
                                <option value="{{ $counter->id}}" @if ($counter->id == $laundry->counter_id) selected @endif>{{ $counter->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="no_invoice">No. Invoice</label>
                        <input type="text" class="form-control" name="no_invoice" id="no_invoice" maxlength="9" value="{{ $laundry->no_invoice}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="tanggal_input">Tanggal Input</label>
                        <input type="date" class="form-control" name="tanggal_input" id="tanggal_input" value="{{ $laundry->tanggal_input}}" required>
                    </div>
                    <div class="col">
                        <label for="jumlah_item">Jumlah Item</label>
                        <input type="number" class="form-control" name="jumlah_item" id="jumlah_item" value="{{ $laundry->jumlah_item}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="total">Total Rp</label>
                        <input type="number" class="form-control" name="total" id="total" value="{{ $laundry->total}}" required>
                    </div>
                    <div class="col">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control">{{ $laundry->keterangan}}</textarea>
                    </div>
                </div>
                @if (auth()->user()->readonly == 'Tidak')
                <button class="btn btn-primary" type="submit">Submit</button>
                @endif
                <a href="{{ route('laundry.index')}}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#counter_id').select2({
                placeholder: 'Pilih Counter'
            })
        })

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>
@endsection