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
                        <h3 class="card-label font-weight-bolder text-dark">
                            <span>{{$user->name}}</span>
                            <span class="d-block font-weight-normal text-dark-50 mt-1">{{$vacancy->name}}</span>
                        </h3>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form class="form">
                    <div class="card-body">

                        <h5 class="text-dark font-weight-bold text-uppercase mb-6">Базовая информация:</h5>

                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">ФИО:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{$user->name}}</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Э-адрес:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{$user->email}}</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Должность:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{$user->cv->job_title}}</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Номер телефона:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{$user->phone_number}}</p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Опыт работы:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0">{{$user->cv->experience_year}}</p>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-10"></div>

                        <h5 class="text-dark font-weight-bold text-uppercase mb-6">Образование:</h5>

                        @foreach($user_educations as $user_education)
                            <div class="form-group row align-items-center">
                                <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">
                                    <div class="symbol symbol-60 symbol-light">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Clipboard.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z" fill="#000000"/>
                                                        <path d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z" fill="#000000" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </div>
                                </label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <span class="text-dark-75 mb-1 font-size-lg font-weight-bolder">
                                            {{$user_education->title}}
                                        </span>
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="text-muted font-weight-bold">
                                                {{$user_education->type->name}}, {{$user_education->faculty}}, {{$user_education->speciality}}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted font-weight-bold">
                                                {{$user_education->end_year}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="separator separator-dashed my-10"></div>

                        <h5 class="text-dark font-weight-bold text-uppercase mb-6">Опыт работы:</h5>

                        @foreach($user_experiences as $user_experience)
                            <div class="form-group row align-items-center">
                                <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">
                                    <div class="symbol symbol-60 symbol-light">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Clipboard.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M5.84026576,8 L18.1597342,8 C19.1999115,8 20.0664437,8.79732479 20.1528258,9.83390904 L20.8194924,17.833909 C20.9112219,18.9346631 20.0932459,19.901362 18.9924919,19.9930915 C18.9372479,19.9976952 18.8818364,20 18.8264009,20 L5.1735991,20 C4.0690296,20 3.1735991,19.1045695 3.1735991,18 C3.1735991,17.9445645 3.17590391,17.889153 3.18050758,17.833909 L3.84717425,9.83390904 C3.93355627,8.79732479 4.80008849,8 5.84026576,8 Z M10.5,10 C10.2238576,10 10,10.2238576 10,10.5 L10,11.5 C10,11.7761424 10.2238576,12 10.5,12 L13.5,12 C13.7761424,12 14,11.7761424 14,11.5 L14,10.5 C14,10.2238576 13.7761424,10 13.5,10 L10.5,10 Z" fill="#000000"/>
                                                        <path d="M10,8 L8,8 L8,7 C8,5.34314575 9.34314575,4 11,4 L13,4 C14.6568542,4 16,5.34314575 16,7 L16,8 L14,8 L14,7 C14,6.44771525 13.5522847,6 13,6 L11,6 C10.4477153,6 10,6.44771525 10,7 L10,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </div>
                                </label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <span class="text-dark-75 mb-1 font-size-lg font-weight-bolder">
                                            {{$user_experience->job_title}}
                                        </span>
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="text-muted font-weight-bold">
                                                {{$user_experience->organization_name}}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted font-weight-bold">
                                                {{$user_experience->start_date}} - {{$user_experience->end_date}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="separator separator-dashed my-10"></div>

                        <h5 class="text-dark font-weight-bold text-uppercase mb-6">Курсы:</h5>

                        @foreach($user_courses as $user_course)
                            <div class="form-group row align-items-center">
                                <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">
                                    <div class="symbol symbol-60 symbol-light">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Clipboard.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M11,20 L11,17 C11,16.4477153 11.4477153,16 12,16 C12.5522847,16 13,16.4477153 13,17 L13,20 L15.5,20 C15.7761424,20 16,20.2238576 16,20.5 C16,20.7761424 15.7761424,21 15.5,21 L8.5,21 C8.22385763,21 8,20.7761424 8,20.5 C8,20.2238576 8.22385763,20 8.5,20 L11,20 Z" fill="#000000" opacity="0.3"/>
                                                        <path d="M3,5 L21,5 C21.5522847,5 22,5.44771525 22,6 L22,16 C22,16.5522847 21.5522847,17 21,17 L3,17 C2.44771525,17 2,16.5522847 2,16 L2,6 C2,5.44771525 2.44771525,5 3,5 Z M4.5,8 C4.22385763,8 4,8.22385763 4,8.5 C4,8.77614237 4.22385763,9 4.5,9 L13.5,9 C13.7761424,9 14,8.77614237 14,8.5 C14,8.22385763 13.7761424,8 13.5,8 L4.5,8 Z M4.5,10 C4.22385763,10 4,10.2238576 4,10.5 C4,10.7761424 4.22385763,11 4.5,11 L7.5,11 C7.77614237,11 8,10.7761424 8,10.5 C8,10.2238576 7.77614237,10 7.5,10 L4.5,10 Z" fill="#000000"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </div>
                                </label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <span class="text-dark-75 mb-1 font-size-lg font-weight-bolder">
                                            {{$user_course->name}}
                                        </span>
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="text-muted font-weight-bold">
                                                {{$user_course->organization_name}}, {{$user_course->duration}}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted font-weight-bold">
                                                {{$user_course->end_year}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="separator separator-dashed my-10"></div>

                        <div class="form-group row align-items-center">
                            <label class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Дата подачи:</label>
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

