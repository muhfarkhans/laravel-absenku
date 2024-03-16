@extends('admin.layout')

@section('css')
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.2/b-3.0.1/b-html5-3.0.1/b-print-3.0.1/r-3.0.0/datatables.min.css"
        rel="stylesheet">
@endsection

@section('content-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Absensi</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Absensi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="btn-group d-flex justify-content-between">
                    <div class="d-flex justify-content-start mt-2">
                        <h5 class="card-title">
                            Tabel
                        </h5>
                    </div>

                    {{-- <div class="d-flex justify-content-end mb-3">
                        <div class="mb-n3">
                            <a href="{{ route('admin.user.create') }}">
                                <button class="btn btn-primary">
                                    Tambah data
                                </button>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped datatables" id="table1">
                        <thead>
                            <tr>
                                <th>No. </th>
                                <th>Tanggal</th>
                                <th>Karyawan</th>
                                <th>Masuk</th>
                                <th>Pulang</th>
                                <th>Durasi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.2/b-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js">
    </script>
    <script type="text/javascript">
        $(function() {
            const table = $('.datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.absence.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'day',
                        name: 'day'
                    },
                    {
                        data: 'employee.name',
                        name: 'employee.name'
                    },
                    {
                        data: 'check_in_time',
                        name: 'check_in_time'
                    },
                    {
                        data: 'check_out_time',
                        name: 'check_out_time'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                ],
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                }
            });
        });
    </script>
@endpush
