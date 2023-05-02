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
                                    Создать
                                </h3>
                            </div>
                        </div>
                    </div>
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
                        {!! Form::model(
                            $row,['id' => 'createForm',
                            'route' => 'main.store',
                            'enctype' => 'multipart/form-data',
                            'class' => 'm-form']) !!}
                            @include('admin.main.form', $row)
                        {!! Form::close() !!}
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    @endcontent

@endsection

@section('scripts')
<script>

    $('#post_loader').hide();
    $("#createForm").on("submit", function(){
        $("#post_loader").show();
    });

    var $repeat = $("#m_repeater_social").repeater({
        isFirstItemUndeletable: true,
        initEmpty: !1,
    });
</script>
@endsection

