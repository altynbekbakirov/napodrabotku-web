@extends('admin.layouts.app')

@section('content')

    @include('admin.subheaders.pages')

    @content
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Список
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{route('pages.create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--air m-btn--pill">
                            <span><i class="la la-plus"></i> <span> Создать</span></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <div class="table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable m_datatable" id="dataTable">
                    <thead>
                        <tr>
                            <th>#Id</th>
                            <th>На кыргызском</th>
                            <th>На русском</th>
                            <th>URL</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>                
                </table>
            </div>
            <!--end: Datatable -->
        </div>
    </div>
    @endcontent

@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {
      
      $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('pages.api') }}',
            columns: [
              { data: 'id'},
              { data: 'name.ky'},
              { data: 'name.ru'},
              { data: 'slug'},
              { data: 'status'},
              { data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            pageLength: 25,
            language: {
                "url": "{{asset('js/russian.json')}}"
            }
      });
    });
</script>

@endsection

