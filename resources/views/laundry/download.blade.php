@extends('layout.index')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Laundry</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if ($tipe == 'spotting')
                <table class="table table-sm table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Counter</th>
                            <th>No. Invoice</th>
                            <th>Keterangan</th>
                            <th>Alasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laundries as $key => $laundry)
                            <tr>
                                <td>{{ $laundry->counter->nama}}</td>
                                <td>{{ $laundry->no_invoice}}</td>
                                <td>{{ $laundry->keterangan}}</td>
                                <td>{{ $laundry->catatan}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <table class="table table-sm table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Counter</th>
                            <th>No. Invoice</th>
                            <th>Item</th>
                            <th>Total Rp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $item = 0;
                            $total = 0;
                        @endphp
                        @foreach ($laundries as $key => $laundry)
                            <tr>
                                <td>{{ $laundry->counter->nama}}</td>
                                <td>{{ $laundry->no_invoice}}</td>
                                <td>{{ $laundry->jumlah_item}}</td>
                                <td>Rp. {{ number_format($laundry->total, 1)}}</td>
                                @php
                                    $item += $laundry->jumlah_item;
                                    $total += $laundry->total
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>{{ $item}} item</th>
                            <th>Rp. {{ number_format($total, 1)}}</th>
                        </tr>
                    </tfoot>
                </table>
                @endif
            </div>
            <a href="{{ route('laundry.index')}}" class="btn btn-secondary">Kembali</a>
            <button type="button" class="btn btn-success" id="download">Download</button>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var table;
        $(document).ready(function(){
            table = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    customize: function (doc) {
                        doc.content[1].table.widths = 
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.styles.tableBodyEven.alignment = 'center';
                        doc.styles.tableBodyOdd.alignment = 'center'; 
                    },
                    footer: true,
                    text: 'Cetak',
                    download: 'open'
                }],
                // "lengthChange": false,
                "searching": false,
                "paging": false,
                "info": false,
                "scrollCollapse": true
            });

            table.buttons('.buttons-pdf').nodes().addClass('d-none');

            $('#download').click(function(){
                table.button('.buttons-pdf').trigger();
            })
        })
    </script>
@endsection