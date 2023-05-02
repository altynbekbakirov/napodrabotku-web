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
                {!! Form::model($user, ['route' => 'users.store', 'enctype' => 'multipart/form-data', 'class' => 'form']) !!}
                @include('admin.users.form', $user)
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

        $('.datepicker').daterangepicker({ 
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: true,
            autoApply: true,
            timePicker: false,
            timePicker24Hour: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Очистить',
                applyLabel: 'Применить',
            }
        });

        let ru_code = '+7 999 999 99 99';
        let kg_code = '+996 999 99 99 99';
        let uz_code = '+998 999 999 99 99';

        
        // $('.phone_number').mask(ru_code, {
        //     placeholder: ru_code
        // });

        $('.phone_number').on('change keyup paste', function(e) {
            if($(this).val().substring(0, 2) == '+7' || $(this).val().substring(0, 1) == '7'){
                $('.phone_number').mask(ru_code, {
                    placeholder: ru_code
                });
            }
            else if($(this).val().substring(0, 2) == '+9' || $(this).val().substring(0, 1) == '9'){
                $('.phone_number').mask(kg_code, {
                    placeholder: kg_code
                });
            } else {
                $('.phone_number').mask(uz_code, {
                    placeholder: uz_code
                });
            } 
        });

    </script>
@endsection

