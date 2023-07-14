<div class="card-body">
    <div class="mb-15">
        <div class="form-group row">
            <label class="col-3 mt-2" for="name">Изображение</label>
            <div class="col-9">
                <div class="image-input image-input-outline bg-gray-100" id="kt_image_2">
                    <div class="image-input-wrapper"
                        style="max-width: 100%; width: 200px; height: 200px; @if ($user->avatar) background-image: url({{ asset($user->avatar) }}); @endif background-position: center center;">
                    </div>
                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                        data-action="change" data-toggle="tooltip" title="" data-original-title="Изменить">
                        <i class="la la-pencil icon-sm text-muted"></i>
                        <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                        <input type="hidden" name="image_remove" />
                    </label>

                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                        data-action="cancel" data-toggle="tooltip" title="Удалить">
                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                    </span>

                    @if ($user->avatar)
                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                            data-action="remove" data-toggle="tooltip" title="Удалить" id="avatar_remove">
                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                        </span>
                    @endif
                </div>
                <span class="form-text text-muted">Допустимые разрешения: png, jpg, jpeg.</span>
                <span class="form-text text-muted">Рекомендуемый размер файла: 400x400</span>
            </div>
        </div>
        @if ($user->type == 'USER')
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Фамилия: @if ($user->type != 'ADMIN')
                        <span style="color: red">*</span>
                    @endif
                </label>
                <div class="col-lg-4">
                    {!! Form::text('lastname', null, ['class' => 'form-control ' . $errors->first('lastname', 'is-invalid') . '']) !!}
                    @if ($errors->has('lastname'))
                        <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
                    @endif
                </div>
            </div>
        @endif
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">
                @if ($user->type == 'COMPANY')
                    Компания: <span style="color: red">*</span>
            </label>
        @else
            Имя: <span style="color: red">*</span></label>
            @endif ($user->avatar)
            <div class="col-lg-4">
                {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'is-invalid') . '']) !!}
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>
        </div>
        @if ($user->type == 'USER')
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Отчество: </label>
                <div class="col-lg-4">
                    {!! Form::text('surname', null, ['class' => 'form-control']) !!}
                </div>
            </div>
    </div>
    @endif
    @if ($user->type == 'USER')
        <div class="mb-3">
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Пол:
                    <span style="color: red">*</span>
                </label>
                <div class="col-lg-4">
                    {!! Form::select('gender', $sexes, null, [
                        'class' => 'selectpicker form-control ' . $errors->first('gender', 'is-invalid') . '',
                        'title' => 'Выбрать',
                        'data-width' => '100%',
                        'data-size' => '6',
                    ]) !!}
                    @if ($errors->has('gender'))
                        <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @if ($user->type != 'ADMIN')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Гражданство: @if ($user->type == 'USER')
                    <span style="color: red">*</span>
                @endif
            </label>
            <div class="col-lg-4">
                {!! Form::select('citizen', $citizenship, null, [
                    'class' => 'selectpicker form-control ' . $errors->first('citizen', 'is-invalid'),
                    'title' => 'Выбрать',
                    'data-width' => '100%',
                    'data-live-search' => 'true',
                    'data-size' => '6',
                ]) !!}
                @if ($errors->has('citizen'))
                    <div class="invalid-feedback">{{ $errors->first('citizen') }}</div>
                @endif
            </div>
        </div>
    @endif
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Тип пользователя:</label>
        <div class="col-lg-4">
            {!! Form::select('type', $types, null, [
                'class' => 'selectpicker',
                'title' => 'Выбрать',
                'data-width' => '100%',
                'data-size' => '6',
                'disabled' => 'true',
            ]) !!}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Email: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::email('email', null, ['class' => 'form-control ' . $errors->first('email', 'is-invalid') . '']) !!}
            @if ($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Пароль: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::password('password', ['class' => 'form-control ' . $errors->first('password', 'is-invalid') . '']) !!}
            @if ($errors->has('password'))
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>
    </div>
    @if ($user->type != 'ADMIN')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Телефон: @if ($user->type != 'ADMIN')
                    <span style="color: red">*</span>
                @endif
            </label>
            <div class="col-lg-4">
                {!! Form::text('phone_number', null, [
                    'class' => 'phone_number form-control ' . $errors->first('phone_number', 'is-invalid'),
                ]) !!}
                @if ($errors->has('phone_number'))
                    <div class="invalid-feedback">{{ $errors->first('phone_number') }}</div>
                @endif
            </div>
        </div>
    @endif
    @if ($user->type != 'ADMIN')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Адрес: @if ($user->type == 'USER')
                    <span style="color: red">*</span>
                @endif
            </label>
            <div class="col-lg-4">
                {!! Form::text('address', null, ['class' => 'form-control ' . $errors->first('address', 'is-invalid')]) !!}
                <div id="suggestions" class="position-relative">
                    <ul class="dropdown-menu w-100">
                        <div id="suggestionsLoading" class="text-center">
                            <i class="bx bx-md bx-loader bx-spin bx-flip-vertical"></i>
                        </div>
                    </ul>
                </div>
                @if ($errors->has('address'))
                    <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                @endif
            </div>
        </div>
    @endif
    @if ($user->type != 'ADMIN')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Регион: @if ($user->type == 'USER')
                    <span style="color: red">*</span>
                @endif
            </label>
            <div class="col-lg-4">
                {!! Form::text('region', null, ['class' => 'form-control ' . $errors->first('region', 'is-invalid')]) !!}
                @if ($errors->has('region'))
                    <div class="invalid-feedback">{{ $errors->first('region') }}</div>
                @endif
            </div>
        </div>
    @endif
    @if ($user->type != 'ADMIN')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Город:</label>
            <div class="col-lg-4">
                {!! Form::text('district', null, ['class' => 'form-control ' . $errors->first('district', 'is-invalid')]) !!}
                @if ($errors->has('district'))
                    <div class="invalid-feedback">{{ $errors->first('district') }}</div>
                @endif
            </div>
        </div>
    @endif
    @if ($user->type != 'ADMIN')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Улица:</label>
            <div class="col-lg-4">
                {!! Form::text('street', null, ['class' => 'form-control ' . $errors->first('street', 'is-invalid')]) !!}
                @if ($errors->has('street'))
                    <div class="invalid-feedback">{{ $errors->first('street') }}</div>
                @endif
            </div>
        </div>
    @endif
    @if ($user->type != 'ADMIN')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Дом:</label>
            <div class="col-lg-4">
                {!! Form::text('house', null, ['class' => 'form-control ' . $errors->first('house', 'is-invalid')]) !!}
                @if ($errors->has('house'))
                    <div class="invalid-feedback">{{ $errors->first('house') }}</div>
                @endif
            </div>
        </div>
    @endif
    @if ($user->type == 'USER')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Дата рождения: @if ($user->type != 'ADMIN')
                    <span style="color: red">*</span>
                @endif
            </label>
            <div class="col-lg-4">
                {!! Form::text('birth_date', null, [
                    'readonly' => 'true',
                    'class' => 'datepicker form-control ' . $errors->first('birth_date', 'is-invalid'),
                ]) !!}
                @if ($errors->has('birth_date'))
                    <div class="invalid-feedback">{{ $errors->first('birth_date') }}</div>
                @endif
            </div>
        </div>
    @endif
    @if ($user->type == 'USER')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Возраст:</label>
            <div class="col-lg-4">
                {!! Form::text('age', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
            </div>
        </div>
    @endif
    @if ($user->type == 'USER')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Интересуемые вакансии:</label>
            <div class="col-lg-4">
                {!! Form::select('vacancy_type', $vacancy_types, null, [
                    'class' => 'selectpicker form-control',
                    'placeholder' => 'Любой',
                    'data-width' => '100%',
                    'data-size' => '6',
                ]) !!}
            </div>
        </div>
    @endif
    @if ($user->type == 'USER')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Вид занятости:</label>
            <div class="col-lg-4">
                {!! Form::select('business', $businesses, null, [
                    'class' => 'selectpicker form-control',
                    'placeholder' => 'Любой',
                    'data-width' => '100%',
                    'data-size' => '6',
                ]) !!}
            </div>
        </div>
    @endif
    @if ($user->type == 'COMPANY')
    <div class="form-group row align-items-center">
        <label class="col-lg-3 col-form-label">Разрешить доступ к разделу Приглашения:</label>
        <div class="col-lg-4">
            <div class="checkbox-inline">
                <label class="checkbox">
                    {!! Form::hidden('invitation_enabled', 0) !!}
                    {!! Form::checkbox('invitation_enabled', 1, null, ['id' => 'invitation_enabled']) !!}
                    <span></span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label text-danger">Количество открытий контактов (оплачено):</label>
        <div class="col-lg-4">
            @if($user->invitation_enabled == 0)
            {!! Form::number('invitation_count', null, [
                'class' => 'form-control',
                'min' => 0,
                'onkeypress' => 'return event.charCode >= 48',
                'placeholder' => '0',
                'disabled' => true,
            ]) !!}
            @else
            {!! Form::number('invitation_count', null, [
                'class' => 'form-control',
                'min' => 0,
                'onkeypress' => 'return event.charCode >= 48',
                'placeholder' => '0',
                'disabled' => false,
            ]) !!}
            @endif
        </div>
    </div>
</div>
@endif
{!! Form::hidden('type', $user->type) !!}
<div class="card-footer">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <button type="submit" class="btn btn-success mr-2">Сохранить</button>
            <button type="reset" class="btn btn-secondary" onclick="window.history.back();">Отмена</button>
        </div>
    </div>
</div>
