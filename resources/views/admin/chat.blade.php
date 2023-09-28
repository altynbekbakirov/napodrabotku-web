@extends('admin.layouts.app')

@section('content')

    @include('admin.partials.subheader')

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Chat-->
            <div class="d-flex flex-row">
                <!--begin::Aside-->
                <div class="flex-row-auto offcanvas-mobile w-350px w-xl-400px" id="kt_chat_aside">
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin:Users-->
                            <div class="mt-7 scroll scroll-pull">
                                @if ($chats)
                                    @foreach ($chats as $chat)
                                        <!--begin:User-->
                                        <div
                                            class="rounded d-flex align-items-center justify-content-between p-4 @if ($selected_chat && $selected_chat->id == $chat->id) bg-light-primary @endif">
                                            <div class="d-flex align-items-center">
                                                @if ($chat->user->avatar)
                                                    <div class="symbol symbol-circle symbol-50 mr-3">
                                                        <img alt="Pic" src="{{ asset($chat->user->avatar) }}" />
                                                    </div>
                                                @endif
                                                <div class="d-flex flex-column">
                                                    <a href="{{ route('admin.chat', ['id' => $chat->id]) }}"
                                                        class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">{{ $chat->user->getFullName() }}</a>
                                                    <span
                                                        class="text-muted font-weight-bold font-size-sm">{{ $chat->vacancy ? $chat->vacancy->name : '' }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-end">
                                                {{-- <span class="text-muted font-weight-bold font-size-sm">35 mins</span> --}}
                                                @if ($chat->messages->where('user_id', '<>', auth()->user()->id)->where('read', false)->count() > 0)
                                                    <span class="label label-sm label-success">
                                                        {{ $chat->messages->where('user_id', '<>', auth()->user()->id)->where('read', false)->count() }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <!--end:User-->
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Aside-->
                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-8" id="kt_chat_content">
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <!--begin::Header-->
                        <div class="card-header align-items-center px-4 py-3">
                            <div class="text-left flex-grow-1">&nbsp;</div>
                            <div class="text-center flex-grow-1">
                                @if ($selected_chat)
                                    {{ $selected_chat->user->getFullName() }}
                                    <a href="#" id="modalVacancy" data-vacancy-id='{{ $selected_chat->vacancy->id }}'
                                        class="text-muted" data-toggle="modal"
                                        data-target="#exampleModalScrollable">({{ $selected_chat->vacancy ? $selected_chat->vacancy->name : '' }})</a>
                                @endif
                            </div>
                            <div class="text-right flex-grow-1">
                                @if ($selected_chat)
                                    <!--begin::Dropdown Menu-->
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="svg-icon svg-icon-lg">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <circle fill="#000000" cx="12" cy="5"
                                                            r="2" />
                                                        <circle fill="#000000" cx="12" cy="12"
                                                            r="2" />
                                                        <circle fill="#000000" cx="12" cy="19"
                                                            r="2" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </button>
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-md">
                                            <!--begin::Navigation-->
                                            <ul class="navi navi-hover py-5">
                                                <li class="navi-item">
                                                    <a href="{{ route('admin.chat.delete', $selected_chat) }}"
                                                        class="navi-link">
                                                        <span class="navi-text">Удалить чат</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!--end::Navigation-->
                                        </div>
                                    </div>
                                    <!--end::Dropdown Menu-->
                                @endif
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Scroll-->
                            <div id="messages-scroll" class="scroll scroll-pull" data-mobile-height="350">
                                <!--begin::Messages-->
                                <div class="messages" id="messages">

                                    @if ($selected_chat && $selected_chat->messages)
                                        @foreach ($selected_chat->messages as $message)
                                            @if ($message->user_id == auth()->user()->id)
                                                <!--begin::Message Out-->
                                                <div class="d-flex flex-column mb-5 align-items-end">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <span
                                                                class="text-muted font-size-sm">{{ $message->getCreatedDateTime() }}</span>
                                                            <a href="#"
                                                                class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Вы</a>
                                                        </div>
                                                        @if (auth()->user()->avatar)
                                                            <div class="symbol symbol-circle symbol-40 ml-3">
                                                                <img alt="Pic"
                                                                    src="{{ asset(auth()->user()->avatar) }}" />
                                                            </div>
                                                        @else
                                                            <div class="symbol symbol-circle symbol-40 ml-3">
                                                                <img alt="Pic"
                                                                    src="{{ asset('assets/media/users/default.jpg') }}" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                                                        {{ $message->message }}
                                                    </div>
                                                </div>
                                                <!--end::Message Out-->
                                            @else
                                                <!--begin::Message In-->
                                                <div class="d-flex flex-column mb-5 align-items-start">
                                                    <div class="d-flex align-items-center">
                                                        @if ($message->user->avatar)
                                                            <div class="symbol symbol-circle symbol-40 mr-3">
                                                                <img alt="Pic"
                                                                    src="{{ asset($message->user->avatar) }}" />
                                                            </div>
                                                        @else
                                                            <div class="symbol symbol-circle symbol-40 mr-3">
                                                                <img alt="Pic"
                                                                    src="{{ asset('assets/media/users/default.jpg') }}" />
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <a href="#"
                                                                class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{{ $message->user->getFullName() }}</a>
                                                            <span
                                                                class="text-muted font-size-sm">{{ $message->getCreatedDateTime() }}</span>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                                        {{ $message->message }}
                                                    </div>
                                                </div>
                                                <!--end::Message In-->
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <!--end::Messages-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer align-items-center">
                            @if ($selected_chat && $selected_chat->messages)
                                {!! Form::open([
                                    'route' => ['admin.chat.message', $selected_chat],
                                ]) !!}
                                <input type="hidden" name="chat_id" value="{{ $selected_chat->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <!--begin::Compose-->
                                <textarea class="form-control border-0 p-0" rows="2" placeholder="Написать сообщение" name="new_message"></textarea>
                                <div class="d-flex align-items-center justify-content-between mt-5">
                                    <div class="dropdown dropdown-inline w-75" id="quick_add_words">
                                        <button type="button" class="btn btn-light-grey btn-icon btn-sm"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon2-pen"></i>
                                        </button>

                                        <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                            @if ($words)
                                                <div class="dropdown-menu-menu">
                                                    @foreach ($words as $word)
                                                    <div class="d-flex flex-col justify-content-center align-items-center">
                                                        <a class="dropdown-item" href="#">{{ $word->word }}</a>
                                                        <button type="button"
                                                            class="btn btn-light-grey btn-icon btn-sm"><i
                                                                class="flaticon-delete"></i></button>&nbsp;
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <div class="d-flex flex-col justify-content-center align-items-center">
                                                &nbsp;&nbsp;<input type="text" id="new_quick_word" class="form-control w-80"
                                                    placeholder="Добавить" />&nbsp;&nbsp;
                                                <button type="button" id="new_quick_button"
                                                    class="btn btn-light-grey btn-icon btn-sm"><i
                                                        class="flaticon2-add"></i></button>&nbsp;&nbsp;
                                            </div>
                                        </div>

                                    </div>
                                    <div class="ml-auto">
                                        <input type="submit"
                                            class="btn btn-primary btn-md text-uppercase font-weight-bold py-2 px-6"
                                            value="Отправить">
                                    </div>
                                </div>
                                <!--begin::Compose-->
                                {!! Form::close() !!}
                            @endif
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Chat-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">

                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Название:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 vacancy_name"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Зарплата:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 vacancy_salary"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Компания:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 vacancy_company_name"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Описание:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 vacancy_description"></p>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-10"></div>

                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Адрес:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 address"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Метро:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 metro"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Вид
                                занятости:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 busyness_name"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Тип
                                вакансии:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 vacancy_type_name"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Сфера
                                работы:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 type_name"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">График
                                работы:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 schedule_name"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Частота выплат:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 pay_period"></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Требуемый опыт:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 experience"></p>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-10"></div>

                        <div class="form-group row align-items-center">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label font-weight-bolder text-left text-lg-right text-uppercase">Дата
                                добавления:</label>
                            <div class="col-lg-9 col-xl-6">
                                <p class="font-weight-bold mb-0 vacancy_created"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                        data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{asset('assets/js/pages/custom/chat/chat1.js')}}"></script>

    <script>

        // const messagesContainer = $('#messages');
        // const scrollContainer = $('#messages-scroll');

        $(document).ready(function() {
            // Scroll to down on adding new message
            // var objDiv = document.getElementById("messages");
            // objDiv.scrollTop = objDiv.scrollHeight;

            scrollContainer.scrollTop(scrollContainer[0].scrollHeight);
            KTUtil.scrollUpdate(scrollContainer);

            $.date = function(dateObject) {
                var d = new Date(dateObject);
                var day = d.getDate();
                var month = d.getMonth() + 1;
                var year = d.getFullYear();
                if (day < 10) {
                    day = "0" + day;
                }
                if (month < 10) {
                    month = "0" + month;
                }
                var date = day + "." + month + "." + year;

                return date;
            };

            // Show vacancy in modal form
            $('#modalVacancy').on('click', function() {
                $('.modal-title').text($(this).text());
                var vacancy_id = $(this).attr('data-vacancy-id');

                if (!$.isEmptyObject(vacancy_id)) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        cache: false,
                        type: 'POST',
                        url: `/admin/vacancies/get_vacancy`,
                        data: {
                            'id': vacancy_id
                        },
                        success: function(result) {
                            $('p.vacancy_name').text(result['name']);
                            var salary_from = result['salary_from'].length != 0 ? result['salary_from'] : 0;
                            var salary_to = result['salary_to'].length != 0 ? result['salary_to'] : 0;
                            $('p.vacancy_salary').text(salary_from + ' - ' + salary_to);
                            $('p.vacancy_company_name').text(result['company_name']);
                            $('p.vacancy_description').html(result['description']);
                            $('p.address').html(result['address']);
                            $('p.metro').html(result['metro']);
                            $('p.vacancy_created').text($.date(result['created_at']));
                            $('p.type_name').html(result['type_name']);
                            $('p.vacancy_type_name').html(result['vacancy_type_name']);
                            $('p.busyness_name').html(result['busyness_name']);
                            $('p.schedule_name').html(result['schedule_name']);
                            $('p.pay_period').html(result['pay_period']);
                            $('p.experience').html(result['experience']);

                        },
                        error: function(xhr, status, error) {
                            console.log('Произошла ошибка при обновлении статуса: ' +
                                error);
                        }
                    });
                }

            });

            // Form submit
            $('form').on('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var message = $('textarea[name=new_message]');
                var chat_id = $('input[name=chat_id]').val();
                var user_id = $('input[name=user_id]').val();

                if (jQuery.trim(message.val()).length > 0) {

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        cache: false,
                        type: 'POST',
                        url: `/admin/chat/${chat_id}/ajax_message`,
                        data: {
                            'user_id': user_id,
                            'chat_id': chat_id,
                            'new_message': $('textarea[name=new_message]').val(),
                        },
                        success: function(result) {
                            result['created_at'] = moment(result['created_at']).format(
                                'DD-MM-YYYY HH:mm');

                            $('#messages').append(`<div class="d-flex flex-column mb-5 align-items-end">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <span
                                                                class="text-muted font-size-sm">${result['created_at']}</span>
                                                            <a href="#"
                                                                class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Вы</a>
                                                        </div>
                                                        @if (auth()->user()->avatar)
                                                            <div class="symbol symbol-circle symbol-40 ml-3">
                                                                <img alt="Pic"
                                                                    src="{{ asset(auth()->user()->avatar) }}" />
                                                            </div>
                                                        @else
                                                            <div class="symbol symbol-circle symbol-40 ml-3">
                                                                <img alt="Pic"
                                                                    src="{{ asset('assets/media/users/default.jpg') }}" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                                                        ${result['message']}
                                                    </div>
                                                </div>`);

                            scrollContainer.scrollTop(scrollContainer[0].scrollHeight);
                            KTUtil.scrollUpdate(scrollContainer);
                        },
                        error: function(xhr, status, error) {
                            console.log('Произошла ошибка при обновлении статуса: ' +
                                error);
                        }

                    });

                    message.val('');

                }
            });

            // Add quick word to textarea
            $('.dropdown-menu-menu').on('click', 'a', function(e) {
                e.stopPropagation();

                var text_area = $('textarea[name=new_message]');
                if ($('textarea[name=new_message]').val().length > 0) {
                    text_area.val($('textarea[name=new_message]').val() + ' ' + $(this).text());
                } else {
                    text_area.val($(this).text());
                }
                $('#quick_add_words').dropdown('toggle');
            });


            // Delete quick word
            $('.dropdown-menu-menu').on('click', 'button', function(e) {
                e.stopPropagation();
                var user_id = $('input[name=user_id]').val();
                var parent_element = $(this).parent();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    cache: false,
                    type: 'POST',
                    url: `/admin/chat/delete_quick_word`,
                    data: {
                        'user_id': user_id,
                        'word': $(this).parent().find('a').html(),
                    },
                    success: function(result) {
                        parent_element.remove();
                    },
                    error: function(xhr, status, error) {
                        console.log('Произошла ошибка при обновлении статуса: ' +
                            error);
                    }

                });

            });

            /// Add new quick word
            $('#new_quick_button').on('click', function(e) {
                e.stopPropagation();

                if ($('#new_quick_word').val().length > 0) {

                    var user_id = $('input[name=user_id]').val();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        cache: false,
                        type: 'POST',
                        url: `/admin/chat/add_quick_word`,
                        data: {
                            'user_id': user_id,
                            'word': $('#new_quick_word').val(),
                        },
                        success: function(result) {
                            if (result != 'Failed') {
                                $('.dropdown-menu-menu').append(
                                    '<div class="d-flex flex-col justify-content-center align-items-center"><a class="dropdown-item" href="#">' +
                                    $('#new_quick_word').val() +
                                    '</a><button type="button" class="btn btn-light-grey btn-icon btn-sm"><i class="flaticon-delete"></i></button>&nbsp;</div>'
                                );
                            }
                            $('#new_quick_word').val('');
                        },
                        error: function(xhr, status, error) {
                            console.log('Произошла ошибка при обновлении статуса: ' +
                                error);
                        }

                    });

                }
            });

        });
    </script>
@endsection
