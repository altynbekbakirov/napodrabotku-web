@extends('admin.layouts.app')

{{--@section('content')--}}

{{--    @subheader--}}
{{--    Основные--}}
{{--    @endsubheader--}}

{{--    @content--}}
{{--    <div class="m-portlet m-portlet--mobile">--}}
{{--        <div class="m-portlet__head">--}}
{{--            <div class="m-portlet__head-caption">--}}
{{--                <div class="m-portlet__head-title">--}}
{{--                    <h3 class="m-portlet__head-text">--}}
{{--                        Список--}}
{{--                    </h3>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="m-portlet__body">--}}
{{--            <!--begin: Datatable -->--}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table table-striped- table-bordered table-hover table-checkable m_datatable" id="dataTable">--}}
{{--                    <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Лого</th>--}}
{{--                            <th>Название</th>--}}
{{--                            <th>Действия</th>--}}
{{--                        </tr>--}}
{{--                    </thead>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--            <!--end: Datatable -->--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    @endcontent--}}

{{--@endsection--}}

{{--@section('scripts')--}}
{{--<script type="text/javascript">--}}
{{--    $(function () {--}}

{{--      $('#dataTable').DataTable({--}}
{{--            processing: true,--}}
{{--            serverSide: true,--}}
{{--            ajax: '{{ route('main.api') }}',--}}
{{--            columns: [--}}
{{--              { data: 'logo'},--}}
{{--              { data: 'name.ru'},--}}
{{--              { data: 'action', name: 'action', orderable: false, searchable: false},--}}
{{--            ],--}}
{{--            pageLength: 25,--}}
{{--            language: {--}}
{{--                "url": "{{asset('js/russian.json')}}"--}}
{{--            }--}}
{{--      });--}}
{{--    });--}}
{{--</script>--}}

{{--@endsection--}}

