@extends('layout.index')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Counter</h6>
        </div>
        <div class="card-body">
            @php
                if(session('success')){
                    echo '<div class="alert alert-success">'.session('success').'</div>';
                }elseif(session('error')){
                    echo '<div class="alert alert-error">'.session('error').'</div>';
                }
            @endphp
            <form action="{{ route('counter.post')}}" method="post">
            @csrf
            @method('post')
                <div class="form-group row">
                    <div class="col">
                        <label for="nama">Nama Counter</label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                        @error('nama')
                            <span class="text-danger">{{ $message}}</span>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
                <a href="{{ route('laundry.index')}}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection