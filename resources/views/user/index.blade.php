@extends('layout.index')

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
                        <button type="button" class="btn btn-primary" onclick="tambah()">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        if(session('success')){
                            echo '<div class="alert alert-success">'.session('success').'</div>';
                        }elseif(session('error')){
                            echo '<div class="alert alert-error">'.session('error').'</div>';
                        }
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $key+1}}</td>
                                        <td>{{ $user->name}}</td>
                                        <td>{{ $user->username}}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" onclick="edit('{{ $user->id}}')"><i class="fa fa-pen"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="hapus('{{ $user->id}}')"><i class="fa fa-trash"></i></button>
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

    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="POST" id="userForm">
                @csrf
                @method('post')
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col">
                                <input type="text" class="form-control" name="name" id="name"
                                placeholder="Name" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="username" id="username"
                                placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <p>Hak Akses</p>
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" name="menu[]" id="daftar_laundry" value="daftar_laundry">
                                    <label class="custom-control-label" for="daftar_laundry">Daftar Laundry</label>
                                </div>
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" name="menu[]" id="input_masuk" value="input_masuk">
                                    <label class="custom-control-label" for="input_masuk">Input Masuk</label>
                                </div>
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" name="menu[]" id="input_pending" value="input_pending">
                                    <label class="custom-control-label" for="input_pending">Input Sisa</label>
                                </div>
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" name="menu[]" id="input_keluar" value="input_keluar">
                                    <label class="custom-control-label" for="input_keluar">Input Keluar</label>
                                </div>
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" name="menu[]" id="daftar_user" value="daftar_user">
                                    <label class="custom-control-label" for="daftar_user">Daftar User</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="readonly">Readonly</label>
                                <select name="readonly" id="readonly" class="form-control">
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <input type="password" class="form-control" name="password" id="password"
                                placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
                <form action="" method="POST" id="userDelete">
                @csrf
                @method('delete')
                    <div class="modal-body">
                        <h5 class="text-center">
                            APAKAH ANDA YAKIN ?
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function tambah(){
            $('#userForm')[0].reset();
            $('#userForm').show();
            $('#userDelete').hide();
            $('#userForm').attr('action', "{{ route('user.post')}}");
            $('#userLabel').html('Tambah User');
            $('#password').attr('placeholder', 'Password');
            $('#password').attr('required', true);
            $('#userModal').modal('show');
        }

        function edit(id){
            $('#daftar_laundry').attr('checked', false);
            $('#input_masuk').attr('checked', false);
            $('#input_keluar').attr('checked', false);
            $('#daftar_user').attr('checked', false);

            var edit = "{{ route('user.edit', ":id")}}";
            var upda = "{{ route('user.update', ":id")}}";
            edit = edit.replace(":id", id);
            upda = upda.replace(":id", id);
            $.ajax({
                url: edit,
                method: 'GET',
                success: function(data){
                    var count = data['access'].length;
                    let i = 0;
                    for(i; i < count; i++){
                        if(data['access'][i]['hak_akses'] == 'daftar_laundry'){
                            $('#daftar_laundry').attr('checked', true);
                        }else if(data['access'][i]['hak_akses'] == 'input_masuk'){
                            $('#input_masuk').attr('checked', true);
                        }else if(data['access'][i]['hak_akses'] == 'input_keluar'){
                            $('#input_keluar').attr('checked', true);
                        }else if(data['access'][i]['hak_akses'] == 'daftar_user'){
                            $('#daftar_user').attr('checked', true);
                        }else if(data['access'][i]['hak_akses'] == 'input_pending'){
                            $('#input_pending').attr('checked', true);
                        }
                    }
                    $('#userForm').show();
                    $('#userDelete').hide();
                    $('#userForm').attr('action', upda);
                    $('#userLabel').html('Update User');
                    $('#password').attr('placeholder', 'Kosongkan jika tidak ingin merubah password');
                    $('#password').attr('required', false);
                    $('#name').val(data['name']);
                    $('#username').val(data['username']);
                    $('#readonly').val(data['readonly']).change();
                    $('#userModal').modal('show');
                }
            })
        }

        function hapus(id){
            var hapus = "{{ route('user.delete', ":id")}}";
            hapus = hapus.replace(":id", id);
            $('#userForm').hide();
            $('#userDelete').show();
            $('#userDelete').attr('action', hapus);
            $('#userLabel').html('Hapus User');
            $('#userModal').modal('show');
        }
    </script>
@endsection