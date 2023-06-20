<div class="card-body">
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Название (на русском):</label>
        <div class="col-lg-4">
            {!! Form::text('nameRu', null, ['class' => 'form-control '.$errors->first('nameRu', 'is-invalid').'']) !!}
            @if ($errors->has('nameRu'))
                <div class="invalid-feedback">{{ $errors->first('nameRu') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Название (на кыргызском):</label>
        <div class="col-lg-4">
            {!! Form::text('nameKg', null, ['class' => 'form-control '.$errors->first('nameKg', 'is-invalid').'']) !!}
            @if ($errors->has('nameKg'))
                <div class="invalid-feedback">{{ $errors->first('nameKg') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Страна:</label>
        <div class="col-lg-4">
            {!! Form::select('country', $countries, null, ['class' => 'selectpicker form-control '.$errors->first('country', 'is-invalid').'', 'title' => 'Выбрать', 'data-width' => '100%', 'data-size' => '6']) !!}
                @if ($errors->has('country'))
                    <div class="invalid-feedback">{{ $errors->first('country') }}</div>
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
