@extends('admin.layouts.app')

@section('content')

    @include('admin.partials.subheader')

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <!--begin::Form-->
                {!! Form::model(null, ['route' => ['admin.account', auth()->user()], 'method' => 'GET', 'enctype' => 'multipart/form-data', 'class' => 'form']) !!}

                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Лицевой счет:</label>
                                <div class="col-lg-4">
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Реквизиты компании:</label>
                                <div class="col-lg-4">
                                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Контактное лицо:</label>
                                <div class="col-lg-4">
                                    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-success mr-2">Сохранить</button>
                                <button type="reset" class="btn btn-secondary" onclick="window.history.back();">Отмена</button>
                            </div>
                        </div>
                    </div>

                {!! Form::close() !!}
                <!--end::Form-->
            </div>
        </div>
        <!--end::Container-->
    </div>

@endsection

@section('scripts')
    <script>
        var avatar2 = new KTImageInput('kt_image_2');
    </script>
@endsection

