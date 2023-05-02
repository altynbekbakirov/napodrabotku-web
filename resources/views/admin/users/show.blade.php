@extends('admin.layouts.app')

@section('content')

    @include('admin.partials.subheader')

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header py-3">
                    <div class="card-title">
                        <h3 class="card-label font-weight-bolder text-dark">{{$user->name}}</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('users.index', ['type' => $user->type])}}" class="btn btn-secondary mr-2">Назад</a>
                        <a href="{{route('users.edit', $user)}}" class="btn btn-success mr-2">Редактировать</a>
                        <a href="{{route('users.delete', $user)}}" class="btn btn-danger">Удалить</a>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form class="form">
                    <div class="card-body">

                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Изображение:</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="symbol symbol-150 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                    <div class="symbol-label" style="background-image:url({{asset($user->avatar)}})"></div>
                                    <i class="symbol-badge bg-success"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">ФИО или Название:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{$user->name}}</p>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-10"></div>

                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Email:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{$user->email}}</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Телефон:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{$user->phone_number}}</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Адрес:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{$user->address}}</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Статус:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{!! $user->getStatus() !!}</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Дата добавления:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{!! $user->getCreatedDate() !!}</p>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
        <!--end::Container-->
    </div>

@endsection

