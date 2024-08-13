{!! Form::open([
    'route' => 'form-leader.store',
    'method' => 'Post',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
        {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        {!! Html::link(route('form-leader.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
