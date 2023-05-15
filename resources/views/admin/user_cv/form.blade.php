<div class="card-body">
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Название вакансии: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('vacancy_id', $vacancies, null, ['class' => 'selectpicker '.$errors->first('vacancy_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('vacancy_id'))
                <div class="invalid-feedback">{{ $errors->first('vacancy_id') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Страна вакансии:</label>
        <div class="col-lg-4">
            {!! Form::text('vacancy_country', null, ['class' => 'form-control', 'readonly' => 'true',]) !!}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Регион вакансии:</label>
        <div class="col-lg-4">
            {!! Form::text('vacancy_region', null, ['class' => 'form-control', 'readonly' => 'true',]) !!}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Соискатель: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('user_id', $users, null, ['class' => 'selectpicker '.$errors->first('user_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('user_id'))
                <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Гражданство соискателя: </label>
        <div class="col-lg-4">
            {!! Form::text('user_citizen', null, ['class' => 'form-control', 'readonly' => 'true',]) !!}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Возраст соискателя: </label>
        <div class="col-lg-4">
            {!! Form::text('user_age', null, ['class' => 'form-control', 'readonly' => 'true',]) !!}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Статус отклика: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('status_id', $statuses, null, ['class' => 'selectpicker '.$errors->first('status_id', 'is-invalid').'', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('status_id'))
                <div class="invalid-feedback">{{ $errors->first('status_id') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <button type="submit" class="btn btn-success mr-2">Сохранить</button>
            <button type="reset" class="btn btn-secondary" onclick="window.history.back();">Отмена</button>
        </div>
    </div>
</div>
