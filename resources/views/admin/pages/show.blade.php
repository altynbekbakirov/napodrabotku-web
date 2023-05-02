@extends('admin.layouts.app')

@section('content')

    @subheader
    Страница
    @endsubheader

    @content
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{$page->id}}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--success" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#kyrgyz" role="tab">
                                Кыргызча
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#russian" role="tab">
                                Русский
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#english" role="tab">
                                English
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content m-tab-content">
                        <div class="tab-pane active" id="kyrgyz" role="tabpanel">
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Аталышы</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$page->title['ky']!!}</span>
                                </div>                                   
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Кыска мазмуну</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$page->desc['ky']!!}</span>
                                </div>                                   
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Мазмуну</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$page->content['ky']!!}</span>
                                </div>                                   
                            </div>
                        </div>
                        <div class="tab-pane" id="russian" role="tabpanel">
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Название</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$page->title['ru']!!}</span>
                                </div>                                    
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Описание</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$page->desc['ru']!!}</span>
                                </div>                                    
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Контент</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$page->content['ru']!!}</span>
                                </div>                                    
                            </div>
                        </div>
                        <div class="tab-pane" id="english" role="tabpanel">
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Title</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$page->title['en']!!}</span>
                                </div>                                    
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Desc</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$page->desc['en']!!}</span>
                                </div>                                    
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Content</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$page->content['en']!!}</span>
                                </div>                                    
                            </div>
                        </div>
                    </div>
                    <div class="m-widget13">                                                       
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Миниатюра
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                @if ($page->getMedia('page_thumb')->last())
                                <img class="img-fluid rounded" src="{{asset($page->getMedia('page_thumb')->last()->getUrl('page_middle'))}}">
                                @endif
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Галерея
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                <div class="row align-items-center">
                                    @foreach ($page->getMedia('page_gallery') as $media)
                                    <div class="col-md-3 mb-4">
                                        <img class="img-fluid rounded" src="{{asset($media->getUrl('page_gallery_thumb'))}}" />
                                    </div>
                                    @endforeach
                                </div>
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Url
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                <div class="row align-items-center">
                                    {{$page->url}}
                                </div>
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Дата
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                <div class="row align-items-center">
                                    {{$page->getCreatedDate()}}
                                </div>
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Статус
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                {!! $page->getStatus() !!}
                            </span>
                        </div>

                        <div class="m-widget13__action m--align-right">
                            <a href="{{route('pages.index')}}" class="m-widget__detalis btn btn-secondary">
                                Назад
                            </a>
                            <a href="{{route('pages.edit', $page)}}" class="m-widget__detalis btn btn-info">
                                Редактировать
                            </a>
                            <a href="{{route('pages.destroy', $page)}}" class="btn btn-danger">
                                Удалить
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    @endcontent

@endsection
