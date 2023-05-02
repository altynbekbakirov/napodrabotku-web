@extends('admin.layouts.app')

@section('content')

    @subheader
    Основные
    @endsubheader

    @content
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Редактировать
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="m-portlet__body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::model($row,
                        [	'id' => 'editForm',
                            'route' => ['main.update', $row], 
                            'method' => 'PUT', 
                            'enctype' => 'multipart/form-data'
                        ]) !!}
                        @include('admin.main.form', $row)
                    {!! Form::close() !!}
                </div>
            <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    @endcontent

@endsection

@section('scripts')
<script>
    $('#post_loader').hide();
    $("#editForm").on("submit", function(){
        $("#post_loader").show();
    });   

    var $repeat = $("#m_repeater_social").repeater({
        isFirstItemUndeletable: true,
        initEmpty: !1,
    });
    $repeat.setList({!!$socials!!});

    $("#thumbremove").click(function (e) {
        event.preventDefault();
        var page = "{{$row->id}}";
        var url = "{{ route('main.removethumb') }}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            cache: false,
            type: 'POST',
            url: url,
            data: {
                'page':page,
            },
            success: function (data) {
                if (data.status) {
                    console.log('Success')
                }
            }
    
        });
    });
</script>
@endsection
