@extends('admin.layouts.app')

@section('content')

    @subheader
    Полезные ресурсы
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
                                {{$row->id}}
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
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$row->title['ky']!!}</span>
                                </div>                                   
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Кыска мазмуну</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$row->desc['ky']!!}</span>
                                </div>                                   
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Мазмуну</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$row->content['ky']!!}</span>
                                </div>                                   
                            </div>
                        </div>
                        <div class="tab-pane" id="russian" role="tabpanel">
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Название</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$row->title['ru']!!}</span>
                                </div>                                    
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Описание</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$row->desc['ru']!!}</span>
                                </div>                                    
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Контент</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$row->content['ru']!!}</span>
                                </div>                                    
                            </div>
                        </div>
                        <div class="tab-pane" id="english" role="tabpanel">
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Title</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$row->title['en']!!}</span>
                                </div>                                    
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Desc</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$row->desc['en']!!}</span>
                                </div>                                    
                            </div>
                            <div class="m-widget13">
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">Content</span>
                                    <span class="m-widget13__text text-dark m--font-bolder">{!!$row->content['en']!!}</span>
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
                                @if ($row->getMedia('resource_thumb')->last())
                                <img class="img-fluid rounded" src="{{asset($row->getMedia('resource_thumb')->last()->getUrl('resource_middle'))}}">
                                @endif
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Галерея
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                <div class="row align-items-center">
                                    @foreach ($row->getMedia('resource_gallery') as $media)
                                    <div class="col-md-3 mb-4">
                                        <img class="img-fluid rounded" src="{{asset($media->getUrl('resource_gallery_thumb'))}}" />
                                    </div>
                                    @endforeach
                                </div>
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Просмотры
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                <div class="row align-items-center">
                                    {{$row->getView()}}
                                </div>
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Опубликовал
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                <div class="row align-items-center">
                                    {{$row->getAuthor->name}}
                                </div>
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Дата
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                <div class="row align-items-center">
                                    {{$row->getCreatedDate()}}
                                </div>
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Статус
                            </span>
                            <span class="m-widget13__text text-dark m--font-bolder">
                                {!! $row->getStatus() !!}
                            </span>
                        </div>

                        <div class="m-widget13__action m--align-right">
                            <a href="{{route('resources.index')}}" class="m-widget__detalis btn btn-secondary">
                                Назад
                            </a>
                            <a href="{{route('resources.edit', $row)}}" class="m-widget__detalis btn btn-info">
                                Редактировать
                            </a>
                            <a href="{{route('resources.destroy', $row)}}" class="btn btn-danger">
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
