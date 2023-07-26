<div class="card-body">
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Название:</label>
        <div class="col-lg-4">
            {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'is-invalid')]) !!}
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
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
