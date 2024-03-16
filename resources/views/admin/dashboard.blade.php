@extends('admin.layout')

@section('css')
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.2/b-3.0.1/b-html5-3.0.1/b-print-3.0.1/r-3.0.0/datatables.min.css"
        rel="stylesheet">
@endsection

@section('content-title')
    <h3>Dashboard</h3>
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Jumlah Karyawan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $employeeTotal }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Jumlah Karyawan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $employeeTotal }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Jumlah Karyawan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $employeeTotal }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Jumlah Karyawan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $employeeTotal }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik absensi hari ini <span class="text-success">{{ today() }}</span></h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-absence"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar karyawan absen hari ini <span class="text-success">{{ today() }}</span></h4>
                        </div>
                        <div class="card-body">
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
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/dashboard.js') }}"></script>
    <script>
        let optionsChartAbsence = {
            series: [{{ $absenceTotal }}, {{ $notAbsenceTotal }}],
            labels: ["Karyawan melakukan absen", "Karyawan tidak melakukan absen"],
            colors: ["#435ebe", "#D21F3C"],
            chart: {
                type: "donut",
                width: "100%",
                height: "400px",
            },
            legend: {
                position: "bottom",
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "40%",
                    },
                },
            },
        }

        var chartAbsence = new ApexCharts(
            document.getElementById("chart-absence"),
            optionsChartAbsence
        )

        chartAbsence.render()
    </script>

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
                ajax: "{{ route('admin.absence.datatables.today') }}",
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
