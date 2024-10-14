{!! Form::open([
    'route' => 'roles.store',
    'method' => 'Post',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'required', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {{ Form::label('category', __('Category'), ['class' => 'form-label']) }}
            {!! Form::select('category', $categories, null, ['class' => 'form-control','data-trigger', 'required']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
