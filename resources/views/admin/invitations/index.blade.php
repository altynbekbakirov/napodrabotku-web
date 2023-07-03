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
                                        'data-live-search' => 'true',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 my-2 my-md-0">
                                    {!! Form::select('region', $regions, null, [
                                        'class' => 'selectpicker',
                                        'placeholder' => 'Регион вакансии',
                                        'data-width' => '100%',
                                        'data-size' => '6',
                                        'data-live-search' => 'true',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 my-2 my-md-0">
                                    {!! Form::select('district', $districts, null, [
                                        'class' => 'selectpicker',
                                        'placeholder' => 'Город проживания',
                                        'data-width' => '100%',
                                        'data-size' => '6',
                                        'data-live-search' => 'true',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 my-2 my-md-0">
                                    {!! Form::select('citizend', $citizens, null, [
                                        'class' => 'selectpicker form-control',
                                        'placeholder' => 'Гражданство',
                                        'data-width' => '100%',
                                        'data-size' => '6',
                                        'data-live-search' => 'true',
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
                                    <div class="card">
                                        <div class="card-body"
                                            style="display: flex;
                                        align-items: center;">
                                            <div class="h4">
                                                Количество открытий контактов: </div>
                                            &nbsp;&nbsp;&nbsp;
                                            <div class="display-3 font-weight-boldest">
                                                {{ auth()->user()->invitation_count }}</div>
                                        </div>
                                    </div>
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
                                    <th><input type="checkbox" name="checkbox-all" id="checkbox-all" /></th>
                                    <th>Дата добавления</th>
                                    <th>Соискатель</th>
                                    <th>Телефон</th>
                                    <th>Гражданство соискателя</th>
                                    <th>Возраст соискателя</th>
                                    <th>Город проживания</th>
                                    <th>Интересуемые вакансии</th>
                                    <th>Предлагаемая вакансия</th>
                                    <th width='150px'>Статус</th>
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
            buttons: [

            ],
            dom: `<'row'<'col-sm-6 text-left'><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-3'i><'col-sm-12 col-md-2 status_change'><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            initComplete: function() {
                $('div.status_change').html(
                    "<select class='form-control' name='status_select_change'><option value='' disabled selected>ДЕЙСТВИЯ</option><option value='invited'>Пригласить</option><option value='deleted'>Удалить</option></select>"
                );

                $('input[name=checkbox-all]').on("change", function() {
                    if (this.checked) {
                        $(':checkbox').each(function() {
                            if (!$(this).attr('disabled')) {
                                this.checked = true;
                            }
                        });
                    } else {
                        $(':checkbox').each(function() {
                            this.checked = false;
                        });
                    }
                });

                $('input[name="checkbox-product"]').on('change', function() {
                    if ($(this).is(':checked')) {} else {
                        $('input[name="checkbox-all"').prop('checked', false);
                    }
                });
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('invitations.index') }}',
                data: function(d) {
                    d.search = $('#kt_datatable_search_query').val();
                    d.vacancy_id = $('select[name=vacancy]').val();
                    d.citizen_id = $('select[name=citizend]').val();
                    d.region_id = $('select[name=region]').val();
                    d.period_id = $('input[name=period]').val();
                    d.district_id = $('select[name=district]').val();
                    d.status_id = $("button.btn-success").attr('status_id');
                }
            },
            columns: [{
                    data: 'check_box',
                    "sortable": false
                },
                {
                    data: 'date'
                },
                {
                    data: 'user_name'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'citizen'
                },
                {
                    data: 'birth_date'
                },
                {
                    data: 'city'
                },
                {
                    data: 'name'
                },
                {
                    data: 'recommended'
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
            }
        });

        $('#kt_datatable_search_query').keyup(function() {
            table.draw();
        });

        var start = moment().subtract(29, 'days');
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

        $('#dataTable').on('click', '#show_phone', function(e) {
            var value = $(this).attr('data-phone');
            $(this).text(value);
        });

        $("select[name=vacancy]").on("change", function() {
            table.draw();
        });

        $("select[name=citizend]").on("change", function() {
            table.draw();
        });

        $("select[name=region]").on("change", function() {
            table.draw();
        });

        $("input[name=period]").on("change", function() {
            table.draw();
        });

        $("select[name=district]").on("change", function() {
            table.draw();
        });


        $("button").on("click", function(e) {
            $("button").removeClass("btn-success").removeClass("btn-light").addClass("btn-light");
            $(this).removeClass('btn-light').addClass('btn-success');
            table.draw();
        });
    </script>
@endsection
