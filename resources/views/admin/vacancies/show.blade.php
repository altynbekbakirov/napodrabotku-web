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
                        <h3 class="card-label font-weight-bolder text-dark">{{ $vacancy->name }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="reset" class="btn btn-secondary" onclick="window.history.back();">Назад</button>
                        &nbsp;&nbsp;
                        <a href="{{ route('vacancies.edit', $vacancy) }}" class="btn btn-success mr-2">Редактировать</a>
                        <a href="{{ route('vacancies.delete', $vacancy) }}" class="btn btn-danger">Удалить</a>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form class="form">
                    <div class="card-body">

                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Название:</label>
                            <div class="col-lg-9 col-xl-6">
                                <h4 class="card-label font-weight-bolder text-uppercase">{{ $vacancy->name }}</h4>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Зарплата:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{ $vacancy->salary }} ({{ $currency }})</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Компания:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{ $vacancy->company->name }}</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Описание:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{!! $vacancy->description !!}</p>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-10"></div>

                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Адрес:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{ $vacancy->address }}</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Метро:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">
                                    @foreach ($metros as $metro)
                                        {!! $metro !!}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Вид
                                занятости:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{ $vacancy->busyness->name_ru }}</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Тип
                                вакансии:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{ $vacancy->vacancytype->name_ru }}</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Сфера
                                работы:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{ $vacancy->jobtype->name_ru }}</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">График
                                работы:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{ $vacancy->schedule->name_ru }}</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Частота
                                выплат:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{ $pay_periods[$vacancy->pay_period] }}</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Требуемый
                                опыт работы:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{ $experiences[$vacancy->experience] }}</p>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-10"></div>

                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Дата
                                добавления:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{!! $vacancy->getCreatedDate() !!}</p>
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
