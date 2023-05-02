@extends('admin.layouts.app')

@section('content')

    @include('admin.partials.subheader')

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Добавить</h3>
                </div>
                <!--begin::Form-->
                {!! Form::model(auth()->user(), ['route' => ['users.update', auth()->user()], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'form']) !!}

                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-group row">
                                <label class="col-3 mt-2" for="name">Изображение</label>
                                <div class="col-9">
                                    <div class="image-input image-input-outline bg-gray-100" id="kt_image_2">
                                        <div class="image-input-wrapper" style="max-width: 100%; width: 200px; height: 200px; @if(auth()->user()->avatar) background-image: url({{asset(auth()->user()->avatar)}}); @endif background-position: center center;"></div>
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Изменить">
                                            <i class="la la-pencil icon-sm text-muted"></i>
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                            <input type="hidden" name="image_remove"/>
                                        </label>

                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Удалить">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>

                                        @if(auth()->user()->avatar)
                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Удалить">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                        @endif
                                    </div>
                                    <span class="form-text text-muted">Допустимые разрешения: png, jpg, jpeg.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Название организации:</label>
                                <div class="col-lg-4">
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Email:</label>
                                <div class="col-lg-4">
                                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Пароль:</label>
                                <div class="col-lg-4">
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Телефон:</label>
                                <div class="col-lg-4">
                                    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Адрес:</label>
                                <div class="col-lg-4">
                                    {!! Form::text('address', null, ['class' => 'form-control']) !!}
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

