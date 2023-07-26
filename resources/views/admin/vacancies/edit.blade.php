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
                {!! Form::model($vacancy, [
                    'route' => ['vacancies.update', $vacancy],
                    'method' => 'PUT',
                    'enctype' => 'multipart/form-data',
                    'class' => 'form',
                ]) !!}
                @include('admin.vacancies.form', $vacancy)
                {!! Form::close() !!}
                <!--end::Form-->
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.tiny.cloud/1/vkkx1375a49z5xv1vzho0dwn38cixcyxqx0i0nn8tcn65goy/tinymce/5/tinymce.min.js">
    </script>
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
                success: function(data) {
                    if (data) {
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

        $('input[name=address]').on('keyup', function() {
            clearTimeout(timer);

            suggestionsDiv.find('ul').removeClass('show');
            suggestionsDiv.find('ul').children('li').remove();
            suggestionsLoading.removeClass('d-none');

            let value = $(this).val();
            if (value.length > 3) {

                suggestionsDiv.find('ul').addClass('show');

                timer = setTimeout(function() {

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        url: `{{ route('dadata.user') }}`,
                        type: 'POST',
                        data: {
                            key: value
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.suggestions) {
                                suggestionsLoading.addClass('d-none');
                                suggestionsDiv.find('ul').children('li').remove();
                                for (let i = 0; i < data.suggestions.length; i++) {
                                    suggestionsDiv.find('ul').append('<li><a data-index="' + i +
                                        '" class="dropdown-item" href="#">' + data
                                        .suggestions[i].value + '</a></li>');
                                }

                                $('#suggestions .dropdown-item').on('click', function(e) {
                                    e.preventDefault();
                                    let index = $(this).attr('data-index');
                                    let item = data.suggestions[index];

                                    console.log(item);

                                    $('input[name=address]').val(item.value);
                                    $('input[name=region]').val(item.data
                                        .region_with_type);
                                    $('input[name=district]').val(item.data.city);
                                    $('input[name=street]').val(item.data.street);
                                    $('input[name=house]').val(item.data.house);

                                    form.append(
                                        '<input type="hidden" name="lat" value="' +
                                        item.data.geo_lat + '">');
                                    form.append(
                                        '<input type="hidden" name="lonq" value="' +
                                        item.data.geo_lon + '">');

                                    suggestionsDiv.find('ul').removeClass('show');

                                    var metroTag = $('#data_metro');
                                    metroTag.empty();
                                    metroTag.selectpicker('refresh');
                                    $.each(item.data.metro, function(key, value) {
                                        var url =
                                            "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/metro";

                                        $.ajax({
                                            headers: {
                                                "Content-Type": "application/json",
                                                "Accept": "application/json",
                                                "Authorization": "Token " +
                                                    "d06b572efe686359a407652e5f66ef079ea649dc"
                                            },
                                            url: url,
                                            type: 'POST',
                                            data: JSON.stringify({
                                                query: value['name'],
                                                "filters": [{
                                                    "city": item.data.city
                                                }]
                                            }),
                                            dataType: 'json',
                                            success: function(dataMetro) {
                                                if(dataMetro.suggestions){
                                                    for (let i = 0; i < dataMetro.suggestions.length; i++) {
                                                        if(dataMetro.suggestions[i].data.line_name == value['line']){
                                                            metroTag.append($(
                                                                `<option data-content="<span class='badge' style='color: #ffffff; background-color: #${dataMetro.suggestions[i].data.color}'>${dataMetro.suggestions[i].data.name} (${dataMetro.suggestions[i].data.line_name})</span>" value='${dataMetro.suggestions[i].data.name}-${dataMetro.suggestions[i].data.line_name}'>
                                                                    ${dataMetro.suggestions[i].data.name} (${dataMetro.suggestions[i].data.line_name})
                                                                </option>`
                                                            ));
                                                        }
                                                    }
                                                    metroTag.selectpicker('refresh');
                                                }
                                            }
                                        });

                                    });
                                    metroTag.selectpicker('refresh');
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

        // Class definition
        var KTTinymce = function() {
            // Private functions
            var demos = function() {
                tinymce.init({
                    selector: '#kt-tinymce-app',
                    invalid_elements: 'a',
                    menubar: false,
                    toolbar: [
                        'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent',
                    ],
                    plugins: 'advlist lists charmap print preview code',
                    // init_instance_callback: function(editor) {
                    //     editor.on('input', function(e) {
                    //         var someText = e.target.innerHTML.toLowerCase();
                    //         let isFounded = badwords.some(ai => someText.includes(ai));
                    //         if (isFounded == true) {
                    //             for (i = 0; i < badwords.length; ++i) {
                    //                 if (someText.toLowerCase().indexOf(badwords[i]) >= 0) {
                    //                     alert("Описание содержит запрещенные слова, пожалуйста, удалите их, прежде чем продолжить: " +
                    //                         badwords[i]);
                    //                     return false;
                    //                 }
                    //             }
                    //         }
                    //     });
                    // }
                });
            }

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        var badwords = @json($badwords, JSON_UNESCAPED_UNICODE);

        jQuery(function() {
            $(".btn-success").on("click", function() {
                var editor = 'content_textarea';
                var tiny_content = tinyMCE.activeEditor.getContent({
                    format: "text"
                });

                let isFounded = badwords.some(ai => tiny_content.toLowerCase().includes(ai));
                if (isFounded == true) {
                    for (i = 0; i < badwords.length; ++i) {
                        if (tiny_content.toLowerCase().indexOf(badwords[i]) >= 0) {
                            alert("Описание содержит запрещенные слова, пожалуйста, удалите их, прежде чем продолжить: " +
                                badwords[i]);
                            return false;
                        }
                    }
                }
            });
        });


        // Initialization
        jQuery(document).ready(function() {
            KTTinymce.init();
        });
    </script>
@endsection
