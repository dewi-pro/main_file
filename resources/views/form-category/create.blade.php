{!! Form::open([
    'route' => 'form-category.store',
    'method' => 'Post',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="form-group">
        {{ Form::label('type_id', __('Type'), ['class' => 'form-label']) }}
        {{ Form::select('type_id', $type,null,
                ['class' => 'custom_select form-select', 'id' => 'type_id', 'data-trigger']) }}
    </div>
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
        {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        {!! Html::link(route('form-category.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
