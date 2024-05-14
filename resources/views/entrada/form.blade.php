<div class="form-group mb-3">
    {{ Form::hidden('usuario_id', $entrada->usuario_id) }}
    {{ Form::hidden('categoria_id', $entrada->categoria_id) }}
    {{ Form::hidden('fecha', $entrada->fecha) }}
<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('titulo') }}</label>
    <div>
        {{ Form::text('titulo', $entrada->titulo, ['class' => 'form-control' . ($errors->has('titulo') ? ' is-invalid' : ''), 'placeholder' => 'Titulo']) }}
        {!! $errors->first('titulo', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">entrada <b>titulo</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('imagen') }}</label>
    <div>
        {{ Form::file('imagen', ['class' => 'form-control' . ($errors->has('imagen') ? ' is-invalid' : '')]) }}
        {!! $errors->first('imagen', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">entrada <b>imagen</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('descripcion') }}</label>
    <div>
        {{ Form::text('descripcion', $entrada->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">entrada <b>descripcion</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('fecha') }}</label>
    <div>
        {{ Form::text('fecha', $entrada->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha', 'disabled']) }}
        {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">entrada <b>fecha</b> instruction.</small>
    </div>
</div>

<div class="form-footer">
    <div class="text-end">
        <div class="d-flex">
            <a href="#" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-primary ms-auto ajax-submit">Submit</button>
        </div>
    </div>
</div>
