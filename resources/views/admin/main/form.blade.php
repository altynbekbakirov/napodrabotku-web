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
                {!! Form::text('name[ky]', null, array('class' => 'form-control m-input')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Кыска мазмуну
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('desc[ky]', null, array('class' => 'form-control', 'row' => '3')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Contacts
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('contacts[ky]', null, array('class' => 'froala form-control')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Copyright
            </label>
            <div class="col-10">
                {!! Form::text('copyright[ky]', null, array('class' => 'form-control m-input')) !!}
            </div>
        </div>
    </div>
    <div class="tab-pane" id="russian" role="tabpanel">
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Название
            </label>
            <div class="col-10">
                {!! Form::text('name[ru]', null, array('class' => 'form-control m-input')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Описание
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('desc[ru]', null, array('class' => 'form-control', 'row' => '3')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Contacts
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('contacts[ru]', null, array('class' => 'froala form-control')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Copyright
            </label>
            <div class="col-10">
                {!! Form::text('copyright[ru]', null, array('class' => 'form-control m-input')) !!}
            </div>
        </div>
    </div>
    <div class="tab-pane" id="english" role="tabpanel">
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Title
            </label>
            <div class="col-10">
                {!! Form::text('name[en]', null, array('class' => 'form-control m-input')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Desc
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('desc[en]', null, array('class' => 'form-control', 'row' => '3')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Contacts
            </label>
            <div class="col-10 froala-content">
                {!! Form::textarea('contacts[en]', null, array('class' => 'froala form-control')) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">
                Copyright
            </label>
            <div class="col-10">
                {!! Form::text('copyright[en]', null, array('class' => 'form-control m-input')) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-2 col-form-label">
        Номер консультации
    </label>
    <div class="col-10 froala-content">
        {!! Form::text('consult', null, array('class' => 'form-control')) !!}
    </div>
</div>
<div id="m_repeater_social">
    <div class="form-group m-form__group row">
        <label class="col-2 col-form-label">Соц. сети</label>
        <div data-repeater-list="socials" class="col-10">
            <div data-repeater-item class="m-separator m-separator--dashed m-0 pb-2" style="height:auto;">
                <div class="row align-items-end">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Icon</label>
                            {!! Form::text('s_icon', null, array('class' => 'form-control m-input')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Ссылка</label>
                            {!! Form::text('s_link', null, array('class' => 'form-control m-input')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Название</label>
                            {!! Form::text('s_name', null, array('class' => 'form-control m-input')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group-append">
                                <a data-repeater-delete class="btn btn-danger m-btn m-btn--custom m-btn--icon" style="color:#fff">
                                    <i class="la la-close"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-2 col-form-label"></label>
        <div class="col-4">
            <div data-repeater-create class="btn btn-outline-primary">
                <span>
                    <i class="la la-plus"></i>
                    <span>
                        Добавить ссылку
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="form-group row mt-4">
    <label class="col-2 col-form-label">
        Лого
    </label>
    <div class="col-6">
        {{-- <div class="fileinput fileinput-new" data-provides="fileinput"> --}}
        <div class="fileinput @if($row->getMedia('main_logo')->last()) fileinput-exists @else fileinput-new @endif" data-provides="fileinput">
            @if(!$row->getMedia('main_logo')->last())
            <div class="fileinput-new thumbnail"  style="width: 320px; height: 180px;"></div>
            @endif
            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 320px; height: 180px;">
                    @if($row->getMedia('main_logo')->last())
                    <img src="{{asset($row->getMedia('main_logo')->last()->getUrl('logo_middle'))}}" >
                @endif
            </div>
            <div>
                <span class="btn btn-primary btn-file">
                    <span class="fileinput-new">Выбрать</span>
                    <span class="fileinput-exists">Изменить</span>
                    {!! Form::file('logo', null) !!}
                </span>
                @if($row->getMedia('main_logo')->last())
                    <a href="#" class="btn btn-primary fileinput-exists" id="thumbremove" data-dismiss="fileinput">Удалить</a>
                @endif
            </div>
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
        <a href="{{route('main.index')}}" class="btn btn-secondary">
            Назад
        </a>
    </div>
</div>