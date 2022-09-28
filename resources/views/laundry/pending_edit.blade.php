@extends('layout.index')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Laundry Pending</h6>
        </div>
        <div class="card-body">
            @php
                if(session('success')){
                    echo '<div class="alert alert-success">'.session('success').'</div>';
                }elseif(session('error')){
                    echo '<div class="alert alert-error">'.session('error').'</div>';
                }
            @endphp
        </div>
        <div class="card-body">
            <form action="{{ route('laundry.pending.post', $laundry->id)}}" method="post" id="form">
            @csrf
            @method('post')
                <div class="form-group row">
                    <div class="col">
                        <label for="nama_counter">Nama Counter</label>
                        <input type="text" class="form-control" name="nama_counter" id="nama_counter" value="{{ $laundry->counter->nama}}" readonly>
                    </div>
                    <div class="col">
                        <label for="no_invoice">No. Invoice</label>
                        <input type="text" class="form-control" name="no_invoice" id="no_invoice" value="{{ $laundry->no_invoice}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="tanggal_input">Tanggal Input</label>
                        <input type="date" class="form-control" name="tanggal_input" id="tanggal_input" value="{{ $laundry->tanggal_input}}" readonly>
                    </div>
                    <div class="col">
                        <label for="jumlah_item">Jumlah Item</label>
                        <input type="number" class="form-control" name="jumlah_item" id="jumlah_item" value="{{ $laundry->jumlah_item}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="jumlah_item_selesai">Jumlah Item Selesai</label>
                        <input type="number" class="form-control" name="jumlah_item_selesai" id="jumlah_item_selesai" value="{{ $laundry->jumlah_item_selesai}}" readonly>
                    </div>
                    <div class="col">
                        <label for="jumlah_item_pending">Jumlah Item Sisa</label>
                        <input type="number" class="form-control" name="jumlah_item_pending" id="jumlah_item_pending" value="{{ $laundry->jumlah_item_pending}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="tanggal_input_pending">Tanggal Input Pending</label>
                        <input type="date" name="tanggal_input_pending" id="tanggal_input_pending" class="form-control" value="{{ $laundry->tanggal_input_pending}}" required>
                    </div>
                    <div class="col">
                        <label for="total">Total Rp</label>
                        <input type="number" class="form-control" name="total" id="total" value="{{ $laundry->total}}" readonly>
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