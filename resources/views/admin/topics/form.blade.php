<input type="hidden" name="author" value="{{auth()->user()->id}}">
<ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--success" role="tablist">
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#kyrgyz" role="tab">
            Кыргызча
        </a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link " data-toggle="tab" href="#russian" role="tab">
            Русский
        </a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#english" role="tab">
            English
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="kyrgyz" role="tabpanel">
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Аталышы
            </label>
            <div class="col-10">
                {!! Form::text('title[ky]', null, array('class' => 'form-control m-input')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Кыска мазмуну
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('desc[ky]', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Толук мазмуну
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('content[ky]', null, array('class' => 'froala form-control')) !!}
            </div>
        </div>
    </div>
    <div class="tab-pane" id="russian" role="tabpanel">
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Название
            </label>
            <div class="col-10">
                {!! Form::text('title[ru]', null, array('class' => 'form-control m-input')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Описание
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('desc[ru]', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Контент
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('content[ru]', null, array('class' => 'froala form-control')) !!}
            </div>
        </div>
    </div>
    <div class="tab-pane" id="english" role="tabpanel">
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Title
            </label>
            <div class="col-10">
                {!! Form::text('title[en]', null, array('class' => 'form-control m-input')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Desc
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('desc[en]', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Content
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('content[en]', null, array('class' => 'froala form-control')) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-2 col-form-label">
        Миниатюра
    </label>
    <div class="col-6">
        {{-- <div class="fileinput fileinput-new" data-provides="fileinput"> --}}
        <div class="fileinput @if($row->getMedia('topic_thumb')->last()) fileinput-exists @else fileinput-new @endif" data-provides="fileinput">
            @if(!$row->getMedia('topic_thumb')->last())
            <div class="fileinput-new thumbnail"  style="width: 320px; height: 180px;"></div>
            @endif
            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 320px; height: 180px;">
                    @if($row->getMedia('topic_thumb')->last())
                    <img src="{{asset($row->getMedia('topic_thumb')->last()->getUrl('topic_middle'))}}" >
                @endif
            </div>
            <div>
                <span class="btn btn-primary btn-file">
                    <span class="fileinput-new">Выбрать</span>
                    <span class="fileinput-exists">Изменить</span>
                    {!! Form::file('thumb', null) !!}
                </span>
                @if($row->getMedia('topic_thumb')->last())
                    <a href="#" class="btn btn-primary fileinput-exists" id="thumbremove" data-dismiss="fileinput">Удалить</a>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-2 col-lg-2 col-form-label">
        Фото галерея:
    </label>
    <div class="col-xl-10 col-lg-10">
        <div class="needsclick dropzone" id="gallery-dropzone"></div>
    </div>
</div>
<div class="form-group row">
    <label class="col-2 col-form-label">
        На главную
    </label>
    <div class="col-6">
        <div>
            <span class="m-switch m-switch--icon">
                <label>
                    {!! Form::hidden('is_main', 0) !!}
                    {!! Form::checkbox('is_main', 1, null) !!}
                    <span></span>
                </label>
            </span>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-2 col-form-label">
        Статус
    </label>
    <div class="col-6">
        <div>
            <span class="m-switch m-switch--icon">
                <label>
                    {!! Form::hidden('published', 0) !!}
                    {!! Form::checkbox('published', 1, null) !!}
                    <span></span>
                </label>
            </span>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-2 col-lg-2 col-form-label">
    </label>
    <div class="col-xl-10 col-lg-10">
        <div id="post_loader">
            <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
            <div>Идет сохранение ...</div>
        </div>
    </div>
</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions pl-0 pt-4">
        <button type="submit" class="btn btn-primary" id="button">
            Сохранить
        </button>
        <a href="{{route('topics.index')}}" class="btn btn-secondary">
            Назад
        </a>
    </div>
</div>
