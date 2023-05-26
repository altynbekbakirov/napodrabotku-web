@extends('admin.layouts.app')

@section('title', $title . ' - ')

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
                                    <div class="col-md-2">
                                        <label for="district">Населенный пункт</label>
                                        {!! Form::select('district', $districts, null, [
                                            'class' => 'selectpicker form-control',
                                            'data-width' => '100%',
                                            'data-live-search' => 'true',
                                            'title' => 'Любой',
                                            'multiple' => 'multiple',
                                            'data-size' => '6',
                                            'id' => 'kt_datatable_search_district',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <label for="region">Регион</label>
                                        {!! Form::select('region', $regions, null, [
                                            'class' => 'selectpicker form-control',
                                            'data-width' => '100%',
                                            'data-live-search' => 'true',
                                            'title' => 'Любой',
                                            'multiple' => 'multiple',
                                            'data-size' => '6',
                                            'id' => 'kt_datatable_search_region',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <label for="busyness">Вид занятости</label>
                                        {!! Form::select('busyness', $busynesses, null, [
                                            'class' => 'selectpicker form-control',
                                            'data-live-search' => 'true',
                                            'title' => 'Любой',
                                            'multiple' => 'multiple',
                                            'data-width' => '100%',
                                            'data-size' => '6',
                                            'id' => 'kt_datatable_search_busyness',
                                        ]) !!}
                                    </div>

                                    <div class="col-md-2">
                                        <label for="region">Тип вакансии</label>
                                        {!! Form::select('vacancy_type', $vacancy_types, null, [
                                            'class' => 'selectpicker form-control',
                                            'data-live-search' => 'true',
                                            'title' => 'Любой',
                                            'multiple' => 'multiple',
                                            'data-width' => '100%',
                                            'data-size' => '6',
                                            'id' => 'kt_datatable_search_vacancy_type',
                                        ]) !!}
                                    </div>

                                    <div class="col-md-2">
                                        <label for="region">Сфера работы</label>
                                        {!! Form::select('job_type', $job_types, null, [
                                            'class' => 'selectpicker form-control',
                                            'data-live-search' => 'true',
                                            'title' => 'Любой',
                                            'multiple' => 'multiple',
                                            'data-width' => '100%',
                                            'data-size' => '6',
                                            'id' => 'kt_datatable_search_job_type',
                                        ]) !!}
                                    </div>

                                    <div class="col-md-2">
                                        <label for="region">График работы</label>
                                        {!! Form::select('schedule', $schedules, null, [
                                            'class' => 'selectpicker form-control',
                                            'data-live-search' => 'true',
                                            'title' => 'Любой',
                                            'multiple' => 'multiple',
                                            'data-width' => '100%',
                                            'data-size' => '6',
                                            'id' => 'kt_datatable_search_schedule',
                                        ]) !!}
                                    </div>
                                    @if (auth()->user()->type == 'ADMIN')
                                        <div class="col-md-2">
                                            <label for="region">Компании</label>
                                            {!! Form::select('company', $companies, null, [
                                                'class' => 'selectpicker form-control',
                                                'title' => 'Любой',
                                                'data-width' => '100%',
                                                'data-size' => '6',
                                                'id' => 'kt_datatable_search_company',
                                                'multiple' => 'multiple',
                                            ]) !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="{{ route('vacancies.create') }}" class="btn btn-primary font-weight-bold">
                                    <span class="svg-icon svg-icon-md">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                                <path
                                                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                    fill="#000000" opacity="0.3" />
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
                                    <th width="300px">НАЗВАНИЕ</th>
                                    <th>КОМПАНИЯ</th>
                                    <th>РЕГИОН</th>
                                    <th>СФЕРА ДЕЯТЕЛЬНОСТИ</th>
                                    <th>ДАТА ДОБАВЛЕНИЯ</th>
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
            buttons: [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
            ],
            dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('vacancies.index') }}',
                data: function(d) {
                    d.district_id = $('select[name=district]').val();
                    d.region_id = $('select[name=region]').val();
                    d.busyness_id = $('select[name=busyness]').val();
                    d.vacancy_type_id = $('select[name=vacancy_type]').val();
                    d.job_type_id = $('select[name=job_type]').val();
                    d.schedule_id = $('select[name=schedule]').val();
                    d.company_id = $('select[name=company]').val();
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'company_name'
                },
                {
                    data: 'region'
                },
                {
                    data: 'job_type'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'acts'
                },
            ],
            order: [
                [0, "asc"]
            ],
            pageLength: 10,
            language: {
                "url": "{{ asset('js/russian.json') }}"
            },
        });

        $("select[name=district]").on("change", function() {
            if ($(this).val() != '') {
                var value = $(this).val();
            } else {
                value = 0;
            }
            $.ajax({
                url: `/admin/vacancies/districs/${value}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                    var el = $('#kt_datatable_search_region');
                    el.empty();
                    // $.each(result, function(key, value) {
                    //     $el.append($("<option></option>")
                    //         .attr("value", value).text(key));
                    // });
                },
                error: function(xhr, status, error) {
                    console.log('Произошла ошибка при обновлении статуса: ' + error);
                }
            });
            console.log($(this).val());
            table.draw();
        });

        $("select[name=region]").on("change", function() {
            table.draw();
        });

        $("select[name=busyness]").on("change", function() {
            table.draw();
        });

        $("select[name=vacancy_type]").on("change", function() {
            table.draw();
        });

        $("select[name=job_type]").on("change", function() {
            table.draw();
        });

        $("select[name=schedule]").on("change", function() {
            table.draw();
        });

        $("select[name=company]").on("change", function() {
            table.draw();
        });
    </script>
@endsection
