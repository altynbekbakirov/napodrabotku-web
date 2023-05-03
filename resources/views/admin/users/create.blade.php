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

        let timer;
        let timeout = 2000;
        let suggestionsDiv = $('#suggestions');
        let suggestionsLoading = $('#suggestionsLoading');
        let suggestions = [];

        $('input[name=address]').on('keyup', function () {
            clearTimeout(timer);

            suggestionsDiv.find('ul').removeClass('show');
            suggestionsDiv.find('ul').children('li').remove();
            suggestionsLoading.removeClass('d-none');

            let value = $(this).val();
            if(value.length > 3) {

                suggestionsDiv.find('ul').addClass('show');

                timer = setTimeout(function(){

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        url: `{{route('dadata.user')}}`,
                        type: 'POST',
                        data: {
                            key: value
                        },
                        dataType: 'json',
                        success: function(data) {
                            if(data.suggestions){
                                suggestionsLoading.addClass('d-none');
                                suggestionsDiv.find('ul').children('li').remove();
                                for(let i=0; i<data.suggestions.length; i++){
                                    suggestionsDiv.find('ul').append('<li><a data-index="'+i+'" class="dropdown-item" href="#">'+data.suggestions[i].value+'</a></li>');
                                }

                                $('#suggestions .dropdown-item').on('click', function (e) {
                                    e.preventDefault();
                                    let index = $(this).attr('data-index');
                                    let item = data.suggestions[index];

                                    $('input[name=address]').val(item.value);
                                    $('input[name=region]').val(item.data.region);
                                    $('input[name=district]').val(item.data.city);
                                    $('input[name=street]').val(item.data.street);
                                    $('input[name=house]').val(item.data.house);

                                    suggestionsDiv.find('ul').removeClass('show');
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Произошла ошибка при обновлении статуса: ' + error);
                        }
                    });

                }, timeout);
            } else {

                suggestionsDiv.find('ul').removeClass('show');
                suggestionsDiv.find('ul').children('li').remove();
                suggestionsLoading.removeClass('d-none');

            }

        });

    </script>
@endsection

