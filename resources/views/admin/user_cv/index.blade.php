@extends('admin.layouts.app')

@section('content')
    @include('admin.partials.subheader')

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-body">
                    <!--begin: Search Form-->
                    <div class="row mt-7">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2 my-2 my-md-0">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" placeholder="Поиск..."
                                            id="kt_datatable_search_query" />
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2 my-2 my-md-0">
                                    {!! Form::text('period', null, [
                                        'class' => 'datepicker form-control',
                                        'data-width' => '100%',
                                        'readonly' => 'true',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 my-2 my-md-0">
                                    {!! Form::select('vacancy', $vacancies, null, [
                                        'class' => 'selectpicker',
                                        'placeholder' => 'Выберите вакансию',
                                        'data-width' => '100%',
                                        'data-size' => '6',
                                        'id' => 'kt_datatable_search_vacancy',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 my-2 my-md-0">
                                    {!! Form::select('country', $countries, null, [
                                        'class' => 'selectpicker',
                                        'placeholder' => 'Страна вакансии',
                                        'data-width' => '100%',
                                        'data-size' => '6',
                                        'id' => 'kt_datatable_search_region',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 my-2 my-md-0">
                                    {!! Form::select('region', $regions, null, [
                                        'class' => 'selectpicker',
                                        'placeholder' => 'Город вакансии',
                                        'data-width' => '100%',
                                        'data-size' => '6',
                                        'id' => 'kt_datatable_search_region',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 my-2 my-md-0">
                                    {!! Form::select('sex', $sexes, null, [
                                        'class' => 'selectpicker form-control',
                                        'placeholder' => 'Пол соискателя',
                                        'data-width' => '100%',
                                        'data-size' => '6',
                                        'id' => 'kt_datatable_search_sex',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-10">
                                    @foreach ($stats as $status)
                                        {!! $status !!}
                                    @endforeach
                                </div>
                                <div class="col-md-2 mt-lg-0 text-right">
                                    <a href="{{ route('user_cv.create') }}" class="btn btn-primary font-weight-bold">
                                        <span class="svg-icon svg-icon-md">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
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
                    </div>
                    <!--end: Search Form-->
                    <!--begin: Datatable-->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Дата отклика</th>
                                    <th>Название вакансии</th>
                                    <th>Страна вакансии</th>
                                    <th>Город вакансии</th>
                                    <th>Соискатель</th>
                                    <th>Гражданство соискателя</th>
                                    <th>Возраст соискателя</th>
                                    <th width='150px'>Статус отклика</th>
                                    <th width='120px'>&nbsp;</th>
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
            ],
            dom: `<'row'<'col-sm-6 text-left'><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('user_cv.index') }}',
                data: function(d) {
                    d.search = $('#kt_datatable_search_query').val();
                    d.vacancy_id = $('select[name=vacancy]').val();
                    d.country_id = $('select[name=country]').val();
                    d.region_id = $('select[name=region]').val();
                    d.period_id = $('input[name=period]').val();
                    d.sex_id = $('select[name=sex]').val();
                    d.status_id = $("button.btn-success").attr('status_id');
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'date'
                },
                {
                    data: 'name'
                },
                {
                    data: 'country'
                },
                {
                    data: 'region'
                },
                {
                    data: 'user_name'
                },
                {
                    data: 'citizen'
                },
                {
                    data: 'birth_date'
                },
                {
                    data: 'status'
                },
                {
                    data: 'acts'
                },
            ],
            order: [
                [0, "asc"]
            ],
            pageLength: 25,
            language: {
                "url": "{{ asset('js/russian.json') }}"
            },
            initComplete: function() {
                $('.selectpicker').selectpicker();
             }
        });
        

        $('#kt_datatable_search_query').keyup(function() {
            table.draw();
        });

        var start = moment().subtract(1, 'year');
        var end = moment();

        $('.datepicker').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            startDate: start,
            endDate: end,
            ranges: {
                '7 дней': [moment().subtract(6, 'days'), moment()],
                '30 дней': [moment().subtract(29, 'days'), moment()],
                'Год': [moment().subtract(1, 'year'), moment()]
            },
            locale: {
                format: 'DD.MM.YYYY',
                cancelLabel: 'Очистить',
                applyLabel: 'Применить',
                customRangeLabel: 'Другие даты'
            }
        }, function(start, end, label) {
            $('.datepicker').val(start.format('DD.MM.YYYY') + ' / ' + end.format('DD.MM.YYYY'));
        });


        $('#dataTable').on('change', '.select_status', function(e) {
            var value = $(this).val();
            var selectedOption = $(this).find('option:selected');
            var customAttrValue = selectedOption.attr('data-vacancy-id');
            $.ajax({
                url: `/admin/user_cv/${customAttrValue}/${value}`,
                type: 'GET',
                success: function(result) {
                    table.draw();
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log('Произошла ошибка при обновлении статуса: ' + error);
                }
            });
        });

        $("select[name=vacancy]").on("change", function() {
            table.draw();
        });

        $("select[name=country]").on("change", function() {
            table.draw();
        });

        $("select[name=region]").on("change", function() {
            table.draw();
        });

        $("input[name=period]").on("change", function() {
            table.draw();
        });

        $("select[name=sex]").on("change", function() {
            table.draw();
        });

        $("select[name=statuses]").on("change", function() {
            table.draw();
        });
        $("button").on("click", function(e) {
            $("button").removeClass("btn-success").removeClass("btn-light").addClass("btn-light");
            $(this).removeClass('btn-light').addClass('btn-success');
            table.draw();
        });
    </script>
@endsection
