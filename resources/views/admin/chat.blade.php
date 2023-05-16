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
                            <div class="mt-7 scroll scroll  -pull">
                                @if($chats)
                                    @foreach($chats as $chat)
                                        <!--begin:User-->
                                        <div class="rounded d-flex align-items-center justify-content-between p-4 @if($selected_chat && $selected_chat->id == $chat->id) bg-light-primary @endif">
                                            <div class="d-flex align-items-center">
                                                @if($chat->user->avatar)
                                                <div class="symbol symbol-circle symbol-50 mr-3">
                                                    <img alt="Pic" src="{{asset($chat->user->avatar)}}" />
                                                </div>
                                                @endif
                                                <div class="d-flex flex-column">
                                                    <a href="{{route('admin.chat', ['id' => $chat->id])}}" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">{{$chat->user->getFullName()}}</a>
                                                    <span class="text-muted font-weight-bold font-size-sm">{{$chat->vacancy ? $chat->vacancy->name : ''}}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-end">
                                                <span class="text-muted font-weight-bold font-size-sm">35 mins</span>
                                                @if($chat->messages->where('user_id', '<>', auth()->user()->id)->where('read', false)->count() > 0)
                                                    <span class="label label-sm label-success">
                                                        {{$chat->messages->where('user_id', '<>', auth()->user()->id)->where('read', false)->count()}}
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
                                @if($selected_chat)
                                    {{$selected_chat->user->getFullName()}}
                                    <span class="text-muted">({{$selected_chat->vacancy ? $selected_chat->vacancy->name : ''}})</span>
                                @endif
                            </div>
                            <div class="text-right flex-grow-1">
                                @if($selected_chat)
                                    <!--begin::Dropdown Menu-->
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="svg-icon svg-icon-lg">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <circle fill="#000000" cx="12" cy="5" r="2"/>
                                                        <circle fill="#000000" cx="12" cy="12" r="2"/>
                                                        <circle fill="#000000" cx="12" cy="19" r="2"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </button>
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-md">
                                            <!--begin::Navigation-->
                                            <ul class="navi navi-hover py-5">
                                                <li class="navi-item">
                                                    <a href="{{route('admin.chat.delete', $selected_chat)}}" class="navi-link">
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
                        <div class="card-body h-500px">
                            <!--begin::Scroll-->
                            <div class="scroll scroll-pull" data-mobile-height="350">
                                <!--begin::Messages-->
                                <div class="messages">

                                    @if($selected_chat && $selected_chat->messages)
                                        @foreach($selected_chat->messages as $message)
                                            @if($message->user_id == auth()->user()->id)
                                                <!--begin::Message Out-->
                                                <div class="d-flex flex-column mb-5 align-items-end">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <span class="text-muted font-size-sm">{{$message->getCreatedDateTime()}}</span>
                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Вы</a>
                                                        </div>
                                                        @if(auth()->user()->avatar)
                                                            <div class="symbol symbol-circle symbol-40 ml-3">
                                                                <img alt="Pic" src="{{asset(auth()->user()->avatar)}}" />
                                                            </div>
                                                        @else
                                                            <div class="symbol symbol-circle symbol-40 ml-3">
                                                                <img alt="Pic" src="{{asset('assets/media/users/default.jpg')}}" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                                                        {{$message->message}}
                                                    </div>
                                                </div>
                                                <!--end::Message Out-->
                                            @else
                                                <!--begin::Message In-->
                                                <div class="d-flex flex-column mb-5 align-items-start">
                                                    <div class="d-flex align-items-center">
                                                        @if($message->user->avatar)
                                                            <div class="symbol symbol-circle symbol-40 mr-3">
                                                                <img alt="Pic" src="{{asset($message->user->avatar)}}" />
                                                            </div>
                                                        @else
                                                            <div class="symbol symbol-circle symbol-40 mr-3">
                                                                <img alt="Pic" src="{{asset('assets/media/users/default.jpg')}}" />
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{{$message->user->getFullName()}}</a>
                                                            <span class="text-muted font-size-sm">{{$message->getCreatedDateTime()}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                                        {{$message->message}}
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
                            @if($selected_chat && $selected_chat->messages)
                                {!! Form::open(['route' => ['admin.chat.message', $selected_chat], 'enctype' => 'multipart/form-data', 'class' => 'form']) !!}
                                    <input type="hidden" name="chat_id" value="{{$selected_chat->id}}">
                                    <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                    <!--begin::Compose-->
                                    <textarea class="form-control border-0 p-0" rows="2" placeholder="Написать сообщение" name="message"></textarea>
                                    <div class="d-flex align-items-center justify-content-between mt-5">
                                        <div class="ml-auto">
                                            <button type="submit" class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">Send</button>
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

@endsection

@section('scripts')
    <script></script>
@endsection

