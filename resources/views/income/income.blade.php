@extends('layouts.admin')
@section('title')
    Incomes
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="card-title">For other months, search in the form below.</a></h1>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="row" method="POST" id="search-form">
                @csrf
                <div class="col-md-2">
                    <label for="date_start" class="form-label">Date Start</label>
                    <input type="date" class="form-control" id="date_start" name="date_start">
                    @error('date_start')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
                <div class="col-md-2">
                    <label for="date_finish" class="form-label">Date Finish</label>
                    <input type="date" class="form-control" id="date_finish" name="date_finish">
                    @error('date_finish')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-1">
                    <button type="button" class="btn btn-lg btn-info mt-4" id="search">Search</button>
                </div>

            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="card-title">Incomes - This page shows only current month's incomes. For other months,
                        search in the form above.</a></h1>
                    <div class="card-tools float-right">
                        <a href="{{ route('income.add') }}" class="btn bg-success btn-sm">Add New</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>description</th>
                        <th>category</th>
                        <th>price</th>
                        <th>invoice</th>
                        <th>invoice date</th>
                        <th>edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incomes as $income)
                        <tr>
                            <td>{{ $income->id }}</td>
                            <td width="55%">{{ $income->description }}</td>
                            <td>{{ $income->category->name }}</td>
                            <td>{{ $income->price }}</td>
                            <td>
                                @if ($income->invoice)
                                    <a href="{{ asset('storage/' . $income->invoice) }}" class="btn btn-success"
                                        target="_blank">Invoice</a>
                                @else
                                    No Invoice
                                @endif
                            </td>

                            <td>{{ $income->invoice_date }}</td>

                            <td>
                                <a href="{{ route('income.updateShow', $income->id) }}" class="btn btn-secondary update"
                                    data-id="{{ $income->id }}"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-danger delete" data-id="{{ $income->id }}"><i
                                        class="far fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <figure class="highcharts-figure">
                <div class="row">
                <div id="container1" class="col-md-6"></div>
                <div id="container2" class="col-md-6"></div>
            </div>              
            </figure>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
  
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script>
        $(document).ready(function() {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
            var table = $('#example').DataTable({
                "responsive": true,
                "autoWidth": false,
                stateSave: true,
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-files-o"></i> Copy',
                        titleAttr: 'Copy'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-csv"></i> Csv',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i> Pdf',
                        titleAttr: 'Pdf',
                        download: 'open',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        titleAttr: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="fa fa-code"></i> JSON',
                        titleAttr: 'JSON',
                        exportOptions: {
                            columns: ':visible'
                        },
                        action: function(e, dt, button, config) {
                            var data = dt.buttons.exportData();

                            $.fn.dataTable.fileSave(
                                new Blob([JSON.stringify(data)]),
                                'data.json'
                            );
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-eye-slash"></i> Change Visibilty',
                        titleAttr: 'Change Visibilty',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                ],
            });
            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
            

          
            Highcharts.chart('container1', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Total prices with categories'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.2f}$</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y:.2f}$'
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Total Price',
                    colorByPoint: true,
                    data: [


                        @foreach ($data as $key => $value)
                            {
                            name: '{{ $key }}',
                            y: {{ $value }}
                            },
                        @endforeach


                    ]
                }]
            });
           
Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Total prices with categories'
    },
   
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total prices'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.2f}$'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}$</b><br/>'
    },

    series: [
        {
            name: "Category",
            colorByPoint: true,
            data: [              
                @foreach ($data as $key => $value)
                            {
                            name: '{{ $key }}',
                            y: {{ $value }}
                            },
                        @endforeach
            ]
        }
    ],
   
});

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* Delete with ajax */
            $('#example').on('click', '.delete', function() {
                let self = $(this);
                let dataID = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('income.delete') }}',
                            method: 'POST',
                            data: {
                                id: dataID
                            },
                            async: false,
                            success: function() {
                                self[0].closest('tr').remove();
                                Swal.fire(
                                    'Deleted!',
                                    'Income has been deleted.',
                                    'success'
                                )
                            }
                        });
                    }
                })
            });
            /* Delete with ajax */

            $('#search').click(function() {
                if ($('#date_start').val().trim() == "") {
                    $('#date_start').focus();
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Date start can not be empty!',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    })

                } else if ($('#date_finish').val().trim() == "") {
                    $('#date_finish').focus();
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Date finish can not be empty!',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    })
                } else {
                    $('#search-form').submit();
                    $('#search').prop('disabled', true);
                }
            });
        });
    </script>
@endsection
