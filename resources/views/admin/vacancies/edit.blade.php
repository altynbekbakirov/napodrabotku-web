@extends('admin.layouts.app')

@section('content')

    @include('admin.partials.subheader')

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Редактировать</h3>
                </div>
                <!--begin::Form-->
                {!! Form::model($vacancy, ['route' => ['vacancies.update', $vacancy], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'form']) !!}
                @include('admin.vacancies.form', $vacancy)
                {!! Form::close() !!}
                <!--end::Form-->
            </div>
        </div>
        <!--end::Container-->
    </div>

@endsection

@section('scripts')
    <script>
        $('[name=region_id]').on('change', function() {
            var url = "{{ route('districts.region') }}";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                cache: false,
                type: 'POST',
                url: url,
                data: {
                    'region': $(this).val(),
                },
                success: function (data) {
                    if(data) {
                        $('[name=district_id]').html(data);
                        $('[name=district_id]').selectpicker('refresh');
                    }
                }

            });
        });

        let timer;
        let timeout = 2000;
        let suggestionsDiv = $('#suggestions');
        let suggestionsLoading = $('#suggestionsLoading');
        let suggestions = [];
        let form = $('.form');

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
                                    $('input[name=region]').val(item.data.region_with_type);
                                    $('input[name=district]').val(item.data.city);
                                    $('input[name=street]').val(item.data.street);
                                    $('input[name=house]').val(item.data.house);

                                    form.append('<input type="hidden" name="lat" value="'+item.data.geo_lat+'">');
                                    form.append('<input type="hidden" name="lonq" value="'+item.data.geo_lon+'">');

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
