@extends('layout.index')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Input Laundry Masuk</h6>
        </div>
        <div class="card-body">
            @php
                if(session('success')){
                    echo '<div class="alert alert-success">'.session('success').'</div>';
                }elseif(session('error')){
                    echo '<div class="alert alert-error">'.session('error').'</div>';
                }
            @endphp
            <form action="{{ route('laundry.post')}}" method="post">
            @csrf
            @method('post')
                <div class="form-group row">
                    <div class="col">
                        <label for="counter_id">Nama Counter</label>
                        <select class="form-control" name="counter_id" id="counter_id" required>
                            <option value="">-- Pilih Counter --</option>
                            @foreach ($counters as $counter)
                                <option value="{{ $counter->id}}">{{ $counter->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="no_invoice">No. Invoice</label>
                        <input type="text" class="form-control" name="no_invoice" id="no_invoice" maxlength="9" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="tanggal_input">Tanggal Input</label>
                        <input type="date" class="form-control" name="tanggal_input" id="tanggal_input" value="{{ date('Y-m-d', strtotime(now()))}}" required>
                    </div>
                    <div class="col">
                        <label for="jumlah_item">Jumlah Item</label>
                        <input type="number" class="form-control" name="jumlah_item" id="jumlah_item">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="total">Total Rp</label>
                        <input type="number" class="form-control" name="total" id="total">
                    </div>
                    <div class="col">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
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