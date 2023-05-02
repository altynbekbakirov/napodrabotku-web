<div class="card-body">
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Название: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::text('name', null, ['class' => 'form-control '.$errors->first('name', 'is-invalid').'']) !!}
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Зарплата: <span style="color: red">*</span></label>
        <div class="col-lg-1">
            {!! Form::text('salary', null, ['class' => 'form-control salary-input '.$errors->first('salary', 'is-invalid').'']) !!}
            @if ($errors->has('salary'))
                <div class="invalid-feedback">{{ $errors->first('salary') }}</div>
            @endif
        </div>
        <div class="col-lg-1">
            {!! Form::select('currency', $currencies, null, ['class' => 'selectpicker '.$errors->first('currency', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('currency'))
                <div class="invalid-feedback">{{ $errors->first('currency') }}</div>
            @endif
        </div>
        <div class="col-lg-2">
            {!! Form::select('period', ['Месяц' => 'Месяц', 'Три месяца' => 'Три месяца', 'Полгода'=>'Полгода', 'Год'=>'Год', 'Более года'=>'Более года'], null, ['class' => 'selectpicker '.$errors->first('period', 'is-invalid').'', 'title' => 'Выберите период', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('period'))
                <div class="invalid-feedback">{{ $errors->first('period') }}</div>
            @endif
        </div>
    </div>
    @if(auth()->user()->type == 'ADMIN')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Компания: <span style="color: red">*</span></label>
            <div class="col-lg-4">
                {!! Form::select('company_id', $companies, auth()->user()->type == 'COMPANY' ? auth()->user()->id : null, ['class' => 'selectpicker '.$errors->first('company_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
                @if ($errors->has('company_id'))
                    <div class="invalid-feedback">{{ $errors->first('company_id') }}</div>
                @endif
            </div>
        </div>
    @else
        {!! Form::hidden('company_id', auth()->user()->id) !!}
    @endif
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Описание: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::textarea('description', null, ['class' => 'form-control '.$errors->first('description', 'is-invalid').'', 'rows' => '6']) !!}
            @if ($errors->has('description'))
                <div class="invalid-feedback">{{ $errors->first('description') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Страна: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('country_id', $countries, null, ['class' => 'selectpicker '.$errors->first('country_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('country_id'))
                <div class="invalid-feedback">{{ $errors->first('country_id') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Выберите регион/область: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('region_id', $regions, null, ['class' => 'selectpicker '.$errors->first('region_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('region_id'))
                <div class="invalid-feedback">{{ $errors->first('region_id') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Выберите город: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('district_id', $districts, null, ['class' => 'selectpicker '.$errors->first('district_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('district_id'))
                <div class="invalid-feedback">{{ $errors->first('district_id') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Выберите вид занятости: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('busyness_id', $busynesses, null, ['class' => 'selectpicker '.$errors->first('busyness_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('busyness_id'))
                <div class="invalid-feedback">{{ $errors->first('busyness_id') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Выберите тип вакансии: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('vacancy_type_id', $vacancy_types, null, ['class' => 'selectpicker '.$errors->first('vacancy_type_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('vacancy_type_id'))
                <div class="invalid-feedback">{{ $errors->first('vacancy_type_id') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Выберите сферу работы: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('job_type_id', $job_types, null, ['class' => 'selectpicker '.$errors->first('job_type_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('job_type_id'))
                <div class="invalid-feedback">{{ $errors->first('job_type_id') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Выберите график работы: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('schedule_id', $schedules, null, ['class' => 'selectpicker '.$errors->first('schedule_id', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('schedule_id'))
                <div class="invalid-feedback">{{ $errors->first('schedule_id') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Укажите требуемый опыт работы: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('experience', ['Без опыта', 'Полгода', 'Более года'], null, ['class' => 'selectpicker '.$errors->first('experience', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('experience'))
                <div class="invalid-feedback">{{ $errors->first('experience') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Частота выплат: <span style="color: red">*</span></label>
        <div class="col-lg-4">
            {!! Form::select('pay_period', ['Ежедневная', 'Еженедельная', 'Ежемесячная'], null, ['class' => 'selectpicker '.$errors->first('pay_period', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-live-search' => 'true', 'data-size' => '6']) !!}
            @if ($errors->has('pay_period'))
                <div class="invalid-feedback">{{ $errors->first('pay_period') }}</div>
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
