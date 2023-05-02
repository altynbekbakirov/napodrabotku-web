@extends('admin.layouts.app')

@section('title', $title.' - ')

@section('content')

    @include('admin.partials.subheader')

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-body">
                    <!--begin::Search Form-->
                    <div class="mb-7">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    @if(request()->type == 'USER')
                                    <div class="col-md-2">
                                        <label for="region">Пол</label>
                                        {!! Form::select('gender', $genders, null, ['class' => 'selectpicker form-control', 'placeholder' => 'Любой', 'data-width' => '100%', 'data-size' => '6', 'id' => 'kt_datatable_search_gender']) !!}
                                    </div>
                                    @endif

                                    @if(request()->type != 'ADMIN')
                                    <div class="col-md-2">
                                        <label for="region">Регион</label>
                                        {!! Form::select('region', $regions, null, ['class' => 'selectpicker form-control', 'placeholder' => 'Любой', 'data-width' => '100%', 'data-size' => '6', 'id' => 'kt_datatable_search_region']) !!}
                                    </div>
                                    @endif

                                    @if(request()->type == 'USER')
                                    <div class="col-md-2">
                                        <label for="region">Возраст</label>
                                        {!! Form::select('age', $ages, null, ['class' => 'selectpicker form-control', 'placeholder' => 'Любой', 'data-width' => '100%', 'data-size' => '6', 'id' => 'kt_datatable_search_age']) !!}
                                    </div>
                                    @endif

                                    @if(request()->type == 'COMPANY')
                                    <div class="col-md-3">
                                        <label for="region">Сфера деятельности</label>
                                        {!! Form::select('job_type', $job_types, null, ['class' => 'selectpicker form-control', 'placeholder' => 'Любой', 'data-width' => '100%', 'data-size' => '6', 'id' => 'kt_datatable_search_job_type']) !!}
                                    </div>
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="{{route('users.create')}}" class="btn btn-primary font-weight-bold">
                                    <span class="svg-icon svg-icon-md">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                    Добавить
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end::Search Form-->
                    <!--begin: Datatable-->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th width="200px">ИМЯ, ФАМИЛИЯ</th>
                                <th>EMAIL</th>
                                <th>РЕГИОН</th>
                                <th>ДАТА РЕГИСТРАЦИИ</th>
                                <th>ДЕЙСТВИЯ</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

@endsection

@section('scripts')

    <script>
        let table = $('#dataTable').DataTable({
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },
            ],
            dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('users.index') }}',
                data: function(d) {
                    d.type = "{{request()->type}}";
                    d.region = $('select[name=region]').val();
                    d.gender = $('select[name=gender]').val();
                    d.age = $('select[name=age]').val();
                    d.job_type = $('select[name=job_type]').val();
                }
            },
            columns: [
                { data: 'id'},
                { data: 'name'},
                { data: 'email'},
                { data: 'region'},
                { data: 'created_at'},
                { data: 'acts'},
            ],
            order: [[ 0, "asc" ]],
            pageLength: 10,
            language: {
                "url": "{{asset('js/russian.json')}}"
            },
        });

        $("select[name=region]").on("change", function() {
            table.draw();
        });

        $("select[name=gender]").on("change", function() {
            table.draw();
        });

        $("select[name=age]").on("change", function() {
            table.draw();
        });

        $("select[name=job_type]").on("change", function() {
            table.draw();
        });
    </script>

@endsection

