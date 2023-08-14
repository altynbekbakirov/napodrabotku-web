<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head><base href="">
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') Админ Панель - ishtapp</title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />

    <style>
        body{
            font-family: 'Ubuntu', sans-serif;
        }
        .dropdown-item{
            white-space: normal;
        }
    </style>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css">

    <script src="https://api-maps.yandex.ru/2.1/?apikey=d88902f6-178b-4bba-82ed-0a1f4707031d
&lang=ru_RU" type="text/javascript">
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" style="background-image: url({{asset('assets/media/bg/bg-10.jpg')}})" class="quick-panel-right demo-panel-right offcanvas-right header-fixed page-loading">
<!--begin::Main-->

@include('admin.partials.mobile-header')

<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            @include('admin.partials.header')

            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                @yield('content')

            </div>
            <!--end::Content-->

            @include('admin.partials.footer')

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24" />
                <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>
</div>
<!--end::Scrolltop-->

<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Ubuntu" };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{asset('assets/js/pages/widgets.js')}}"></script>
<!--end::Page Scripts-->

<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
{{-- <script src="{{ asset('assets/js/pages/custom/chat/chat.js') }}"></script> --}}

<script src="{{asset('js/js.pusher.com_8.2.0_pusher.min.js')}}"></script>

<script>

    const chatLabel = $('#chat_label');
    const messagesContainer = $('#messages');
    const scrollContainer = $('#messages-scroll');

    Pusher.logToConsole = true;

    const pusher = new Pusher('73e14d3cf78debd02655', {
        cluster: 'ap2'
    });

    const channelChat = pusher.subscribe('chat');

    let chat_id = 0;
    let auth_user_id = {{auth()->user()->id}};
    @if(isset($selected_chat) && $selected_chat)
        chat_id = {{$selected_chat->id}};
    @endif

    channelChat.bind('new-message-sent', function(data) {

        if(chat_id > 0 && chat_id === data.chat_id){
            let messageContent = `<div class="d-flex flex-column mb-5 align-items-start">
                    <div class="d-flex align-items-center">`;

            if(data.avatar){
                messageContent += `<div class="symbol symbol-circle symbol-40 mr-3">
                                <img alt="Pic" src="//{{$_SERVER['SERVER_NAME']}}/${data.avatar}" />
                            </div>`;
            } else {
                messageContent += `<div class="symbol symbol-circle symbol-40 mr-3">
                                <img alt="Pic" src="{{ asset('assets/media/users/default.jpg') }}" />
                            </div>`;
            }

            messageContent += `<div>
                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">${data.username}</a>
                                    <span class="text-muted font-size-sm">${data.created_at}</span>
                            </div>
                        </div>
                    <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                        ${data.message}
                    </div>
                </div>`;

            messagesContainer.append(messageContent);
            scrollContainer.scrollTop(scrollContainer[0].scrollHeight);
            KTUtil.scrollUpdate(scrollContainer);
        } else {
            if(auth_user_id !== data.sender_id){
                if(chatLabel.find('.label').length > 0) {
                    let chatCounter = parseInt(chatLabel.find('.label').text());
                    console.log(chatCounter)
                    chatLabel.find('.label').text(chatCounter+1);
                } else {
                    chatLabel.append(`<span class="label label-danger label-inline font-weight-bold">1</span>`);
                }
            }
        }
    });
</script>

@yield('scripts')

</body>
<!--end::Body-->
</html>
